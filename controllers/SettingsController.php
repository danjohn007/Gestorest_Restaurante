<?php
class SettingsController extends BaseController {
    private $globalSettingModel;
    private $actionLogModel;
    private $errorLogModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->requireRole([ROLE_ADMIN, ROLE_SUPERADMIN]);
        $this->globalSettingModel = new GlobalSetting();
        $this->actionLogModel = new ActionLog();
        $this->errorLogModel = new ErrorLog();
    }
    
    public function index() {
        $settings = $this->globalSettingModel->getAllGrouped();
        $this->view('settings/index', ['settings' => $settings]);
    }
    
    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('settings');
            return;
        }
        
        $group = $_POST['group'] ?? 'general';
        $fields = $_POST['fields'] ?? [];
        
        if ($group === 'btn_pedidos') {
            // Build the per-role/per-module config and persist it as a single JSON entry.
            // All known roles are iterated so that unchecked roles result in an empty module list.
            $allRoles = [ROLE_ADMIN, ROLE_WAITER, ROLE_CASHIER, ROLE_SUPERADMIN];
            $submitted = isset($fields['btn_pedidos_config']) && is_array($fields['btn_pedidos_config'])
                ? $fields['btn_pedidos_config']
                : [];
            $config = [];
            foreach ($allRoles as $role) {
                $config[$role] = (isset($submitted[$role]) && is_array($submitted[$role]))
                    ? array_values($submitted[$role])
                    : [];
            }
            $this->globalSettingModel->set('btn_pedidos_config', json_encode($config), $group);
        } else {
            foreach ($fields as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode(array_values($value));
                }
                $this->globalSettingModel->set($key, $value, $group);
            }
        }
        
        $user = $this->getCurrentUser();
        $this->actionLogModel->log($user['id'], 'update_settings', 'settings', null, "Actualizó configuración: $group");
        
        $this->redirect('settings', 'success', 'Configuración guardada correctamente');
    }
    
    public function logs() {
        $filters = [
            'date_from' => $_GET['date_from'] ?? date('Y-m-d'),
            'date_to' => $_GET['date_to'] ?? date('Y-m-d'),
            'action' => $_GET['action'] ?? ''
        ];
        $logs = $this->actionLogModel->getLogsWithDetails($filters);
        $this->view('settings/logs', ['logs' => $logs, 'filters' => $filters]);
    }
    
    public function errors() {
        $errors = $this->errorLogModel->getRecentErrors(200);
        $this->view('settings/errors', ['errors' => $errors]);
    }
    
    public function clearErrors() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('settings/errors');
            return;
        }
        $this->errorLogModel->clearAll();
        $this->redirect('settings/errors', 'success', 'Registro de errores limpiado');
    }

    public function testEmail() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Método no permitido'], 405);
            return;
        }

        $toEmail = trim($_POST['to_email'] ?? '');
        if (empty($toEmail) || !filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            $this->json(['success' => false, 'message' => 'Email de destino inválido']);
            return;
        }

        $emailSettings = $this->globalSettingModel->getByGroup('email');
        $smtpHost = $emailSettings['smtp_host'] ?? '';
        $smtpPort = (int)($emailSettings['smtp_port'] ?? 587);
        $smtpUser = $emailSettings['smtp_user'] ?? '';
        $smtpPass = $emailSettings['smtp_pass'] ?? '';
        $fromEmail = $emailSettings['from_email'] ?? $smtpUser;
        $fromName  = $emailSettings['from_name'] ?? 'GestoRest';
        $security  = strtolower($emailSettings['smtp_security'] ?? 'tls');

        if (empty($smtpHost) || empty($smtpUser)) {
            $this->json(['success' => false, 'message' => 'Configuración SMTP incompleta. Verifique smtp_host y smtp_user en Configurar Correo.']);
            return;
        }

        try {
            $result = $this->sendSmtpTestEmail($smtpHost, $smtpPort, $smtpUser, $smtpPass, $fromEmail, $fromName, $toEmail, $security);
            if ($result === true) {
                $user = $this->getCurrentUser();
                $this->actionLogModel->log($user['id'], 'test_email', 'settings', null, "Correo de prueba enviado a: $toEmail");
                $this->json(['success' => true, 'message' => "Correo de prueba enviado correctamente a $toEmail"]);
            } else {
                $this->json(['success' => false, 'message' => $result]);
            }
        } catch (Exception $e) {
            $this->json(['success' => false, 'message' => 'Error al enviar: ' . $e->getMessage()]);
        }
    }

    private function sendSmtpTestEmail($host, $port, $user, $pass, $fromEmail, $fromName, $toEmail, $security) {
        $timeout = 15;

        if ($security === 'ssl') {
            $address = "ssl://{$host}:{$port}";
        } else {
            $address = "tcp://{$host}:{$port}";
        }

        $socket = stream_socket_client($address, $errno, $errstr, $timeout);
        if (!$socket) {
            error_log("SMTP connection failed to {$host}:{$port} - [{$errno}] {$errstr}");
            return "No se pudo conectar al servidor SMTP ({$host}:{$port}): $errstr";
        }

        // Set timeout for subsequent read/write operations on the stream
        stream_set_timeout($socket, $timeout);

        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '220') {
            fclose($socket);
            return "El servidor SMTP no respondió correctamente: $read";
        }

        $ehloHost = gethostname() ?: 'localhost';
        $this->smtpWrite($socket, "EHLO " . $ehloHost);
        $read = $this->smtpRead($socket);

        if ($security === 'tls') {
            $this->smtpWrite($socket, "STARTTLS");
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '220') {
                fclose($socket);
                return "STARTTLS rechazado por el servidor: $read";
            }
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLSv1_2_CLIENT | STREAM_CRYPTO_METHOD_TLSv1_3_CLIENT);
            $this->smtpWrite($socket, "EHLO " . $ehloHost);
            $this->smtpRead($socket);
        }

        if (!empty($user) && !empty($pass)) {
            $this->smtpWrite($socket, "AUTH LOGIN");
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '334') {
                fclose($socket);
                return "Error de autenticación SMTP (AUTH LOGIN): $read";
            }
            $this->smtpWrite($socket, base64_encode($user));
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '334') {
                fclose($socket);
                return "Error de autenticación SMTP (usuario): $read";
            }
            $this->smtpWrite($socket, base64_encode($pass));
            $read = $this->smtpRead($socket);
            if (substr($read, 0, 3) !== '235') {
                fclose($socket);
                return "Credenciales SMTP inválidas: $read";
            }
        }

        $this->smtpWrite($socket, "MAIL FROM:<{$fromEmail}>");
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

        $this->smtpWrite($socket, "DATA");
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '354') {
            fclose($socket);
            return "Error al iniciar datos: $read";
        }

        $date    = date('r');
        $subject = '=?UTF-8?B?' . base64_encode('Correo de Prueba - GestoRest') . '?=';
        $body    = "Este es un correo de prueba enviado desde el sistema GestoRest.\r\n\r\n" .
                   "Servidor SMTP: {$host}:{$port}\r\n" .
                   "Fecha: {$date}\r\n\r\n" .
                   "Si recibiste este mensaje, la configuración SMTP es correcta.";

        $message = "Date: {$date}\r\n" .
                   "From: {$fromName} <{$fromEmail}>\r\n" .
                   "To: <{$toEmail}>\r\n" .
                   "Subject: {$subject}\r\n" .
                   "MIME-Version: 1.0\r\n" .
                   "Content-Type: text/plain; charset=UTF-8\r\n" .
                   "Content-Transfer-Encoding: 8bit\r\n" .
                   "\r\n" .
                   $body . "\r\n.\r\n";

        fwrite($socket, $message);
        $read = $this->smtpRead($socket);
        if (substr($read, 0, 3) !== '250') {
            fclose($socket);
            return "Error al enviar el mensaje: $read";
        }

        $this->smtpWrite($socket, "QUIT");
        fclose($socket);

        return true;
    }

    private function smtpRead($socket) {
        $response = '';
        // RFC 5321: max line length is 512 bytes + CRLF; read 515 bytes per line to handle multi-line responses
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
