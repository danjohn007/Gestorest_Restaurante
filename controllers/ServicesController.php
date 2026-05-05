<?php
class ServicesController extends BaseController {
    private $serviceModel;
    private $serviceSaleModel;

    public function __construct() {
        parent::__construct();
        $this->requireAuth();
        $this->serviceModel  = new Service();
        $this->serviceSaleModel = new ServiceSale();
    }

    // ----------------------------------------------------------------
    // Service catalog (admin)
    // ----------------------------------------------------------------

    public function index() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $user     = $this->getCurrentUser();
        $filters  = [];

        if (!empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }
        if (!empty($_GET['category'])) {
            $filters['category'] = $_GET['category'];
        }
        if ($user['role'] === ROLE_ADMIN && isset($_GET['include_inactive'])) {
            $filters['include_inactive'] = true;
        }

        $services   = $this->serviceModel->getServicesWithFilters($filters);
        $categories = $this->serviceModel->getCategories();

        // Today's sales summary
        $todaySales = $this->serviceSaleModel->getTodaySales();
        $todayTotal = array_sum(array_column($todaySales, 'subtotal'));

        $this->view('services/index', [
            'services'   => $services,
            'categories' => $categories,
            'user'       => $user,
            'todaySales' => $todaySales,
            'todayTotal' => $todayTotal,
        ]);
    }

    // Create a new service (admin only)
    public function create() {
        $this->requireRole([ROLE_ADMIN]);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateServiceInput($_POST);

            if (empty($errors)) {
                $data = [
                    'name'        => trim($_POST['name']),
                    'description' => trim($_POST['description'] ?? ''),
                    'price'       => floatval($_POST['price']),
                    'category'    => trim($_POST['category'] ?? ''),
                    'active'      => 1,
                ];

                // Handle image upload
                if (!empty($_FILES['image']['name'])) {
                    $imagePath = $this->handleImageUpload($_FILES['image']);
                    if ($imagePath) {
                        $data['image'] = $imagePath;
                    }
                }

                $id = $this->serviceModel->create($data);
                if ($id) {
                    $this->redirect('services', 'success', 'Servicio creado correctamente');
                } else {
                    $errors['general'] = 'Error al guardar el servicio';
                }
            }

            $this->view('services/create', ['errors' => $errors, 'old' => $_POST]);
        } else {
            $categories = $this->serviceModel->getCategories();
            $this->view('services/create', ['categories' => $categories]);
        }
    }

    // Edit a service (admin only)
    public function edit($id) {
        $this->requireRole([ROLE_ADMIN]);
        $service = $this->serviceModel->find($id);
        if (!$service) {
            $this->redirect('services', 'error', 'Servicio no encontrado');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = $this->validateServiceInput($_POST);

            if (empty($errors)) {
                $data = [
                    'name'        => trim($_POST['name']),
                    'description' => trim($_POST['description'] ?? ''),
                    'price'       => floatval($_POST['price']),
                    'category'    => trim($_POST['category'] ?? ''),
                    'active'      => isset($_POST['active']) ? 1 : 0,
                ];

                if (!empty($_FILES['image']['name'])) {
                    $imagePath = $this->handleImageUpload($_FILES['image']);
                    if ($imagePath) {
                        $data['image'] = $imagePath;
                    }
                }

                $this->serviceModel->update($id, $data);
                $this->redirect('services', 'success', 'Servicio actualizado correctamente');
            }

            $this->view('services/edit', ['service' => array_merge($service, $_POST), 'errors' => $errors]);
        } else {
            $categories = $this->serviceModel->getCategories();
            $this->view('services/edit', ['service' => $service, 'categories' => $categories]);
        }
    }

    // Toggle service active/inactive
    public function toggle($id) {
        $this->requireRole([ROLE_ADMIN]);
        $service = $this->serviceModel->find($id);
        if (!$service) {
            $this->redirect('services', 'error', 'Servicio no encontrado');
            return;
        }
        $this->serviceModel->update($id, ['active' => $service['active'] ? 0 : 1]);
        $msg = $service['active'] ? 'Servicio desactivado' : 'Servicio activado';
        $this->redirect('services', 'success', $msg);
    }

    // Delete a service (admin only)
    public function delete($id) {
        $this->requireRole([ROLE_ADMIN]);
        $service = $this->serviceModel->find($id);
        if (!$service) {
            $this->redirect('services', 'error', 'Servicio no encontrado');
            return;
        }
        $this->serviceModel->delete($id);
        $this->redirect('services', 'success', 'Servicio eliminado correctamente');
    }

    // ----------------------------------------------------------------
    // Service sales (cashier / admin)
    // ----------------------------------------------------------------

    public function sell() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $user = $this->getCurrentUser();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $serviceId = intval($_POST['service_id'] ?? 0);
            $quantity  = intval($_POST['quantity'] ?? 1);
            $paymentMethod = $_POST['payment_method'] ?? 'efectivo';

            $service = $this->serviceModel->find($serviceId);
            if (!$service || !$service['active']) {
                $errors['service_id'] = 'Servicio no válido o inactivo';
            }

            if ($quantity < 1) {
                $errors['quantity'] = 'La cantidad debe ser al menos 1';
            }

            $validMethods = ['efectivo', 'tarjeta', 'transferencia', 'intercambio', 'pendiente_por_cobrar'];
            if (!in_array($paymentMethod, $validMethods)) {
                $errors['payment_method'] = 'Método de pago inválido';
            }

            if (empty($errors)) {
                $unitPrice = floatval($service['price']);
                $subtotal  = $unitPrice * $quantity;

                $cashReceived = null;
                $changeAmount = null;
                if ($paymentMethod === 'efectivo' && !empty($_POST['cash_received'])) {
                    $cashReceived = floatval($_POST['cash_received']);
                    $changeAmount = max(0, $cashReceived - $subtotal);
                }

                $saleData = [
                    'service_id'     => $serviceId,
                    'cashier_id'     => $user['id'],
                    'quantity'       => $quantity,
                    'unit_price'     => $unitPrice,
                    'subtotal'       => $subtotal,
                    'payment_method' => $paymentMethod,
                    'cash_received'  => $cashReceived,
                    'change_amount'  => $changeAmount,
                    'notes'          => trim($_POST['notes'] ?? ''),
                ];

                $saleId = $this->serviceSaleModel->create($saleData);
                if ($saleId) {
                    $this->redirect('services/sales', 'success', 'Venta registrada correctamente. Total: $' . number_format($subtotal, 2));
                } else {
                    $errors['general'] = 'Error al registrar la venta';
                }
            }

            $services = $this->serviceModel->getAllActive();
            $this->view('services/sell', ['services' => $services, 'errors' => $errors, 'old' => $_POST, 'user' => $user]);
        } else {
            $services = $this->serviceModel->getAllActive();
            $this->view('services/sell', ['services' => $services, 'user' => $user]);
        }
    }

    // List service sales
    public function sales() {
        $this->requireRole([ROLE_ADMIN, ROLE_CASHIER]);
        $user = $this->getCurrentUser();

        $date = $_GET['date'] ?? date('Y-m-d');
        $filters = ['date' => $date];

        if ($user['role'] === ROLE_CASHIER) {
            $filters['cashier_id'] = $user['id'];
        }

        $sales = $this->serviceSaleModel->getSalesWithDetails($filters);
        $dailyReport = $this->serviceSaleModel->getDailyReport($date);
        $dayTotal = array_sum(array_column($sales, 'subtotal'));

        $this->view('services/sales', [
            'sales'       => $sales,
            'dailyReport' => $dailyReport,
            'dayTotal'    => $dayTotal,
            'selectedDate'=> $date,
            'user'        => $user,
        ]);
    }

    // ----------------------------------------------------------------
    // Private helpers
    // ----------------------------------------------------------------

    private function validateServiceInput($data) {
        $errors = [];
        if (empty(trim($data['name'] ?? ''))) {
            $errors['name'] = 'El nombre del servicio es requerido';
        }
        $price = floatval($data['price'] ?? 0);
        if ($price <= 0) {
            $errors['price'] = 'El precio debe ser mayor a cero';
        }
        return $errors;
    }

    private function handleImageUpload($file) {
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, $allowedExts)) {
            return null;
        }
        if ($file['size'] > 5 * 1024 * 1024) {
            return null;
        }
        $uploadDir = UPLOAD_PATH . 'services/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $filename = uniqid('svc_') . '.' . $ext;
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return 'services/' . $filename;
        }
        return null;
    }
}
?>
