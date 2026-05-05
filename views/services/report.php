<?php $title = 'Reporte de Servicios'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-graph-up"></i> Reporte de Servicios</h1>
    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Fecha Desde</label>
                <input type="date" class="form-control" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha Hasta</label>
                <input type="date" class="form-control" name="date_to" value="<?= htmlspecialchars($dateTo) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <a href="<?= BASE_URL ?>/services/report?date_from=<?= date('Y-m-d') ?>&date_to=<?= date('Y-m-d') ?>" class="btn btn-outline-info">
                    <i class="bi bi-calendar-day"></i> Hoy
                </a>
            </div>
        </form>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <h4 class="text-success">$<?= number_format($totals['total_income'] ?? 0, 2) ?></h4>
                <p class="text-muted mb-0">Total Ingresos por Servicios</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-primary">
            <div class="card-body text-center">
                <h4 class="text-primary"><?= $totals['total_sales'] ?? 0 ?></h4>
                <p class="text-muted mb-0">Total Ventas</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ventas: <?= date('d/m/Y', strtotime($dateFrom)) ?> - <?= date('d/m/Y', strtotime($dateTo)) ?></h5>
    </div>
    <div class="card-body">
        <?php if (empty($sales)): ?>
        <div class="text-center py-4">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <p class="mt-2">No hay ventas en el período seleccionado</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Servicio</th>
                        <th>Categoría</th>
                        <th>Cant.</th>
                        <th>Total</th>
                        <th>Pago</th>
                        <th>Cajero</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></td>
                        <td><?= htmlspecialchars($sale['service_name']) ?></td>
                        <td><span class="badge bg-info"><?= htmlspecialchars($sale['category'] ?? 'General') ?></span></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td><strong class="text-success">$<?= number_format($sale['total'], 2) ?></strong></td>
                        <td><?= ucfirst($sale['payment_method']) ?></td>
                        <td><?= htmlspecialchars($sale['cashier_name']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
