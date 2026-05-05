<?php
class SettingsController extends BaseController {
    private $settingsModel;

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->requireRole([ROLE_ADMIN]);
        $this->settingsModel = new SystemSettings();
    }

    public function index() {
        $settings = $this->settingsModel->getAllSettings();
        $this->view('settings/index', ['settings' => $settings]);
    }

    public function save() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('settings');
            return;
        }

        $allowedKeys = [
            'site_name', 'site_logo', 'mail_from', 'mail_name',
            'contact_phone_1', 'contact_phone_2', 'business_hours_open', 'business_hours_close',
            'primary_color', 'secondary_color',
            'paypal_client_id', 'paypal_secret', 'paypal_mode',
            'qr_api_key',
            'shelly_cloud_token', 'hikvision_host', 'hikvision_user', 'hikvision_pass',
            'chatbot_whatsapp_token', 'chatbot_phone_number_id',
            'gps_tracker_api_key', 'gps_tracker_url',
            'collections_enabled', 'inventory_enabled', 'auto_deduct_inventory',
        ];

        $saved = 0;
        foreach ($allowedKeys as $key) {
            if (isset($_POST[$key])) {
                $this->settingsModel->setSetting($key, trim($_POST[$key]));
                $saved++;
            }
        }

        // Handle logo upload
        if (!empty($_FILES['site_logo_file']['name'])) {
            $logoPath = $this->handleLogoUpload($_FILES['site_logo_file']);
            if ($logoPath) {
                $this->settingsModel->setSetting('site_logo', $logoPath);
            }
        }

        $this->logAction('update_settings', 'settings', 'Configuraciones globales actualizadas (' . $saved . ' campos)');
        $this->redirect('settings', 'success', 'Configuraciones guardadas correctamente');
    }

    public function logs() {
        $date   = $_GET['date'] ?? null;
        $module = $_GET['module'] ?? null;
        $limit  = min(intval($_GET['limit'] ?? 100), 500);

        $query = "SELECT al.*, u.name AS user_display
                  FROM action_logs al
                  LEFT JOIN users u ON al.user_id = u.id
                  WHERE 1=1";
        $params = [];

        if ($date) {
            $query .= " AND DATE(al.created_at) = ?";
            $params[] = $date;
        }
        if ($module) {
            $query .= " AND al.module = ?";
            $params[] = $module;
        }

        $query .= " ORDER BY al.created_at DESC LIMIT ?";
        $params[] = $limit;

        try {
            $db   = Database::getInstance();
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $logs = $stmt->fetchAll();
        } catch (Exception $e) {
            $logs = [];
        }

        $this->view('settings/logs', [
            'logs'         => $logs,
            'selectedDate' => $date,
            'selectedModule'=> $module,
            'limit'        => $limit,
        ]);
    }

    public function errorLogs() {
        $level = $_GET['level'] ?? null;
        $limit = min(intval($_GET['limit'] ?? 100), 500);

        $query = "SELECT * FROM error_logs WHERE 1=1";
        $params = [];

        if ($level) {
            $query .= " AND level = ?";
            $params[] = $level;
        }

        $query .= " ORDER BY created_at DESC LIMIT ?";
        $params[] = $limit;

        try {
            $db   = Database::getInstance();
            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $errorLogs = $stmt->fetchAll();
        } catch (Exception $e) {
            $errorLogs = [];
        }

        $this->view('settings/error_logs', [
            'errorLogs'     => $errorLogs,
            'selectedLevel' => $level,
            'limit'         => $limit,
        ]);
    }

    // ----------------------------------------------------------------
    // Helper: log an action to the action_logs table
    // ----------------------------------------------------------------
    private function logAction($action, $module, $description) {
        try {
            $user = $this->getCurrentUser();
            $db   = Database::getInstance();
            $stmt = $db->prepare(
                "INSERT INTO action_logs (user_id, user_name, action, module, description, ip_address, created_at)
                 VALUES (?, ?, ?, ?, ?, ?, NOW())"
            );
            $stmt->execute([
                $user['id'] ?? null,
                $user['name'] ?? null,
                $action,
                $module,
                $description,
                $_SERVER['REMOTE_ADDR'] ?? null,
            ]);
        } catch (Exception $e) {
            // Logging errors should not break the main flow
            error_log('Could not write action log: ' . $e->getMessage());
        }
    }

    private function handleLogoUpload($file) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts)) {
            return null;
        }
        if ($file['size'] > 2 * 1024 * 1024) {
            return null;
        }
        $uploadDir = UPLOAD_PATH . 'logos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = 'logo.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return 'logos/' . $filename;
        }
        return null;
    }
}
?>
