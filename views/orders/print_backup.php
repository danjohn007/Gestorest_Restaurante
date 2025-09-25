<?php $title = 'Imprimir Pedido #' . $order['id']; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-printer"></i> Imprimir Pedido #<?= $order['id'] ?></h1>
    <div class="no-print">
        <a href="<?= BASE_URL ?>/orders" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button onclick="window.print()" class="btn btn-primary">
            <i class="bi bi-printer"></i> Imprimir
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Información del Pedido</h5>
                <p><strong>Pedido #:</strong> <?= $order['id'] ?></p>
                <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                <p><strong>Estado:</strong> <?= $order['status'] ?></p>
            </div>
            <div class="col-md-6">
                <h5>Detalles de Servicio</h5>
                <?php if (!empty($order['table_name'])): ?>
                <p><strong>Mesa:</strong> <?= htmlspecialchars($order['table_name']) ?></p>
                <?php endif; ?>
                <p><strong>Mesero:</strong> <?= htmlspecialchars($order['waiter_name'] ?? 'No asignado') ?></p>
            </div>
        </div>

        <h5>Platillos</h5>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Platillo</th>
                        <th>Cantidad</th>
                        <th>Precio Unit.</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($order['items'])): ?>
                        <?php foreach ($order['items'] as $item): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($item['dish_name']) ?>
                                <?php if (!empty($item['notes'])): ?>
                                    <br><small class="text-muted">Nota: <?= htmlspecialchars($item['notes']) ?></small>
                                <?php endif; ?>
                            </td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] ?? $item['unit_price'] ?? 0, 2) ?></td>
                            <td>$<?= number_format($item['subtotal'] ?? ($item['quantity'] * ($item['price'] ?? $item['unit_price'] ?? 0)), 2) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay platillos en este pedido</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot>
                    <tr class="table-dark">
                        <th colspan="3">Total</th>
                        <th>$<?= number_format($order['total'], 2) ?></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { color: #000; }
        .card { border: none; box-shadow: none; }
    }
</style>