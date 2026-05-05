<?php $title = 'Servicios'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-stars"></i> Módulo de Servicios</h1>
    <div>
        <a href="<?= BASE_URL ?>/services/sales" class="btn btn-success me-2">
            <i class="bi bi-cash-coin"></i> Registrar Venta
        </a>
        <a href="<?= BASE_URL ?>/services/report" class="btn btn-outline-info me-2">
            <i class="bi bi-graph-up"></i> Reportes
        </a>
        <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
        <a href="<?= BASE_URL ?>/services/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Servicio
        </a>
        <?php endif; ?>
    </div>
</div>

<?php if (empty($services)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-stars display-1 text-muted"></i>
        <h3 class="mt-3">No hay servicios registrados</h3>
        <p class="text-muted">Registra tus servicios adicionales (amenidades, actividades, etc.)</p>
        <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
        <a href="<?= BASE_URL ?>/services/create" class="btn btn-primary mt-2">
            <i class="bi bi-plus-circle"></i> Crear Primer Servicio
        </a>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="row">
    <?php foreach ($services as $service): ?>
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h5 class="card-title"><?= htmlspecialchars($service['name']) ?></h5>
                        <?php if ($service['category']): ?>
                        <span class="badge bg-info mb-2"><?= htmlspecialchars($service['category']) ?></span>
                        <?php endif; ?>
                    </div>
                    <h4 class="text-success">$<?= number_format($service['price'], 2) ?></h4>
                </div>
                <?php if ($service['description']): ?>
                <p class="card-text text-muted small"><?= htmlspecialchars($service['description']) ?></p>
                <?php endif; ?>
            </div>
            <?php if ($_SESSION['user_role'] === ROLE_ADMIN): ?>
            <div class="card-footer">
                <a href="<?= BASE_URL ?>/services/edit/<?= $service['id'] ?>" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
                <a href="<?= BASE_URL ?>/services/delete/<?= $service['id'] ?>" 
                   class="btn btn-sm btn-outline-danger ms-1"
                   onclick="return confirm('¿Eliminar este servicio?')">
                    <i class="bi bi-trash"></i> Eliminar
                </a>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
