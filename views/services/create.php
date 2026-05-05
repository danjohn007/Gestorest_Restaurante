<?php $title = 'Nuevo Servicio'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-plus-circle"></i> Nuevo Servicio</h1>
    <a href="<?= BASE_URL ?>/services" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<?php if (isset($error)): ?>
<div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-body">
        <form method="POST" action="<?= BASE_URL ?>/services/create">
            <div class="mb-3">
                <label class="form-label">Nombre del Servicio *</label>
                <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="description" rows="3"><?= htmlspecialchars($old['description'] ?? '') ?></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Precio *</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" name="price" step="0.01" min="0.01" value="<?= htmlspecialchars($old['price'] ?? '') ?>" required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Categoría</label>
                    <input type="text" class="form-control" name="category" list="categories" value="<?= htmlspecialchars($old['category'] ?? '') ?>">
                    <datalist id="categories">
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Guardar Servicio
            </button>
        </form>
    </div>
</div>
