<?php $title = 'Registrar Venta de Servicio'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-cart-plus"></i> Registrar Venta de Servicio</h1>
    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver a Servicios
    </a>
</div>

<?php if (!empty($errors['general'])): ?>
<div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<?php if (empty($services)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-exclamation-triangle display-1 text-warning"></i>
        <h3 class="mt-3">No hay servicios disponibles</h3>
        <p class="text-muted">Solicite al administrador que agregue servicios al catálogo.</p>
        <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>
<?php else: ?>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-stars"></i> Seleccionar Servicio</h5></div>
            <div class="card-body">
                <form method="POST" id="sellForm">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Servicio *</label>
                        <select class="form-select <?= !empty($errors['service_id']) ? 'is-invalid' : '' ?>"
                                name="service_id" id="serviceSelect" required>
                            <option value="">-- Seleccionar servicio --</option>
                            <?php foreach ($services as $svc): ?>
                            <option value="<?= $svc['id'] ?>"
                                    data-price="<?= $svc['price'] ?>"
                                    data-name="<?= htmlspecialchars($svc['name']) ?>"
                                    <?= (($old['service_id'] ?? $_GET['service_id'] ?? '') == $svc['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($svc['name']) ?>
                                <?php if ($svc['category']): ?>(<?= htmlspecialchars($svc['category']) ?>)<?php endif; ?>
                                – $<?= number_format($svc['price'], 2) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($errors['service_id'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['service_id']) ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Cantidad *</label>
                            <input type="number" class="form-control <?= !empty($errors['quantity']) ? 'is-invalid' : '' ?>"
                                   name="quantity" id="quantity" min="1" value="<?= intval($old['quantity'] ?? 1) ?>" required>
                            <?php if (!empty($errors['quantity'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['quantity']) ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Precio Unitario</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="text" class="form-control" id="unitPrice" readonly value="">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Subtotal</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="text" class="form-control fs-5 fw-bold text-success" id="subtotal" readonly value="">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Método de Pago *</label>
                        <select class="form-select <?= !empty($errors['payment_method']) ? 'is-invalid' : '' ?>"
                                name="payment_method" id="paymentMethod" required>
                            <option value="efectivo"   <?= (($old['payment_method'] ?? 'efectivo') === 'efectivo')   ? 'selected' : '' ?>>💵 Efectivo</option>
                            <option value="tarjeta"    <?= (($old['payment_method'] ?? '') === 'tarjeta')    ? 'selected' : '' ?>>💳 Tarjeta</option>
                            <option value="transferencia" <?= (($old['payment_method'] ?? '') === 'transferencia') ? 'selected' : '' ?>>🏦 Transferencia</option>
                            <option value="intercambio"   <?= (($old['payment_method'] ?? '') === 'intercambio')   ? 'selected' : '' ?>>🔄 Intercambio</option>
                        </select>
                        <?php if (!empty($errors['payment_method'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['payment_method']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- Cash received / change (efectivo only) -->
                    <div id="cashSection" class="mb-3" style="display:none;">
                        <div class="card bg-light border-success">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">💵 Efectivo Recibido</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="cash_received"
                                                   id="cashReceived" step="0.01" min="0"
                                                   value="<?= htmlspecialchars($old['cash_received'] ?? '') ?>"
                                                   placeholder="0.00">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Cambio a Devolver</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="text" class="form-control fs-5 fw-bold text-danger"
                                                   id="changeAmount" readonly value="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notas (opcional)</label>
                        <textarea class="form-control" name="notes" rows="2"><?= htmlspecialchars($old['notes'] ?? '') ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-check-circle"></i> Registrar Venta
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><i class="bi bi-info-circle"></i> Servicios Disponibles</h5></div>
            <div class="card-body" style="max-height:420px;overflow-y:auto;">
                <div class="list-group">
                    <?php foreach ($services as $svc): ?>
                    <button type="button" class="list-group-item list-group-item-action"
                            onclick="selectService(<?= $svc['id'] ?>, '<?= addslashes($svc['name']) ?>', <?= $svc['price'] ?>)">
                        <div class="d-flex justify-content-between">
                            <span><?= htmlspecialchars($svc['name']) ?></span>
                            <strong class="text-success">$<?= number_format($svc['price'], 2) ?></strong>
                        </div>
                        <?php if ($svc['category']): ?>
                        <small class="text-muted"><?= htmlspecialchars($svc['category']) ?></small>
                        <?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const serviceSelect = document.getElementById('serviceSelect');
const quantityInput = document.getElementById('quantity');
const unitPriceInput = document.getElementById('unitPrice');
const subtotalInput  = document.getElementById('subtotal');
const paymentMethodSelect = document.getElementById('paymentMethod');
const cashSection    = document.getElementById('cashSection');
const cashReceived   = document.getElementById('cashReceived');
const changeAmount   = document.getElementById('changeAmount');

function updateSubtotal() {
    const opt = serviceSelect.options[serviceSelect.selectedIndex];
    const price = parseFloat(opt ? opt.dataset.price : 0) || 0;
    const qty   = parseInt(quantityInput.value) || 1;
    const sub   = price * qty;
    unitPriceInput.value = price.toFixed(2);
    subtotalInput.value  = sub.toFixed(2);
    updateChange();
}

function updateChange() {
    const sub  = parseFloat(subtotalInput.value) || 0;
    const cash = parseFloat(cashReceived.value)  || 0;
    const diff = cash - sub;
    changeAmount.value = diff >= 0 ? diff.toFixed(2) : '0.00';
    changeAmount.classList.toggle('text-danger', diff < 0);
    changeAmount.classList.toggle('text-success', diff >= 0);
}

function toggleCashSection() {
    const isCash = paymentMethodSelect.value === 'efectivo';
    cashSection.style.display = isCash ? 'block' : 'none';
}

function selectService(id, name, price) {
    serviceSelect.value = id;
    updateSubtotal();
}

serviceSelect.addEventListener('change', updateSubtotal);
quantityInput.addEventListener('input', updateSubtotal);
paymentMethodSelect.addEventListener('change', toggleCashSection);
cashReceived.addEventListener('input', updateChange);

// Init
updateSubtotal();
toggleCashSection();
</script>
<?php endif; ?>
