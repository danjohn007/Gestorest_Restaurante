<?php
class ServicesController extends BaseController {
    private $serviceModel;
    private $serviceSaleModel;
    
    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->serviceModel = new Service();
        $this->serviceSaleModel = new ServiceSale();
    }
    
    public function index() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $services = $this->serviceModel->getAllActive();
        $this->view('services/index', [
            'services' => $services
        ]);
    }
    
    public function create() {
        $this->requireRole([ROLE_ADMIN]);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'category' => trim($_POST['category'] ?? ''),
                'active' => 1
            ];
            if (empty($data['name']) || $data['price'] <= 0) {
                $this->view('services/create', ['error' => 'Nombre y precio son requeridos', 'old' => $_POST]);
                return;
            }
            $this->serviceModel->create($data);
            $this->redirect('services', 'success', 'Servicio creado correctamente');
        } else {
            $categories = $this->serviceModel->getCategories();
            $this->view('services/create', ['categories' => $categories]);
        }
    }
    
    public function edit($id) {
        $this->requireRole([ROLE_ADMIN]);
        $service = $this->serviceModel->find($id);
        if (!$service) {
            $this->redirect('services', 'error', 'Servicio no encontrado');
            return;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => trim($_POST['name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price' => floatval($_POST['price'] ?? 0),
                'category' => trim($_POST['category'] ?? ''),
                'active' => isset($_POST['active']) ? 1 : 0
            ];
            $this->serviceModel->update($id, $data);
            $this->redirect('services', 'success', 'Servicio actualizado correctamente');
        } else {
            $categories = $this->serviceModel->getCategories();
            $this->view('services/edit', ['service' => $service, 'categories' => $categories]);
        }
    }
    
    public function delete($id) {
        $this->requireRole([ROLE_ADMIN]);
        $this->serviceModel->update($id, ['active' => 0]);
        $this->redirect('services', 'success', 'Servicio eliminado correctamente');
    }
    
    public function sales() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $date = $_GET['date'] ?? date('Y-m-d');
        $sales = $this->serviceSaleModel->getSalesWithDetails(['date' => $date]);
        $services = $this->serviceModel->getAllActive();
        $totals = $this->serviceSaleModel->getTotalByDateRange($date, $date);
        $this->view('services/sales', [
            'sales' => $sales,
            'services' => $services,
            'selectedDate' => $date,
            'totals' => $totals
        ]);
    }
    
    public function registerSale() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('services/sales');
            return;
        }
        
        $user = $this->getCurrentUser();
        $serviceId = intval($_POST['service_id'] ?? 0);
        $quantity = intval($_POST['quantity'] ?? 1);
        $paymentMethod = $_POST['payment_method'] ?? 'efectivo';
        $notes = trim($_POST['notes'] ?? '');
        $cashReceived = !empty($_POST['cash_received']) ? floatval($_POST['cash_received']) : null;
        
        $service = $this->serviceModel->find($serviceId);
        if (!$service) {
            $this->redirect('services/sales', 'error', 'Servicio no encontrado');
            return;
        }
        
        $unitPrice = $service['price'];
        $total = $unitPrice * $quantity;
        $changeAmount = ($paymentMethod === 'efectivo' && $cashReceived !== null) ? ($cashReceived - $total) : null;
        
        $saleData = [
            'service_id' => $serviceId,
            'user_id' => $user['id'],
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total' => $total,
            'payment_method' => $paymentMethod,
            'cash_received' => $cashReceived,
            'change_amount' => $changeAmount,
            'notes' => $notes
        ];
        
        $this->serviceSaleModel->create($saleData);
        $this->redirect('services/sales', 'success', 'Venta registrada correctamente. Total: $' . number_format($total, 2));
    }
    
    public function report() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $dateFrom = $_GET['date_from'] ?? date('Y-m-01');
        $dateTo = $_GET['date_to'] ?? date('Y-m-d');
        $sales = $this->serviceSaleModel->getSalesWithDetails(['date_from' => $dateFrom, 'date_to' => $dateTo]);
        $totals = $this->serviceSaleModel->getTotalByDateRange($dateFrom, $dateTo);
        $this->view('services/report', [
            'sales' => $sales,
            'totals' => $totals,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }
}
