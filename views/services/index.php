<?php $title = 'Servicios'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-stars"></i> Servicios</h1>
    <div>
        <a href="<?= BASE_URL ?>/services/sell" class="btn btn-success me-2">
            <i class="bi bi-cart-plus"></i> Registrar Venta
        </a>
        <a href="<?= BASE_URL ?>/services/sales" class="btn btn-outline-info me-2">
            <i class="bi bi-list-ul"></i> Historial Ventas
        </a>
        <?php if ($user['role'] === ROLE_ADMIN): ?>
        <a href="<?= BASE_URL ?>/services/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Nuevo Servicio
        </a>
        <?php endif; ?>
    </div>
</div>

<!-- Today's summary -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-success">
            <div class="card-body text-center">
                <i class="bi bi-cash-coin display-5 text-success"></i>
                <h5 class="mt-2">Ventas de Servicios Hoy</h5>
                <h3 class="text-success">$<?= number_format($todayTotal, 2) ?></h3>
                <small class="text-muted"><?= count($todaySales) ?> transacciones</small>
            </div>
        </div>
    </div>
</div>

<!-- Search/filter bar -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar:</label>
                <input type="text" class="form-control" name="search"
                       placeholder="Nombre, descripción..."
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Categoría:</label>
                <select class="form-select" name="category">
                    <option value="">Todas</option>
                    <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"
                        <?= (($_GET['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php if ($user['role'] === ROLE_ADMIN): ?>
            <div class="col-md-2">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="include_inactive" id="include_inactive"
                           <?= isset($_GET['include_inactive']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="include_inactive">Incluir inactivos</label>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-primary">
                    <i class="bi bi-search"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<?php if (empty($services)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-stars display-1 text-muted"></i>
        <h3 class="mt-3">No hay servicios registrados</h3>
        <?php if ($user['role'] === ROLE_ADMIN): ?>
        <a href="<?= BASE_URL ?>/services/create" class="btn btn-primary mt-3">
            <i class="bi bi-plus-circle"></i> Crear Primer Servicio
        </a>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($services as $svc): ?>
    <div class="col">
        <div class="card h-100 <?= $svc['active'] ? '' : 'border-secondary opacity-75' ?>">
            <?php if (!empty($svc['image'])): ?>
            <img src="<?= BASE_URL ?>/public/images/<?= htmlspecialchars($svc['image']) ?>"
                 class="card-img-top" style="height:180px;object-fit:cover;" alt="<?= htmlspecialchars($svc['name']) ?>">
            <?php endif; ?>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <h5 class="card-title"><?= htmlspecialchars($svc['name']) ?></h5>
                    <?php if (!$svc['active']): ?>
                    <span class="badge bg-secondary">Inactivo</span>
                    <?php endif; ?>
                </div>
                <?php if (!empty($svc['category'])): ?>
                <span class="badge bg-info mb-2"><?= htmlspecialchars($svc['category']) ?></span>
                <?php endif; ?>
                <p class="card-text text-muted"><?= nl2br(htmlspecialchars($svc['description'] ?? '')) ?></p>
                <p class="card-text"><strong class="text-success fs-5">$<?= number_format($svc['price'], 2) ?></strong></p>
            </div>
            <div class="card-footer d-flex gap-2">
                <a href="<?= BASE_URL ?>/services/sell?service_id=<?= $svc['id'] ?>"
                   class="btn btn-success btn-sm flex-fill">
                    <i class="bi bi-cart-plus"></i> Vender
                </a>
                <?php if ($user['role'] === ROLE_ADMIN): ?>
                <a href="<?= BASE_URL ?>/services/edit/<?= $svc['id'] ?>"
                   class="btn btn-outline-warning btn-sm">
                    <i class="bi bi-pencil"></i>
                </a>
                <a href="<?= BASE_URL ?>/services/toggle/<?= $svc['id'] ?>"
                   class="btn btn-outline-secondary btn-sm"
                   onclick="return confirm('<?= $svc['active'] ? '¿Desactivar servicio?' : '¿Activar servicio?' ?>')">
                    <i class="bi bi-<?= $svc['active'] ? 'eye-slash' : 'eye' ?>"></i>
                </a>
                <a href="<?= BASE_URL ?>/services/delete/<?= $svc['id'] ?>"
                   class="btn btn-outline-danger btn-sm"
                   onclick="return confirm('¿Eliminar servicio permanentemente?')">
                    <i class="bi bi-trash"></i>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
