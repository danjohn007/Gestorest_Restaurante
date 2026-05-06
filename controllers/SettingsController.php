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
}
