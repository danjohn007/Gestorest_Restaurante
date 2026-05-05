<?php $title = 'Editar Servicio'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-pencil"></i> Editar Servicio</h1>
    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/services/edit/<?= $service['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Nombre del Servicio *</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($service['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($service['description'] ?? '') ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="price" step="0.01" min="0.01" value="<?= htmlspecialchars($service['price']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" class="form-control" name="category" list="categories" value="<?= htmlspecialchars($service['category'] ?? '') ?>">
                    <datalist id="categories">
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="active" id="active" <?= $service['active'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="active">Activo</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Actualizar Servicio
            </button>
        </form>
    </div>
</div>
