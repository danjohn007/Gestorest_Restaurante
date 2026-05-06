<?php $title = 'Dashboard Financiero'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-graph-up"></i> Dashboard Financiero</h1>
    <div class="btn-group" role="group">
        <a href="<?= BASE_URL ?>/financial/expenses" class="btn btn-outline-primary">
            <i class="bi bi-credit-card"></i> Gastos
        </a>
        <a href="<?= BASE_URL ?>/financial/withdrawals" class="btn btn-outline-warning">
            <i class="bi bi-cash-coin"></i> Retiros
        </a>
        <a href="<?= BASE_URL ?>/financial/closures" class="btn btn-outline-success">
            <i class="bi bi-journal-check"></i> Corte de Caja
        </a>
        <a href="<?= BASE_URL ?>/financial/collections" class="btn btn-outline-danger">
            <i class="bi bi-cash-coin"></i> Cobranza
        </a>
        <a href="<?= BASE_URL ?>/tickets/dashboardTips" class="btn btn-outline-info">
            <i class="bi bi-cash-coin"></i> Propinas
        </a>
    </div>
</div>

<!-- Filtros -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label for="date_from" class="form-label">Fecha Desde</label>
                <input type="date" class="form-control" id="date_from" name="date_from" value="<?= htmlspecialchars($date_from) ?>">
            </div>
            <div class="col-md-3">
                <label for="date_to" class="form-label">Fecha Hasta</label>
                <input type="date" class="form-control" id="date_to" name="date_to" value="<?= htmlspecialchars($date_to) ?>">
            </div>
            <?php if (!empty($branches)): ?>
            <div class="col-md-3">
                <label for="branch_id" class="form-label">Sucursal</label>
                <select class="form-select" id="branch_id" name="branch_id">
                    <option value="">Todas las sucursales</option>
                    <?php foreach ($branches as $branch): ?>
                    <option value="<?= $branch['id'] ?>" <?= $selected_branch == $branch['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($branch['name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
            <div class="col-md-3 d-flex align-items-end flex-wrap">
                <button type="submit" class="btn btn-primary me-2 mb-1">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <a href="<?= BASE_URL ?>/financial?date_from=<?= date('Y-m-d') ?>&date_to=<?= date('Y-m-d') ?>" class="btn btn-info text-white me-2 mb-1" title="Ver solo el día de hoy">
                    <i class="bi bi-calendar-day"></i> Hoy
                </a>
                <a href="<?= BASE_URL ?>/financial" class="btn btn-outline-secondary mb-1">
                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Main Dashboard Tabs -->
<ul class="nav nav-tabs mb-4" id="dashboardTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="tab-general" data-bs-toggle="tab" data-bs-target="#panel-general" type="button" role="tab">
            <i class="bi bi-grid"></i> General
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-restaurante" data-bs-toggle="tab" data-bs-target="#panel-restaurante" type="button" role="tab">
            <i class="bi bi-receipt"></i> Restaurante
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="tab-servicios" data-bs-toggle="tab" data-bs-target="#panel-servicios" type="button" role="tab">
            <i class="bi bi-tools"></i> Servicios
        </button>
    </li>
</ul>

<div class="tab-content" id="dashboardTabContent">

<!-- ==================== TAB GENERAL ==================== -->
<div class="tab-pane fade show active" id="panel-general" role="tabpanel">

<!-- Income vs Expenses Summary -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Ingresos Totales</h6>
                        <h3 class="mb-0 text-success">$<?= number_format($total_income['total_income'] ?? 0, 2) ?></h3>
                        <?php
                            $ticketCount = $total_income['total_tickets'] ?? 0;
                            $serviceCount = $total_income['service_sales'] ?? 0;
                            $subtitle = $ticketCount . ' tickets';
                            if ($serviceCount > 0) {
                                $subtitle .= ' + ' . $serviceCount . ' servicios';
                            }
                        ?>
                        <small class="text-muted"><?= $subtitle ?></small>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-arrow-up-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Gastos Totales</h6>
                        <h3 class="mb-0 text-danger">$<?= number_format($total_expense_amount, 2) ?></h3>
                        <small class="text-muted">Período seleccionado</small>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-arrow-down-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Retiros Totales</h6>
                        <h3 class="mb-0 text-warning">$<?= number_format($total_withdrawals['total_amount'] ?? 0, 2) ?></h3>
                        <small class="text-muted"><?= $total_withdrawals['total_count'] ?? 0 ?> retiros</small>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-cash-coin" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <?php 
            $totalWithdrawalAmount = $total_withdrawals['total_amount'] ?? 0;
            $netProfit = ($total_income['total_income'] ?? 0) - $total_expense_amount - $totalWithdrawalAmount;
        ?>
        <div class="card stat-card <?= $netProfit >= 0 ? 'success' : 'warning' ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Utilidad Neta</h6>
                        <h3 class="mb-0 <?= $netProfit >= 0 ? 'text-success' : 'text-warning' ?>">
                            $<?= number_format($netProfit, 2) ?>
                        </h3>
                        <small class="text-muted">Ingresos - Gastos - Retiros</small>
                    </div>
                    <div class="<?= $netProfit >= 0 ? 'text-success' : 'text-warning' ?>">
                        <i class="bi bi-calculator" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Margen de Ganancia</h6>
                        <h3 class="mb-0 text-info">
                            <?php 
                            $totalIncomeFull = $total_income['total_income'] ?? 0;
                            $margin = $totalIncomeFull > 0 ? (($totalIncomeFull - $total_expense_amount - ($total_withdrawals['total_amount'] ?? 0)) / $totalIncomeFull) * 100 : 0;
                            echo number_format($margin, 1) . '%';
                            ?>
                        </h3>
                        <small class="text-muted">Porcentaje de utilidad</small>
                    </div>
                    <div class="text-info">
                        <i class="bi bi-percent" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- New Payment Method Statistics -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <a href="<?= BASE_URL ?>/financial/intercambios" class="text-decoration-none">
            <div class="card stat-card warning" style="cursor: pointer; transition: transform 0.2s;" 
                 onmouseover="this.style.transform='translateY(-2px)'" 
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted mb-1">Total Intercambios</h6>
                            <h3 class="mb-0 text-warning">
                                $<?= number_format($intercambio_stats['total_amount'] ?? 0, 2) ?>
                            </h3>
                            <small class="text-muted"><?= $intercambio_stats['count'] ?? 0 ?> transacciones</small>
                        </div>
                        <div class="text-warning">
                            <i class="bi bi-arrow-left-right" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-4 mb-3">
        <a href="<?= BASE_URL ?>/financial/collections" class="text-decoration-none">
            <div class="card stat-card danger" style="cursor: pointer; transition: transform 0.2s;" 
                 onmouseover="this.style.transform='translateY(-2px)'" 
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted mb-1">Pendiente por Cobrar</h6>
                            <h3 class="mb-0 text-danger">
                                $<?= number_format($pending_payment_stats['total_amount'] ?? 0, 2) ?>
                            </h3>
                            <small class="text-muted"><?= $pending_payment_stats['count'] ?? 0 ?> cuentas pendientes</small>
                        </div>
                        <div class="text-danger">
                            <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    
    <div class="col-md-4 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Métodos de Pago</h6>
                        <h3 class="mb-0 text-info">
                            <?= count($payment_method_stats ?? []) ?>
                        </h3>
                        <small class="text-muted">métodos utilizados</small>
                    </div>
                    <div class="text-info">
                        <i class="bi bi-credit-card" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Income vs Expenses Chart -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i> Ingresos vs Egresos
                </h5>
            </div>
            <div class="card-body">
                <canvas id="incomeVsExpensesChart" height="400"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-credit-card"></i> Ingresos por Método de Pago
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($income_by_payment_method)): ?>
                    <?php foreach ($income_by_payment_method as $payment): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge bg-primary">
                                <?= ucfirst(htmlspecialchars($payment['payment_method'] ?? '')) ?>
                            </span>
                            <?php
                                $tCount  = (int)($payment['tickets_count'] ?? 0);
                                $sCount = (int)($payment['services_count'] ?? 0);
                                $parts = [];
                                if ($tCount > 0)  $parts[] = $tCount  . ' ' . ($tCount  === 1 ? 'ticket'   : 'tickets');
                                if ($sCount > 0) $parts[] = $sCount . ' ' . ($sCount === 1 ? 'servicio' : 'servicios');
                                $countLabel = !empty($parts) ? implode(' + ', $parts) : '0 tickets';
                            ?>
                            <small class="text-muted">(<?= $countLabel ?>)</small>
                        </div>
                        <strong class="text-success">$<?= number_format($payment['total_income'], 2) ?></strong>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No hay ingresos registrados en el período seleccionado</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Estadísticas por categoría -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-pie-chart"></i> Gastos por Categoría
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($total_expenses)): ?>
                    <?php foreach ($total_expenses as $expense): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge" style="background-color: <?= htmlspecialchars($expense['category_color']) ?>">
                                <?= htmlspecialchars($expense['category_name']) ?>
                            </span>
                            <small class="text-muted">(<?= $expense['expense_count'] ?> gastos)</small>
                        </div>
                        <strong>$<?= number_format($expense['total_amount'], 2) ?></strong>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No hay gastos registrados en el período seleccionado</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Actividad Reciente
                </h5>
            </div>
            <div class="card-body">
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-expenses-tab" data-bs-toggle="tab" data-bs-target="#nav-expenses" type="button" role="tab">
                        Gastos
                    </button>
                    <button class="nav-link" id="nav-withdrawals-tab" data-bs-toggle="tab" data-bs-target="#nav-withdrawals" type="button" role="tab">
                        Retiros
                    </button>
                    <button class="nav-link" id="nav-closures-tab" data-bs-toggle="tab" data-bs-target="#nav-closures" type="button" role="tab">
                        Cortes
                    </button>
                </div>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-expenses" role="tabpanel">
                        <?php if (!empty($recent_expenses)): ?>
                            <?php foreach ($recent_expenses as $expense): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($expense['description']) ?></div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($expense['category_name']) ?> - 
                                        <?= date('d/m/Y', strtotime($expense['expense_date'])) ?>
                                    </small>
                                </div>
                                <strong class="text-danger">-$<?= number_format($expense['amount'], 2) ?></strong>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay gastos recientes</p>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="nav-withdrawals" role="tabpanel">
                        <?php if (!empty($recent_withdrawals)): ?>
                            <?php foreach ($recent_withdrawals as $withdrawal): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-bold"><?= htmlspecialchars($withdrawal['reason']) ?></div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($withdrawal['responsible_name']) ?> - 
                                        <?= date('d/m/Y H:i', strtotime($withdrawal['withdrawal_date'])) ?>
                                    </small>
                                </div>
                                <strong class="text-warning">-$<?= number_format($withdrawal['amount'], 2) ?></strong>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay retiros recientes</p>
                        <?php endif; ?>
                    </div>
                    <div class="tab-pane fade" id="nav-closures" role="tabpanel">
                        <?php if (!empty($recent_closures)): ?>
                            <?php foreach ($recent_closures as $closure): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <div class="fw-bold">Corte de Caja</div>
                                    <small class="text-muted">
                                        <?= htmlspecialchars($closure['cashier_name']) ?> - 
                                        <?= date('d/m/Y H:i', strtotime($closure['shift_start'])) ?>
                                    </small>
                                </div>
                                <strong class="<?= $closure['net_profit'] >= 0 ? 'text-success' : 'text-danger' ?>">
                                    $<?= number_format($closure['net_profit'], 2) ?>
                                </strong>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay cortes recientes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-plus-circle display-4 text-danger mb-3"></i>
                <h5 class="card-title">Registrar Gasto</h5>
                <p class="card-text">Registra un nuevo gasto del negocio</p>
                <a href="<?= BASE_URL ?>/financial/createExpense" class="btn btn-danger">
                    <i class="bi bi-plus"></i> Nuevo Gasto
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-cash-coin display-4 text-warning mb-3"></i>
                <h5 class="card-title">Registrar Retiro</h5>
                <p class="card-text">Registra un retiro de dinero de caja</p>
                <a href="<?= BASE_URL ?>/financial/createWithdrawal" class="btn btn-warning">
                    <i class="bi bi-plus"></i> Nuevo Retiro
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-journal-check display-4 text-success mb-3"></i>
                <h5 class="card-title">Corte de Caja</h5>
                <p class="card-text">Realiza el corte de caja del turno</p>
                <a href="<?= BASE_URL ?>/financial/createClosure" class="btn btn-success">
                    <i class="bi bi-plus"></i> Nuevo Corte
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Accesos a Mejores Comensales -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-star-fill"></i> Análisis de Clientes
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center border-primary">
                            <div class="card-body">
                                <i class="bi bi-star-fill display-4 text-primary mb-3"></i>
                                <h6 class="card-title">Mejores Comensales</h6>
                                <p class="card-text small">Vista general de los mejores clientes</p>
                                <a href="<?= BASE_URL ?>/best_diners" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Ver Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card text-center border-success">
                            <div class="card-body">
                                <i class="bi bi-currency-dollar display-4 text-success mb-3"></i>
                                <h6 class="card-title">Top por Consumo</h6>
                                <p class="card-text small">Clientes que más han gastado</p>
                                <a href="<?= BASE_URL ?>/best_diners/bySpending" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-graph-up"></i> Ver Lista
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card text-center border-info">
                            <div class="card-body">
                                <i class="bi bi-people-fill display-4 text-info mb-3"></i>
                                <h6 class="card-title">Top por Visitas</h6>
                                <p class="card-text small">Clientes más frecuentes</p>
                                <a href="<?= BASE_URL ?>/best_diners/byVisits" class="btn btn-outline-info btn-sm">
                                    <i class="bi bi-calendar-check"></i> Ver Lista
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="card text-center border-warning">
                            <div class="card-body">
                                <i class="bi bi-graph-up-arrow display-4 text-warning mb-3"></i>
                                <h6 class="card-title">Reporte Completo</h6>
                                <p class="card-text small">Análisis detallado de clientes</p>
                                <a href="<?= BASE_URL ?>/best_diners/report" class="btn btn-outline-warning btn-sm">
                                    <i class="bi bi-file-earmark-bar-graph"></i> Ver Reporte
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div><!-- end #panel-general -->

