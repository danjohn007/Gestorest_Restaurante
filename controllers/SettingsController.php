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

        if (empty($emailSettings['smtp_host']) || empty($emailSettings['smtp_user'])) {
            $this->json(['success' => false, 'message' => 'Configuración SMTP incompleta. Verifique smtp_host y smtp_user en Configurar Correo.']);
            return;
        }

        try {
            $mailer = new SmtpMailer($emailSettings);
            $date = date('r');
            $smtpPort = $emailSettings['smtp_port'] ?? 587;
            $result = $mailer->sendPlainText(
                $toEmail,
                'Correo de Prueba - GestoRest',
                "Este es un correo de prueba enviado desde el sistema GestoRest.\r\n\r\n" .
                "Servidor SMTP: {$emailSettings['smtp_host']}:{$smtpPort}\r\n" .
                "Fecha: {$date}\r\n\r\n" .
                "Si recibiste este mensaje, la configuración SMTP es correcta."
            );

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

}
