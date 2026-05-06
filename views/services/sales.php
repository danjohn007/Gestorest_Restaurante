<?php $title = 'Ventas de Servicios'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-cash-coin"></i> Ventas de Servicios</h1>
    <div>
        <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Catálogo
        </a>
    </div>
</div>

<!-- Formulario de nueva venta -->
<div class="row mb-4">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Registrar Venta</h5>
            </div>
            <div class="card-body">
                <?php if (empty($services)): ?>
                <div class="alert alert-warning">
                    No hay servicios disponibles. <a href="<?= BASE_URL ?>/services/create">Crear servicio</a>
                </div>
                <?php else: ?>
                <form method="POST" action="<?= BASE_URL ?>/services/registerSale" id="saleForm">
                    <div class="mb-3">
                        <label class="form-label">Servicio *</label>
                        <select class="form-select" name="service_id" id="serviceSelect" required>
                            <option value="">Seleccionar servicio...</option>
                            <?php foreach ($services as $service): ?>
                            <option value="<?= $service['id'] ?>" data-price="<?= $service['price'] ?>">
                                <?= htmlspecialchars($service['name']) ?> - $<?= number_format($service['price'], 2) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Cantidad *</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="1" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Total</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control bg-light" id="totalDisplay" value="0.00" readonly>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Método de Pago *</label>
                        <select class="form-select" name="payment_method" id="paymentMethod" required>
                            <option value="efectivo">Efectivo</option>
                            <option value="tarjeta">Tarjeta</option>
                            <option value="transferencia">Transferencia</option>
                        </select>
                    </div>
                    <div class="mb-3" id="cashSection" style="display:none;">
                        <label class="form-label">Efectivo Recibido</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" class="form-control" name="cash_received" id="cashReceived" step="0.01" min="0">
                        </div>
                        <div id="changeDisplay" class="mt-2 d-none">
                            <span class="text-success fw-bold">Cambio: $<span id="changeAmount">0.00</span></span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Reservación *</label>
                        <input type="date" class="form-control" name="reservation_date" value="<?= date('Y-m-d') ?>" required>
                        <div class="form-text">Fecha en que se realizará el servicio.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Notas</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Registrar Venta
                    </button>
                </form>
                <script>
                (function() {
                var servicePrice = 0;
                function updatePrice() {
                    var select = document.getElementById('serviceSelect');
                    var option = select.options[select.selectedIndex];
                    servicePrice = parseFloat(option.dataset.price || 0);
                    calculateTotal();
                    toggleCash();
                }
                function calculateTotal() {
                    var qty = parseInt(document.getElementById('quantity').value || 1);
                    var total = servicePrice * qty;
                    document.getElementById('totalDisplay').value = total.toFixed(2);
                    calculateChange();
                }
                function toggleCash() {
                    var method = document.getElementById('paymentMethod').value;
                    var cashSection = document.getElementById('cashSection');
                    if (method === 'efectivo') {
                        cashSection.style.display = 'block';
                    } else {
                        cashSection.style.display = 'none';
                    }
                }
                function calculateChange() {
                    var cashReceived = parseFloat(document.getElementById('cashReceived').value || 0);
                    var qty = parseInt(document.getElementById('quantity').value || 1);
                    var total = servicePrice * qty;
                    var change = cashReceived - total;
                    var changeDisplay = document.getElementById('changeDisplay');
                    var changeAmount = document.getElementById('changeAmount');
                    if (cashReceived > 0 && change >= 0) {
                        changeDisplay.classList.remove('d-none');
                        changeAmount.textContent = change.toFixed(2);
                    } else {
                        changeDisplay.classList.add('d-none');
                    }
                }
                document.getElementById('serviceSelect').addEventListener('change', updatePrice);
                document.getElementById('quantity').addEventListener('change', calculateTotal);
                document.getElementById('paymentMethod').addEventListener('change', toggleCash);
                document.getElementById('cashReceived').addEventListener('input', calculateChange);
                // Init
                toggleCash();
                })();
                </script>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <!-- Date Filter -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" class="form-control" name="date" value="<?= htmlspecialchars($selectedDate) ?>">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-funnel"></i> Filtrar
                        </button>
                    </div>
                    <div class="col-md-3">
                        <a href="<?= BASE_URL ?>/services/sales?date=<?= date('Y-m-d') ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-calendar-day"></i> Hoy
                        </a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Summary -->
        <?php if (!empty($totals)): ?>
        <div class="card mb-3 border-success">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h5 class="text-success">$<?= number_format($totals['total_income'] ?? 0, 2) ?></h5>
                        <small class="text-muted">Total Ingresos</small>
                    </div>
                    <div class="col-6">
                        <h5><?= $totals['total_sales'] ?? 0 ?></h5>
                        <small class="text-muted">Ventas del Día</small>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Sales list -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Ventas del <?= date('d/m/Y', strtotime($selectedDate)) ?></h5>
    </div>
    <div class="card-body">
        <?php if (empty($sales)): ?>
        <div class="text-center py-4">
            <i class="bi bi-inbox display-4 text-muted"></i>
            <p class="mt-2 text-muted">No hay ventas registradas para esta fecha</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Servicio</th>
                        <th>Categoría</th>
                        <th>Cant.</th>
                        <th>Precio Unit.</th>
                        <th>Total</th>
                        <th>Pago</th>
                        <th>Cajero</th>
                        <th>Fecha Reservación</th>
                        <th>Hora Registro</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><strong>#<?= $sale['id'] ?></strong></td>
                        <td><?= htmlspecialchars($sale['service_name']) ?></td>
                        <td><span class="badge bg-info"><?= htmlspecialchars($sale['category'] ?? 'General') ?></span></td>
                        <td><?= $sale['quantity'] ?></td>
                        <td>$<?= number_format($sale['unit_price'], 2) ?></td>
                        <td><strong class="text-success">$<?= number_format($sale['total'], 2) ?></strong></td>
                        <td>
                            <span class="badge <?= $sale['payment_method'] === 'efectivo' ? 'bg-success' : ($sale['payment_method'] === 'tarjeta' ? 'bg-primary' : 'bg-info') ?>">
                                <?= ucfirst($sale['payment_method']) ?>
                            </span>
                            <?php if ($sale['payment_method'] === 'efectivo' && $sale['cash_received']): ?>
                            <br><small class="text-muted">Recibido: $<?= number_format($sale['cash_received'], 2) ?></small>
                            <br><small class="text-success">Cambio: $<?= number_format($sale['change_amount'], 2) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($sale['cashier_name']) ?></td>
                        <td>
                            <?php
                                $resDate = $sale['reservation_date'] ?? null;
                                echo $resDate ? date('d/m/Y', strtotime($resDate)) : date('d/m/Y', strtotime($sale['created_at']));
                            ?>
                        </td>
                        <td><small><?= date('H:i', strtotime($sale['created_at'])) ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