<!-- ==================== TAB RESTAURANTE ==================== -->
<div class="tab-pane fade" id="panel-restaurante" role="tabpanel">

<?php
    $tIncome = $ticket_total_income['total_income'] ?? 0;
    $tTickets = $ticket_total_income['total_tickets'] ?? 0;
    $tSubtotal = $ticket_total_income['total_subtotal'] ?? 0;
    $tTax = $ticket_total_income['total_tax'] ?? 0;
    $tWithdrawals = $total_withdrawals['total_amount'] ?? 0;
    $tNetProfit = $tIncome - $total_expense_amount - $tWithdrawals;
    $tMargin = $tIncome > 0 ? (($tIncome - $total_expense_amount - $tWithdrawals) / $tIncome) * 100 : 0;
?>

<!-- Restaurante stat cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Ventas Restaurante</h6>
                        <h3 class="mb-0 text-success">$<?= number_format($tIncome, 2) ?></h3>
                        <small class="text-muted"><?= $tTickets ?> tickets</small>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-receipt" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Gastos Totales</h6>
                        <h3 class="mb-0 text-danger">$<?= number_format($total_expense_amount, 2) ?></h3>
                        <small class="text-muted">Período seleccionado</small>
                    </div>
                    <div class="text-danger">
                        <i class="bi bi-arrow-down-circle" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Retiros</h6>
                        <h3 class="mb-0 text-warning">$<?= number_format($tWithdrawals, 2) ?></h3>
                        <small class="text-muted"><?= $total_withdrawals['total_count'] ?? 0 ?> retiros</small>
                    </div>
                    <div class="text-warning">
                        <i class="bi bi-cash-coin" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 mb-3">
        <div class="card stat-card <?= $tNetProfit >= 0 ? 'success' : 'warning' ?>">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Utilidad Restaurante</h6>
                        <h3 class="mb-0 <?= $tNetProfit >= 0 ? 'text-success' : 'text-warning' ?>">
                            $<?= number_format($tNetProfit, 2) ?>
                        </h3>
                        <small class="text-muted"><?= number_format($tMargin, 1) ?>% margen</small>
                    </div>
                    <div class="<?= $tNetProfit >= 0 ? 'text-success' : 'text-warning' ?>">
                        <i class="bi bi-calculator" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Intercambios & Pendientes -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted mb-1">Subtotal (sin IVA)</h6>
                <h4 class="text-secondary">$<?= number_format($tSubtotal, 2) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title text-muted mb-1">IVA Recaudado</h6>
                <h4 class="text-info">$<?= number_format($tTax, 2) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <a href="<?= BASE_URL ?>/financial/intercambios" class="text-decoration-none">
            <div class="card stat-card warning" style="cursor:pointer;">
                <div class="card-body">
                    <h6 class="card-title text-muted mb-1">Total Intercambios</h6>
                    <h4 class="text-warning">$<?= number_format($intercambio_stats['total_amount'] ?? 0, 2) ?></h4>
                    <small class="text-muted"><?= $intercambio_stats['count'] ?? 0 ?> transacciones</small>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Restaurante: Payment method breakdown & Pending -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-credit-card"></i> Tickets por Método de Pago
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($ticket_income_by_payment_method)): ?>
                    <?php foreach ($ticket_income_by_payment_method as $payment): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge bg-primary"><?= ucfirst(htmlspecialchars($payment['payment_method'] ?? '')) ?></span>
                            <small class="text-muted">(<?= $payment['tickets_count'] ?? 0 ?> tickets)</small>
                        </div>
                        <strong class="text-success">$<?= number_format($payment['total_income'], 2) ?></strong>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Sin tickets en el período</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-clock-history"></i> Gastos por Categoría
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($total_expenses)): ?>
                    <?php foreach ($total_expenses as $expense): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge" style="background-color: <?= htmlspecialchars($expense['category_color']) ?>">
                                <?= htmlspecialchars($expense['category_name']) ?>
                            </span>
                            <small class="text-muted">(<?= $expense['expense_count'] ?> gastos)</small>
                        </div>
                        <strong>$<?= number_format($expense['total_amount'], 2) ?></strong>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">No hay gastos en el período</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Restaurante: Pending -->
