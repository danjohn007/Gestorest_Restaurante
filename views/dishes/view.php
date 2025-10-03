<?php $title = 'Detalles del Platillo'; ?>

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/dishes.css">

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-eye"></i> Detalles del Platillo</h1>
    <div>
        <a href="<?= BASE_URL ?>/dishes/edit/<?= $dish['id'] ?>" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i> Editar
        </a>
        <a href="<?= BASE_URL ?>/dishes" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
    </div>
</div>

<div class="row">
    <!-- Imagen del platillo -->
    <?php if ($dish['image']): ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-image"></i> Imagen
                </h6>
            </div>
            <div class="card-body text-center">
                <?php
                // Extraer solo el nombre del archivo de la ruta completa
                $imageName = basename($dish['image']);
                $imageUrl = BASE_URL . '/image_server.php?file=' . urlencode($imageName);
                ?>
                <img src="<?= $imageUrl ?>" 
                     alt="<?= htmlspecialchars($dish['name']) ?>" 
                     class="img-fluid rounded shadow-sm dish-detail-image"
                     style="max-height: 300px; cursor: pointer;"
                     onclick="showImageModal('<?= $imageUrl ?>', '<?= htmlspecialchars($dish['name'], ENT_QUOTES) ?>')"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="alert alert-warning" style="display: none;">
                    <i class="bi bi-exclamation-triangle"></i> No se pudo cargar la imagen: <?= htmlspecialchars($imageName) ?>
                </div>
                <div class="mt-2">
                    <small class="text-muted">Click para ver en tamaño completo</small>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <div class="<?= $dish['image'] ? 'col-md-8' : 'col-md-8' ?>">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <?= htmlspecialchars($dish['name']) ?>
                    <?php if ($dish['category']): ?>
                        <span class="badge bg-secondary ms-2"><?= htmlspecialchars($dish['category']) ?></span>
                    <?php endif; ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Precio</h6>
                        <p class="h4 text-success">$<?= number_format($dish['price'], 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6>Categoría</h6>
                        <p><?= $dish['category'] ? htmlspecialchars($dish['category']) : 'Sin categoría' ?></p>
                    </div>
                </div>
                
                <?php if ($dish['description']): ?>
                <hr>
                <h6>Descripción</h6>
                <p><?= nl2br(htmlspecialchars($dish['description'])) ?></p>
                <?php endif; ?>
                
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($dish['created_at'])) ?>
                        </small>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted">
                            <strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($dish['updated_at'])) ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="bi bi-bar-chart"></i> Estadísticas
                </h6>
            </div>
            <div class="card-body">
                <?php if ($stats && $stats['times_ordered'] > 0): ?>
                    <div class="mb-3">
                        <small class="text-muted">Veces ordenado</small>
                        <h5 class="text-primary"><?= $stats['times_ordered'] ?></h5>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Cantidad total vendida</small>
                        <h5 class="text-info"><?= $stats['total_quantity'] ?></h5>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Ingresos generados</small>
                        <h5 class="text-success">$<?= number_format($stats['total_revenue'], 2) ?></h5>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Promedio por orden</small>
                        <h5 class="text-warning"><?= round($stats['avg_quantity_per_order'], 1) ?></h5>
                    </div>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="bi bi-graph-down text-muted display-6"></i>
                        <p class="text-muted mt-2">Sin estadísticas</p>
                        <small class="text-muted">
                            Este platillo aún no ha sido ordenado
                        </small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal para mostrar imagen en tamaño completo -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Imagen del Platillo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>

<script>
function showImageModal(imageSrc, dishName) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('modalImage').alt = dishName;
    document.getElementById('imageModalLabel').textContent = dishName;
    
    var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
    imageModal.show();
}
</script>