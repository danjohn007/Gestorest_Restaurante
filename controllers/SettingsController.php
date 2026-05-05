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
        
        foreach ($fields as $key => $value) {
            $this->globalSettingModel->set($key, $value, $group);
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
