<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? APP_NAME ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?= BASE_URL ?>/public/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Sidebar Navigation -->
    <?php if (isset($_SESSION['user_id'])): ?>
    <!-- Mobile Toggle Button -->
    <button class="sidebar-toggle" id="sidebarToggle" aria-label="Toggle navigation menu">
        <i class="bi bi-list"></i>
    </button>
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar" aria-label="Main navigation">
        <div class="sidebar-header">
            <a class="sidebar-brand" href="<?= BASE_URL ?>/dashboard">
                <i class="bi bi-shop"></i>
                <span><?= APP_NAME ?></span>
            </a>
        </div>
        
        <ul class="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            
            <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
            <li class="nav-item sidebar-dropdown">
                <a class="nav-link dropdown-toggle" href="#administracion" role="button">
                    <i class="bi bi-gear"></i>
                    <span>Administración</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/users">
                        <i class="bi bi-people"></i> Usuarios
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/waiters">
                        <i class="bi bi-person-badge"></i> Meseros
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/tables">
                        <i class="bi bi-grid-3x3-gap"></i> Mesas
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/dishes">
                        <i class="bi bi-cup-hot"></i> Menú
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['user_role'], [ROLE_ADMIN, ROLE_WAITER])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/orders">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (in_array($_SESSION['user_role'], [ROLE_ADMIN, ROLE_WAITER, ROLE_CASHIER])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/tables/layout">
                    <i class="bi bi-diagram-3"></i>
                    <span>Layout de Mesas</span>
                </a>
            </li>
            <?php endif; ?>
            
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/reservations">
                    <i class="bi bi-calendar-check"></i>
                    <span>Reservaciones</span>
                </a>
            </li>
            
            <?php if (in_array($_SESSION['user_role'], [ROLE_ADMIN, ROLE_CASHIER])): ?>
            <li class="nav-item">
                <a class="nav-link" href="<?= BASE_URL ?>/tickets">
                    <i class="bi bi-receipt"></i>
                    <span>Tickets</span>
                </a>
            </li>
            <li class="nav-item sidebar-dropdown">
                <a class="nav-link dropdown-toggle" href="#financiero" role="button">
                    <i class="bi bi-calculator"></i>
                    <span>Financiero</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial">
                        <i class="bi bi-graph-up"></i> Dashboard
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial/expenses">
                        <i class="bi bi-credit-card"></i> Gastos
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial/withdrawals">
                        <i class="bi bi-cash-coin"></i> Retiros
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial/closures">
                        <i class="bi bi-journal-check"></i> Corte de Caja
                    </a></li>
                    <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial/categories">
                        <i class="bi bi-tags"></i> Categorías
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/financial/branches">
                        <i class="bi bi-building"></i> Sucursales
                    </a></li>
                    <?php endif; ?>
                </ul>
            </li>
            
            <?php if (in_array($_SESSION['user_role'], [ROLE_ADMIN, ROLE_SUPERADMIN, ROLE_CASHIER])): ?>
            <li class="nav-item sidebar-dropdown">
                <a class="nav-link dropdown-toggle" href="#inventario" role="button">
                    <i class="bi bi-boxes"></i>
                    <span>Inventario</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/inventory">
                        <i class="bi bi-list"></i> Productos
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/inventory/movements">
                        <i class="bi bi-arrow-up-down"></i> Movimientos
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/inventory/report">
                        <i class="bi bi-graph-up"></i> Reportes
                    </a></li>
                    <?php if ($_SESSION['user_role'] === ROLE_SUPERADMIN): ?>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/inventory/settings">
                        <i class="bi bi-gear"></i> Configuración
                    </a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>
            
            <li class="nav-item sidebar-dropdown">
                <a class="nav-link dropdown-toggle" href="#clientes" role="button">
                    <i class="bi bi-star-fill"></i>
                    <span>Clientes</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/customers">
                        <i class="bi bi-people"></i> Gestión de Clientes
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/best_diners">
                        <i class="bi bi-trophy"></i> Mejores Comensales
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/best_diners/bySpending">
                        <i class="bi bi-currency-dollar"></i> Top por Consumo
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/best_diners/byVisits">
                        <i class="bi bi-people-fill"></i> Top por Visitas
                    </a></li>
                    <li><a class="dropdown-item" href="<?= BASE_URL ?>/best_diners/report">
                        <i class="bi bi-bar-chart"></i> Reporte Completo
                    </a></li>
                </ul>
            </li>
            <?php endif; ?>
        </ul>
        
        <!-- User Menu at Bottom -->
        <div class="sidebar-user">
            <ul class="sidebar-nav">
                <li class="nav-item sidebar-dropdown">
                    <a class="nav-link dropdown-toggle" href="#usuario" role="button">
                        <i class="bi bi-person-circle"></i>
                        <span><?= htmlspecialchars($_SESSION['user_name']) ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/profile">
                            <i class="bi bi-person"></i> Mi Perfil
                        </a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/auth/changePassword">
                            <i class="bi bi-key"></i> Cambiar Contraseña
                        </a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/auth/logout">
                            <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                        </a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="<?= isset($_SESSION['user_id']) ? 'main-content-with-sidebar' : '' ?>">
        <?php if (isset($_SESSION['user_id'])): ?>
        <div class="container-fluid">
        <?php endif; ?>
        
        <!-- Flash Messages -->
        <?php 
        $flashTypes = ['success', 'error', 'warning', 'info'];
        foreach ($flashTypes as $type): 
            $key = 'flash_' . $type;
            $message = null;
            if (isset($_SESSION[$key])) {
                $message = $_SESSION[$key];
                unset($_SESSION[$key]); // Remove message after displaying it
            }
            if ($message):
                $alertClass = $type === 'error' ? 'danger' : $type;
        ?>
        <div class="alert alert-<?= $alertClass ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php 
            endif;
        endforeach; 
        ?>
        
        <!-- Global Fixed New Order Button -->
        <?php 
        // Get current URL path to hide button on create/edit order pages
        $currentPath = $_SERVER['REQUEST_URI'] ?? '';
        $hideButton = strpos($currentPath, '/orders/create') !== false || strpos($currentPath, '/orders/edit') !== false;
        if (!$hideButton): 
        ?>
        <a href="<?= BASE_URL ?>/orders/create" 
           class="btn btn-primary btn-lg shadow-lg fixed-new-order-btn" 
           id="globalNewOrderBtn"
           title="Crear Nuevo Pedido">
            <i class="bi bi-plus-circle-fill"></i> Nuevo Pedido
        </a>
        <?php endif; ?>