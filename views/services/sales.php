<?php $title = 'Historial de Ventas de Servicios'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-list-ul"></i> Ventas de Servicios</h1>
    <div>
        <a href="<?= BASE_URL ?>/services/sell" class="btn btn-success me-2">
            <i class="bi bi-cart-plus"></i> Nueva Venta
        </a>
        <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Catálogo
        </a>
    </div>
</div>

<!-- Date filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Fecha:</label>
                <input type="date" class="form-control" name="date"
                       value="<?= htmlspecialchars($selectedDate) ?>">
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
                <a href="<?= BASE_URL ?>/services/sales" class="btn btn-outline-secondary">
                    <i class="bi bi-calendar-day"></i> Hoy
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Summary cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-success text-center">
            <div class="card-body">
                <i class="bi bi-cash-coin display-5 text-success"></i>
                <h5 class="mt-2">Total del Día</h5>
                <h3 class="text-success">$<?= number_format($dayTotal, 2) ?></h3>
                <small class="text-muted"><?= count($sales) ?> ventas</small>
            </div>
        </div>
    </div>
    <?php foreach ($dailyReport as $r): ?>
    <div class="col-md-3">
        <div class="card border-info text-center">
            <div class="card-body">
                <h6 class="text-muted"><?= htmlspecialchars($r['service_name']) ?></h6>
                <?php if ($r['category']): ?>
                <span class="badge bg-info"><?= htmlspecialchars($r['category']) ?></span>
                <?php endif; ?>
                <h4 class="mt-2">$<?= number_format($r['total_amount'], 2) ?></h4>
                <small class="text-muted"><?= $r['total_qty'] ?> unidades</small>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<?php if (empty($sales)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-list-ul display-1 text-muted"></i>
        <h3 class="mt-3">Sin ventas en esta fecha</h3>
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
                        <th>Servicio</th>
                        <th>Categoría</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                        <th>Método Pago</th>
                        <th>Efectivo/Cambio</th>
                        <th>Cajero</th>
                        <th>Fecha/Hora</th>
                        <th>Notas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td>#<?= $sale['id'] ?></td>
                        <td><strong><?= htmlspecialchars($sale['service_name']) ?></strong></td>
                        <td><?= htmlspecialchars($sale['category'] ?? '-') ?></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td>$<?= number_format($sale['unit_price'], 2) ?></td>
                        <td><strong class="text-success">$<?= number_format($sale['subtotal'], 2) ?></strong></td>
                        <td>
                            <?php
                            $pmLabels = [
                                'efectivo'           => ['💵 Efectivo', 'success'],
                                'tarjeta'            => ['💳 Tarjeta', 'primary'],
                                'transferencia'      => ['🏦 Transferencia', 'info'],
                                'intercambio'        => ['🔄 Intercambio', 'warning'],
                                'pendiente_por_cobrar'=> ['⏳ Pendiente', 'danger'],
                            ];
                            [$pmText, $pmClass] = $pmLabels[$sale['payment_method']] ?? [$sale['payment_method'], 'secondary'];
                            ?>
                            <span class="badge bg-<?= $pmClass ?>"><?= $pmText ?></span>
                        </td>
                        <td>
                            <?php if ($sale['payment_method'] === 'efectivo' && $sale['cash_received'] !== null): ?>
                                <small>Recibido: $<?= number_format($sale['cash_received'], 2) ?><br>
                                Cambio: $<?= number_format($sale['change_amount'] ?? 0, 2) ?></small>
                            <?php else: ?>-<?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($sale['cashier_name']) ?></td>
                        <td><small><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></small></td>
                        <td><small><?= htmlspecialchars($sale['notes'] ?? '-') ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
