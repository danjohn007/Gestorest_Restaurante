<?php $title = 'Generar Ticket – Pedido #' . $order['id']; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-receipt-cutoff"></i> Generar Ticket</h1>
    <a href="<?= BASE_URL ?>/orders" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver a Pedidos
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-receipt"></i> Pedido #<?= $order['id'] ?></h5>
            </div>
            <div class="card-body">
                <?php
                $total    = floatval($order['total']);
                $subtotal = round($total / 1.16, 2);
                $tax      = round($total - $subtotal, 2);
                ?>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Mesa:</div>
                    <div class="col-6"><?= !empty($order['table_number']) ? 'Mesa ' . htmlspecialchars($order['table_number']) : '—' ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">Subtotal:</div>
                    <div class="col-6">$<?= number_format($subtotal, 2) ?></div>
                </div>
                <div class="row mb-2">
                    <div class="col-6 fw-bold">IVA (16%):</div>
                    <div class="col-6">$<?= number_format($tax, 2) ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 fw-bold fs-5">Total:</div>
                    <div class="col-6 fs-5 text-success fw-bold">$<?= number_format($total, 2) ?></div>
                </div>
                <hr>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Método de Pago</label>
                        <select class="form-select" name="payment_method" id="paymentMethod" required>
                            <option value="">Sin especificar</option>
                            <option value="efectivo">💵 Efectivo</option>
                            <option value="tarjeta">💳 Tarjeta</option>
                            <option value="transferencia">🏦 Transferencia</option>
                            <option value="intercambio">🔄 Intercambio</option>
                            <option value="pendiente_por_cobrar">⏳ Pendiente por Cobrar</option>
                        </select>
                    </div>

                    <!-- Cash section (visible when efectivo is selected) -->
                    <div id="cashSection" class="mb-3" style="display:none;">
                        <div class="card border-success bg-light">
                            <div class="card-body py-2">
                                <h6 class="mb-2"><i class="bi bi-cash-coin"></i> Efectivo Recibido</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="form-label small mb-1">Cantidad Recibida</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="cash_received"
                                                   id="cashReceivedInput" step="0.01" min="<?= $total ?>"
                                                   placeholder="<?= number_format($total, 2) ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <label class="form-label small mb-1">Cambio a Devolver</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control fw-bold text-success"
                                                   id="changeAmountDisplay" readonly value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="<?= BASE_URL ?>/orders" class="btn btn-outline-secondary flex-fill">
                            <i class="bi bi-x"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-success flex-fill">
                            <i class="bi bi-check-circle"></i> Generar Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const total         = <?= $total ?>;
const payMethod     = document.getElementById('paymentMethod');
const cashSection   = document.getElementById('cashSection');
const cashInput     = document.getElementById('cashReceivedInput');
const changeDisplay = document.getElementById('changeAmountDisplay');

function toggleCash() {
    cashSection.style.display = payMethod.value === 'efectivo' ? 'block' : 'none';
    updateChange();
}

function updateChange() {
    const cash   = parseFloat(cashInput.value) || 0;
    const change = cash - total;
    changeDisplay.value = change >= 0 ? change.toFixed(2) : '0.00';
    changeDisplay.className = 'form-control fw-bold ' + (change >= 0 ? 'text-success' : 'text-danger');
}

payMethod.addEventListener('change', toggleCash);
cashInput.addEventListener('input', updateChange);
</script>
