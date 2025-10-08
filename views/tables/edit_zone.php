<?php $title = 'Editar Zona'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-pencil-square"></i> Editar Zona</h1>
    <a href="<?= BASE_URL ?>/tables/zones" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Información de la Zona</h5>
            </div>
            <div class="card-body">
                <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
                </div>
                <?php endif; ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-geo-alt"></i> Nombre de la Zona *
                        </label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                            id="name" 
                            name="name" 
                            value="<?= htmlspecialchars($old['name'] ?? $zone['name']) ?>"
                            placeholder="Ej: Salón, Terraza, Alberca..."
                            required
                            maxlength="50"
                        >
                        <?php if (isset($errors['name'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['name']) ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-text">
                            Nombre único para identificar la zona (máximo 50 caracteres)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">
                            <i class="bi bi-card-text"></i> Descripción
                        </label>
                        <textarea 
                            class="form-control <?= isset($errors['description']) ? 'is-invalid' : '' ?>" 
                            id="description" 
                            name="description" 
                            rows="3"
                            placeholder="Descripción opcional de la zona..."
                        ><?= htmlspecialchars($old['description'] ?? $zone['description']) ?></textarea>
                        <?php if (isset($errors['description'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['description']) ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-text">
                            Descripción detallada de la zona (opcional)
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="color" class="form-label">
                            <i class="bi bi-palette"></i> Color Identificativo
                        </label>
                        <div class="input-group">
                            <input 
                                type="color" 
                                class="form-control form-control-color <?= isset($errors['color']) ? 'is-invalid' : '' ?>" 
                                id="color" 
                                name="color" 
                                value="<?= htmlspecialchars($old['color'] ?? $zone['color']) ?>"
                                style="max-width: 60px;"
                            >
                            <input 
                                type="text" 
                                class="form-control" 
                                id="colorHex" 
                                value="<?= htmlspecialchars($old['color'] ?? $zone['color']) ?>"
                                readonly
                            >
                        </div>
                        <?php if (isset($errors['color'])): ?>
                        <div class="invalid-feedback">
                            <?= htmlspecialchars($errors['color']) ?>
                        </div>
                        <?php endif; ?>
                        <div class="form-text">
                            Color que se usará para identificar visualmente la zona
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="width" class="form-label">
                                    <i class="bi bi-arrows-expand"></i> Ancho (px)
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control <?= isset($errors['width']) ? 'is-invalid' : '' ?>" 
                                    id="width" 
                                    name="width" 
                                    value="<?= htmlspecialchars($old['width'] ?? $zone['width'] ?? '400') ?>"
                                    min="150"
                                    max="1000"
                                    step="10"
                                >
                                <?php if (isset($errors['width'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['width']) ?>
                                </div>
                                <?php endif; ?>
                                <div class="form-text">
                                    Ancho de la zona en el layout (150-1000px)
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="height" class="form-label">
                                    <i class="bi bi-arrows-expand"></i> Alto (px)
                                </label>
                                <input 
                                    type="number" 
                                    class="form-control <?= isset($errors['height']) ? 'is-invalid' : '' ?>" 
                                    id="height" 
                                    name="height" 
                                    value="<?= htmlspecialchars($old['height'] ?? $zone['height'] ?? '300') ?>"
                                    min="100"
                                    max="800"
                                    step="10"
                                >
                                <?php if (isset($errors['height'])): ?>
                                <div class="invalid-feedback">
                                    <?= htmlspecialchars($errors['height']) ?>
                                </div>
                                <?php endif; ?>
                                <div class="form-text">
                                    Alto de la zona en el layout (100-800px)
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?= BASE_URL ?>/tables/zones" class="btn btn-secondary me-md-2">
                            <i class="bi bi-x-circle"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Actualizar Zona
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const colorInput = document.getElementById('color');
    const colorHex = document.getElementById('colorHex');
    
    colorInput.addEventListener('input', function() {
        colorHex.value = this.value;
    });
    
    colorHex.addEventListener('input', function() {
        if (/^#[0-9A-F]{6}$/i.test(this.value)) {
            colorInput.value = this.value;
        }
    });
});
</script>