<div class="row mb-4">
    <div class="col-md-6">
        <a href="<?= BASE_URL ?>/financial/collections" class="text-decoration-none">
            <div class="card stat-card danger" style="cursor:pointer;">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title text-muted mb-1">Pendiente por Cobrar</h6>
                            <h3 class="mb-0 text-danger">$<?= number_format($pending_payment_stats['total_amount'] ?? 0, 2) ?></h3>
                            <small class="text-muted"><?= $pending_payment_stats['count'] ?? 0 ?> cuentas pendientes</small>
                        </div>
                        <div class="text-danger">
                            <i class="bi bi-clock-history" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h6 class="card-title text-muted mb-1">Tickets Promedio</h6>
                <h3 class="mb-0 text-info">
                    $<?= $tTickets > 0 ? number_format($tIncome / $tTickets, 2) : '0.00' ?>
                </h3>
                <small class="text-muted">por ticket</small>
            </div>
        </div>
    </div>
</div>

<!-- Restaurante: Quick Actions -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-plus-circle display-4 text-danger mb-3"></i>
                <h5 class="card-title">Registrar Gasto</h5>
                <a href="<?= BASE_URL ?>/financial/createExpense" class="btn btn-danger">
                    <i class="bi bi-plus"></i> Nuevo Gasto
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-cash-coin display-4 text-warning mb-3"></i>
                <h5 class="card-title">Registrar Retiro</h5>
                <a href="<?= BASE_URL ?>/financial/createWithdrawal" class="btn btn-warning">
                    <i class="bi bi-plus"></i> Nuevo Retiro
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-journal-check display-4 text-success mb-3"></i>
                <h5 class="card-title">Corte de Caja</h5>
                <a href="<?= BASE_URL ?>/financial/createClosure" class="btn btn-success">
                    <i class="bi bi-plus"></i> Nuevo Corte
                </a>
            </div>
        </div>
    </div>
