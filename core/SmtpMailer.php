<?php
class SmtpMailer {
    private $host;
    private $port;
    private $user;
    private $pass;
    private $fromEmail;
    private $fromName;
    private $security;
    private $timeout;

    public function __construct($settings = []) {
        $this->host = $settings['smtp_host'] ?? '';
        $this->port = (int)($settings['smtp_port'] ?? 587);
        $this->user = $settings['smtp_user'] ?? '';
        $this->pass = $settings['smtp_pass'] ?? '';
        $this->fromEmail = $settings['from_email'] ?? $this->user;
        $this->fromName = $settings['from_name'] ?? 'GestoRest';
        $this->security = strtolower($settings['smtp_security'] ?? 'tls');
        $this->timeout = (int)($settings['timeout'] ?? 15);
    }

    public function sendPlainText($toEmail, $subject, $body) {
        if (empty($this->host) || empty($this->user) || empty($this->fromEmail)) {
            return 'Configuración SMTP incompleta. Verifique smtp_host, smtp_user y from_email.';
        }

        if ($this->security === 'ssl') {
            $address = "ssl://{$this->host}:{$this->port}";
        } else {
            $address = "tcp://{$this->host}:{$this->port}";
        }

        $socket = stream_socket_client($address, $errno, $errstr, $this->timeout);
        if (!$socket) {
            error_log("SMTP connection failed to {$this->host}:{$this->port} - [{$errno}] {$errstr}");
            return "No se pudo conectar al servidor SMTP ({$this->host}:{$this->port}): $errstr";
        }

        stream_set_timeout($socket, $this->timeout);

        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '220') {
            fclose($socket);
            return "El servidor SMTP no respondió correctamente: $read";
        }

        $ehloHost = gethostname() ?: 'localhost';
        $this->smtpWrite($socket, "EHLO " . $ehloHost);
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '250') {
            fclose($socket);
            return "EHLO rechazado por el servidor SMTP: $read";
        }

        if ($this->security === 'tls') {
            $this->smtpWrite($socket, 'STARTTLS');
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '220') {
                fclose($socket);
                return "STARTTLS rechazado por el servidor: $read";
            }

            $cryptoEnabled = stream_socket_enable_crypto(
                $socket,
                true,
                STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT
            );

            if ($cryptoEnabled !== true) {
                fclose($socket);
                return 'No se pudo establecer una conexión segura TLS con el servidor SMTP.';
            }

            $this->smtpWrite($socket, "EHLO " . $ehloHost);
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '250') {
                fclose($socket);
                return "EHLO posterior a STARTTLS rechazado: $read";
            }
        }

        if (!empty($this->user) && !empty($this->pass)) {
            $this->smtpWrite($socket, 'AUTH LOGIN');
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '334') {
                fclose($socket);
                return "Error de autenticación SMTP (AUTH LOGIN): $read";
            }

            $this->smtpWrite($socket, base64_encode($this->user));
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '334') {
                fclose($socket);
                return "Error de autenticación SMTP (usuario): $read";
            }

            $this->smtpWrite($socket, base64_encode($this->pass));
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '235') {
                fclose($socket);
                return "Credenciales SMTP inválidas: $read";
            }
        }

        $this->smtpWrite($socket, "MAIL FROM:<{$this->fromEmail}>");
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '250') {
            fclose($socket);
            return "Error en MAIL FROM: $read";
        }

        $this->smtpWrite($socket, "RCPT TO:<{$toEmail}>");
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '250') {
            fclose($socket);
            return "Error en RCPT TO: $read";
        }

        $this->smtpWrite($socket, 'DATA');
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '354') {
            fclose($socket);
            return "Error al iniciar datos: $read";
        }

        $date = date('r');
        $message = $this->buildMessage($toEmail, $subject, $body, $date);

        fwrite($socket, $message);
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '250') {
            fclose($socket);
            return "Error al enviar el mensaje: $read";
        }

        $this->smtpWrite($socket, 'QUIT');
        fclose($socket);

        return true;
    }

    private function buildMessage($toEmail, $subject, $body, $date) {
        $encodedSubject = $this->encodeHeader($subject);
        $encodedFromName = $this->encodeHeader($this->fromName);
        $encodedBody = chunk_split(base64_encode($this->normalizeBody($body)));

        return "Date: {$date}\r\n" .
               "From: {$encodedFromName} <{$this->fromEmail}>\r\n" .
               "To: <{$toEmail}>\r\n" .
               "Subject: {$encodedSubject}\r\n" .
               "MIME-Version: 1.0\r\n" .
               "Content-Type: text/plain; charset=UTF-8\r\n" .
               "Content-Transfer-Encoding: base64\r\n" .
               "\r\n" .
               $encodedBody . "\r\n.\r\n";
    }

    private function normalizeBody($body) {
        $body = str_replace(["\r\n", "\r"], "\n", (string)$body);
        $body = preg_replace('/^\./m', '..', $body);
        return str_replace("\n", "\r\n", $body);
    }

    private function encodeHeader($value) {
        return '=?UTF-8?B?' . base64_encode((string)$value) . '?=';
    }

    private function smtpRead($socket) {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (substr($line, 3, 1) === ' ') {
                break;
            }
        }
        return trim($response);
    }

    private function smtpWrite($socket, $command) {
        fwrite($socket, $command . "\r\n");
    }
}
