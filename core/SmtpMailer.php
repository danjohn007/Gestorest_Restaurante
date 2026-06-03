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
        return $this->send($toEmail, $subject, $body, false);
    }

    public function sendHtml($toEmail, $subject, $htmlBody, $ccEmails = []) {
        return $this->send($toEmail, $subject, $htmlBody, true, $ccEmails);
    }

    private function send($toEmail, $subject, $body, $isHtml = false, $ccEmails = []) {
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

        // Add CC recipients
        foreach ($ccEmails as $ccEmail) {
            if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                $this->smtpWrite($socket, "RCPT TO:<{$ccEmail}>");
                $read = $this->smtpRead($socket);
                if (substr($read, 0, 3) !== '250') {
                    // Log error but continue with other recipients
                    error_log("Error adding CC recipient {$ccEmail}: $read");
                }
            }
        }

        $this->smtpWrite($socket, 'DATA');
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '354') {
            fclose($socket);
            return "Error al iniciar datos: $read";
        }

        $date = date('r');
        $message = $this->buildMessage($toEmail, $subject, $body, $date, $isHtml, $ccEmails);

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

    private function buildMessage($toEmail, $subject, $body, $date, $isHtml = false, $ccEmails = []) {
        $encodedSubject = $this->encodeHeader($subject);
        $encodedFromName = $this->encodeHeader($this->fromName);
        
        $headers = "Date: {$date}\r\n" .
                   "From: {$encodedFromName} <{$this->fromEmail}>\r\n" .
                   "To: <{$toEmail}>\r\n";
        
        // Add CC headers
        if (!empty($ccEmails)) {
            $ccList = [];
            foreach ($ccEmails as $ccEmail) {
                if (!empty($ccEmail) && filter_var($ccEmail, FILTER_VALIDATE_EMAIL)) {
                    $ccList[] = "<{$ccEmail}>";
                }
            }
            if (!empty($ccList)) {
                $headers .= "Cc: " . implode(', ', $ccList) . "\r\n";
            }
        }
        
        $headers .= "Subject: {$encodedSubject}\r\n" .
                   "MIME-Version: 1.0\r\n";
        
        $encodedBody = chunk_split(base64_encode($this->normalizeBody($body)));
        
        if ($isHtml) {
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n" .
                       "Content-Transfer-Encoding: base64\r\n";
        } else {
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n" .
                       "Content-Transfer-Encoding: base64\r\n";
        }
        
        return $headers . "\r\n" . $encodedBody . "\r\n.\r\n";
    }

    private function normalizeBody($body) {
        $body = str_replace(["\r\n", "\r"], "\n", (string)$body);
        // RFC 5321 dot-stuffing: escape body lines that start with "." so SMTP DATA does not terminate early.
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