</div>

</div><!-- end #panel-restaurante -->

<!-- ==================== TAB SERVICIOS ==================== -->
<div class="tab-pane fade" id="panel-servicios" role="tabpanel">

<?php
    $sIncome  = (float)($service_sales_totals['total_income'] ?? 0);
    $sSales   = (int)($service_sales_totals['total_sales'] ?? 0);
    $sAvg     = $sSales > 0 ? $sIncome / $sSales : 0;
?>

<!-- Servicios stat cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Ingresos por Servicios</h6>
                        <h3 class="mb-0 text-success">$<?= number_format($sIncome, 2) ?></h3>
                        <small class="text-muted"><?= $sSales ?> reservaciones</small>
                    </div>
                    <div class="text-success">
                        <i class="bi bi-tools" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="card-title text-muted mb-1">Promedio por Servicio</h6>
                        <h3 class="mb-0 text-info">$<?= number_format($sAvg, 2) ?></h3>
                        <small class="text-muted">por reservación</small>
                    </div>
                    <div class="text-info">
                        <i class="bi bi-calculator" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="card text-center">
            <div class="card-body">
                <i class="bi bi-calendar-check display-4 text-primary mb-3"></i>
                <h5 class="card-title">Registrar Servicio</h5>
                <a href="<?= BASE_URL ?>/services/sales" class="btn btn-primary">
                    <i class="bi bi-plus"></i> Nueva Reservación
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Servicios: Métodos de pago -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-credit-card"></i> Servicios por Método de Pago
                </h5>
            </div>
            <div class="card-body">
                <?php if (!empty($service_income_by_payment_method)): ?>
                    <?php foreach ($service_income_by_payment_method as $payment): ?>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div>
                            <span class="badge bg-success"><?= ucfirst(htmlspecialchars($payment['payment_method'] ?? '')) ?></span>
                            <small class="text-muted">(<?= $payment['services_count'] ?? 0 ?> servicios)</small>
                        </div>
                        <strong class="text-success">$<?= number_format($payment['total_income'], 2) ?></strong>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-muted text-center">Sin servicios en el período</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="bi bi-info-circle"></i> Resumen de Servicios
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <td><strong>Total Ingresos:</strong></td>
                            <td class="text-success fw-bold">$<?= number_format($sIncome, 2) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total Reservaciones:</strong></td>
                            <td><?= $sSales ?></td>
                        </tr>
                        <tr>
                            <td><strong>Promedio por Reservación:</strong></td>
                            <td>$<?= number_format($sAvg, 2) ?></td>
                        </tr>
                    </tbody>
                </table>
                <div class="mt-3">
                    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-primary btn-sm me-2">
                        <i class="bi bi-list"></i> Catálogo de Servicios
                    </a>
                    <a href="<?= BASE_URL ?>/services/report" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-file-earmark-bar-graph"></i> Reporte de Servicios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</div><!-- end #panel-servicios -->

