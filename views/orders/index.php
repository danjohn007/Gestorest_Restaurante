<?php $title = 'Gestión de Pedidos'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/orders.css">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-clipboard-check"></i> 
        <?= isset($showFuture) && $showFuture ? 'Pedidos Futuros' : 'Pedidos de Hoy' ?>
    </h1>
    <div>
        <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Pedido
        </a>
        <a href="<?= BASE_URL ?>/orders/expired" class="btn btn-warning">
            <i class="bi bi-exclamation-triangle"></i> Pedidos Vencidos
        </a>
        <a href="<?= BASE_URL ?>/orders/future" class="btn btn-info">
            <i class="bi bi-calendar-plus"></i> Pedidos Futuros
        </a>
    </div>
</div>

<style>
.status-pendiente_confirmacion { background-color: #e74c3c; color: #fff; }
.status-pendiente { background-color: #ffc107; color: #000; }
.status-en_preparacion { background-color: #fd7e14; color: #fff; }
.status-listo { background-color: #198754; color: #fff; }
.status-entregado { background-color: #0dcaf0; color: #000; }

/* Estilos mejorados para botones de acciones */
.print-order-btn {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
    color: white !important;
    font-weight: bold;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.print-order-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838 0%, #1abc9c 100%) !important;
    color: white !important;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
    border: none !important;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    background: linear-gradient(135deg, #0056b3 0%, #004085 100%) !important;
}

.btn-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    background: linear-gradient(135deg, #218838 0%, #1abc9c 100%) !important;
}

.btn-outline-warning {
    transition: all 0.3s ease;
}

.btn-outline-warning:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
}

/* Mejoras para la tabla */
.table-hover tbody tr:hover {
    background-color: #f8f9fa;
    transform: scale(1.002);
    transition: all 0.2s ease;
}

.btn-group-sm .btn {
    margin: 0 1px;
    border-radius: 6px !important;
}

/* Animación para los iconos */
.btn i {
    transition: transform 0.2s ease;
}

.btn:hover i {
    transform: scale(1.1);
}
</style> </h1>
    <div>
        <?php if (!isset($showFuture) || !$showFuture): ?>
        <a href="<?= BASE_URL ?>/orders?future=1" class="btn btn-info me-2">
            <i class="bi bi-calendar-plus"></i> Pedidos Futuros
        </a>
        <?php else: ?>
        <a href="<?= BASE_URL ?>/orders" class="btn btn-secondary me-2">
            <i class="bi bi-calendar-day"></i> Pedidos de Hoy
        </a>
        <?php endif; ?>
        <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Pedido
        </a>
    </div>
</div>

<!-- Search Section for Today's Orders only -->
<?php if (!isset($showFuture) || !$showFuture): ?>
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="<?= BASE_URL ?>/orders" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Buscar:</label>
                <input type="text" 
                       class="form-control" 
                       id="search" 
                       name="search" 
                       placeholder="Cliente, teléfono, email, mesa..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label for="table_filter" class="form-label">Filtrar por Mesa:</label>
                <select class="form-select" id="table_filter" name="table_filter">
                    <option value="">Todas las mesas</option>
                    <?php 
                    // Get unique table numbers from orders
                    $tableNumbers = array_unique(array_column($orders, 'table_number'));
                    sort($tableNumbers);
                    foreach ($tableNumbers as $tableNum): 
                        if (!empty($tableNum)):
                    ?>
                        <option value="<?= $tableNum ?>" <?= (($_GET['table_filter'] ?? '') == $tableNum) ? 'selected' : '' ?>>
                            Mesa <?= $tableNum ?>
                        </option>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if (!empty($_GET['search']) || !empty($_GET['table_filter'])): ?>
                    <a href="<?= BASE_URL ?>/orders" class="btn btn-outline-secondary ms-1">
                        <i class="bi bi-x"></i> Limpiar
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>
<?php endif; ?>

<?php if (empty($orders)): ?>
<div class="card">
    <div class="card-body">
        <div class="text-center py-5">
            <i class="bi bi-clipboard-check display-1 text-muted"></i>
            <h3 class="mt-3">No hay pedidos registrados</h3>
            <p class="text-muted">
                <?php if ($user['role'] === ROLE_WAITER): ?>
                    No tienes pedidos asignados <?= isset($showFuture) && $showFuture ? 'futuros' : 'para hoy' ?>.
                <?php else: ?>
                    Aún no se han registrado pedidos <?= isset($showFuture) && $showFuture ? 'futuros' : 'para hoy' ?> en el sistema.
                <?php endif; ?>
            </p>
            <div class="mt-4">
                <a href="<?= BASE_URL ?>/orders/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Crear Primer Pedido
                </a>
                <a href="<?= BASE_URL ?>/dashboard" class="btn btn-outline-secondary ms-2">
                    <i class="bi bi-arrow-left"></i> Volver al Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Mesa</th>
                        <th>Mesero/Cliente</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Items</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong>#<?= $order['id'] ?></strong></td>
                        <td>
                            <span class="badge bg-info">Mesa <?= $order['table_number'] ?></span>
                        </td>
                        <td>
                            <?php if ($order['status'] === ORDER_PENDING_CONFIRMATION || !empty($order['customer_name'])): ?>
                                <i class="bi bi-person-fill text-info"></i> 
                                <small class="text-muted">Cliente:</small><br>
                                <?= htmlspecialchars($order['customer_name'] ?? 'Público') ?>
                                <?php if ($order['is_pickup'] ?? false): ?>
                                    <br><span class="badge bg-info">Pickup</span>
                                    <?php if (!empty($order['pickup_datetime'])): ?>
                                        <br><small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($order['pickup_datetime'])) ?>
                                        </small>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <small class="text-muted"><?= htmlspecialchars($order['employee_code'] ?? '') ?></small><br>
                                <?= htmlspecialchars($order['waiter_name'] ?? 'Sin asignar') ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="badge status-<?= $order['status'] ?>">
                                <?= getOrderStatusText($order['status']) ?>
                            </span>
                        </td>
                        <td>
                            <strong>$<?= number_format($order['total'], 2) ?></strong>
                        </td>
                        <td>
                            <span class="badge bg-secondary"><?= $order['items_count'] ?> items</span>
                        </td>
                        <td>
                            <small>
                                <?php if ($order['is_pickup'] ?? false): ?>
                                    Creado: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                    <?php if (!empty($order['pickup_datetime'])): ?>
                                        <br>Pickup: <?= date('d/m/Y H:i', strtotime($order['pickup_datetime'])) ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                <?php endif; ?>
                            </small>
                        </td>
                        <td>
                            <div class="btn-action-group">
                                <a href="<?= BASE_URL ?>/orders/print/<?= $order['id'] ?>" 
                                   class="btn btn-print btn-sm" 
                                   title="🖨️ Imprimir Pedido para Cocina" target="_blank">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/orders/show/<?= $order['id'] ?>" 
                                   class="btn btn-view-order btn-sm" 
                                   title="👁️ Ver detalles completos">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <?php if ($order['status'] === ORDER_PENDING_CONFIRMATION && ($user['role'] === ROLE_ADMIN || $user['role'] === ROLE_CASHIER)): ?>
                                <a href="<?= BASE_URL ?>/orders/confirmPublicOrder/<?= $order['id'] ?>" 
                                   class="btn btn-success btn-sm" 
                                   title="Confirmar pedido público">
                                    <i class="bi bi-check-circle"></i>
                                </a>
                                <?php endif; ?>
                                <?php if (in_array($order['status'], [ORDER_PENDING, ORDER_PREPARING])): ?>
                                <a href="<?= BASE_URL ?>/orders/markAsReady/<?= $order['id'] ?>" 
                                   class="btn btn-success btn-sm" 
                                   title="Marcar como listo"
                                   onclick="return confirm('¿Marcar este pedido como listo?')">
                                    <i class="bi bi-check2-circle"></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($user['role'] === ROLE_ADMIN && $order['status'] !== ORDER_DELIVERED && $order['status'] !== ORDER_PENDING_CONFIRMATION): ?>
                                <a href="<?= BASE_URL ?>/orders/edit/<?= $order['id'] ?>" 
                                   class="btn btn-edit-order btn-sm" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if ($user['role'] === ROLE_ADMIN): ?>
                                <a href="<?= BASE_URL ?>/orders/delete/<?= $order['id'] ?>" 
                                   class="btn btn-outline-danger btn-sm" 
                                   title="Eliminar"
                                   onclick="return confirm('¿Está seguro de eliminar este pedido?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Quick Stats -->
<div class="row mt-4">
    <?php if ($user['role'] === ROLE_ADMIN || $user['role'] === ROLE_CASHIER): ?>
    <div class="col-md-2 col-sm-6 mb-3">
        <div class="card text-center border-danger">
            <div class="card-body">
                <i class="bi bi-exclamation-triangle display-6 text-danger"></i>
                <h6 class="mt-2">Sin Confirmar</h6>
                <h4 class="text-danger">
                    <?= count(array_filter($orders, function($o) { return $o['status'] === ORDER_PENDING_CONFIRMATION; })) ?>
                </h4>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="col-md-2 col-sm-6 mb-3">
        <div class="card text-center border-primary">
            <div class="card-body">
                <i class="bi bi-clock-history display-6 text-primary"></i>
                <h6 class="mt-2">Pendientes</h6>
                <h4 class="text-primary">
                    <?= count(array_filter($orders, function($o) { return $o['status'] === ORDER_PENDING; })) ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 mb-3">
        <div class="card text-center border-warning">
            <div class="card-body">
                <i class="bi bi-gear display-6 text-warning"></i>
                <h6 class="mt-2">En Preparación</h6>
                <h4 class="text-warning">
                    <?= count(array_filter($orders, function($o) { return $o['status'] === ORDER_PREPARING; })) ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 mb-3">
        <div class="card text-center border-success">
            <div class="card-body">
                <i class="bi bi-check-circle display-6 text-success"></i>
                <h6 class="mt-2">Listos</h6>
                <h4 class="text-success">
                    <?= count(array_filter($orders, function($o) { return $o['status'] === ORDER_READY; })) ?>
                </h4>
            </div>
        </div>
    </div>
    <div class="col-md-2 col-sm-6 mb-3">
        <div class="card text-center border-info">
            <div class="card-body">
                <i class="bi bi-truck display-6 text-info"></i>
                <h6 class="mt-2">Entregados</h6>
                <h4 class="text-info">
                    <?= count(array_filter($orders, function($o) { return $o['status'] === ORDER_DELIVERED; })) ?>
                </h4>
            </div>
        </div>
    </div>
</div>

<style>
.status-pendiente_confirmacion { background-color: #dc3545; color: #fff; }
.status-pendiente { background-color: #ffc107; color: #000; }
.status-en_preparacion { background-color: #fd7e14; color: #fff; }
.status-listo { background-color: #198754; color: #fff; }
.status-entregado { background-color: #0dcaf0; color: #000; }
</style>

<?php
function getOrderStatusText($status) {
    $statusTexts = [
        ORDER_PENDING_CONFIRMATION => 'Pendiente Confirmación',
        ORDER_PENDING => 'Pendiente',
        ORDER_PREPARING => 'En Preparación',
        ORDER_READY => 'Listo',
        ORDER_DELIVERED => 'Entregado'
    ];
    
    return $statusTexts[$status] ?? $status;
}
?>