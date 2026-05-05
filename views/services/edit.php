<?php $title = 'Editar Servicio'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-pencil"></i> Editar Servicio</h1>
    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<?php if (!empty($errors['general'])): ?>
<div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header"><h5 class="mb-0">Información del Servicio</h5></div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nombre del Servicio *</label>
                <input type="text" class="form-control <?= !empty($errors['name']) ? 'is-invalid' : '' ?>"
                       name="name" value="<?= htmlspecialchars($service['name'] ?? '') ?>" required>
                <?php if (!empty($errors['name'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                <?php endif; ?>
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
                        <input type="number" class="form-control <?= !empty($errors['price']) ? 'is-invalid' : '' ?>"
                               name="price" step="0.01" min="0.01"
                               value="<?= htmlspecialchars($service['price'] ?? '') ?>" required>
                        <?php if (!empty($errors['price'])): ?>
                        <div class="invalid-feedback"><?= htmlspecialchars($errors['price']) ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" class="form-control" name="category"
                           list="category_list"
                           value="<?= htmlspecialchars($service['category'] ?? '') ?>"
                           placeholder="Ej. Recreación, Renta, Spa...">
                    <datalist id="category_list">
                        <?php foreach ($categories ?? [] as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>">
        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
            <?php if (!empty($service['image'])): ?>
            <div class="mb-3">
                <label class="form-label">Imagen actual:</label><br>
                <img src="<?= BASE_URL ?>/public/images/<?= htmlspecialchars($service['image']) ?>"
                     style="max-height:120px;border-radius:6px;" alt="Imagen del servicio">
            </div>
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Nueva Imagen (opcional)</label>
                <input type="file" class="form-control" name="image" accept="image/jpeg,image/png,image/gif">
                <small class="text-muted">JPG, PNG o GIF – máx. 5 MB</small>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" name="active" id="active"
                       <?= ($service['active'] ?? 1) ? 'checked' : '' ?>>
                <label class="form-check-label" for="active">Servicio activo</label>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Guardar Cambios
            </button>
        </form>
    </div>
</div>