</div><!-- end .tab-content -->

<!-- Flash Messages -->
<?php if ($success_message = $this->getFlashMessage('success')): ?>
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    <?= htmlspecialchars($success_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if ($error_message = $this->getFlashMessage('error')): ?>
<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
    <?= htmlspecialchars($error_message) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Chart.js for Income vs Expenses Chart -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Income vs Expenses Chart
    const incomeVsExpensesData = <?= json_encode($income_vs_expenses) ?>;
    
    if (incomeVsExpensesData && incomeVsExpensesData.length > 0) {
        const ctx = document.getElementById('incomeVsExpensesChart').getContext('2d');
        
        const dates = incomeVsExpensesData.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('es-ES', { month: 'short', day: 'numeric' });
        });
        
        const incomeData = incomeVsExpensesData.map(item => parseFloat(item.income));
        const expenseData = incomeVsExpensesData.map(item => parseFloat(item.expenses));
        const withdrawalData = incomeVsExpensesData.map(item => parseFloat(item.withdrawals || 0));
        const netProfitData = incomeVsExpensesData.map(item => parseFloat(item.net_profit));
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [
                    {
                        label: 'Ingresos',
                        data: incomeData,
                        borderColor: 'rgb(40, 167, 69)',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Gastos',
                        data: expenseData,
                        borderColor: 'rgb(220, 53, 69)',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Retiros',
                        data: withdrawalData,
                        borderColor: 'rgb(255, 193, 7)',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        tension: 0.4,
                        fill: false
                    },
                    {
                        label: 'Utilidad Neta',
                        data: netProfitData,
                        borderColor: 'rgb(0, 123, 255)',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        tension: 0.4,
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Ingresos vs Egresos por Día'
                    },
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + new Intl.NumberFormat('es-MX', {minimumFractionDigits: 2, maximumFractionDigits: 2}).format(value);
                            }
                        }
                    }
                }
            }
        });
    }

    // Preserve active tab across page loads using hash or sessionStorage
    const tabKey = 'financialDashboardTab';
    const savedTab = sessionStorage.getItem(tabKey);
    if (savedTab) {
        const tabEl = document.querySelector('[data-bs-target="' + savedTab + '"]');
        if (tabEl) {
            new bootstrap.Tab(tabEl).show();
        }
    }
    document.querySelectorAll('#dashboardTabs [data-bs-toggle="tab"]').forEach(function(tabEl) {
        tabEl.addEventListener('shown.bs.tab', function(e) {
            sessionStorage.setItem(tabKey, e.target.getAttribute('data-bs-target'));
        });
    });
});
</script>

