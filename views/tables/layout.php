<?php $title = 'Layout de Mesas'; ?>

<style>
#layoutContainer {
    position: relative;
    background-color: #f8f9fa;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    overflow: auto;
    min-height: 600px;
    background-image: 
        linear-gradient(rgba(0, 0, 0, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(0, 0, 0, 0.05) 1px, transparent 1px);
    background-size: 50px 50px;
    cursor: move;
}

.table-item {
    position: absolute;
    width: 80px;
    height: 80px;
    background-color: #ffffff;
    border: 2px solid #0d6efd;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: move;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.2s, transform 0.2s;
    user-select: none;
}

.table-item:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform: scale(1.05);
    z-index: 1000;
}

.table-item.dragging {
    opacity: 0.5;
    z-index: 999;
}

.table-item .table-number {
    font-weight: bold;
    font-size: 1.2rem;
    color: #0d6efd;
}

.table-item .table-capacity {
    font-size: 0.8rem;
    color: #6c757d;
}

.table-item .table-actions {
    position: absolute;
    bottom: -30px;
    left: 0;
    right: 0;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 1001;
}

.table-item:hover .table-actions {
    opacity: 1;
}

.table-item .new-order-link {
    display: block;
    font-size: 0.7rem;
    padding: 2px 5px;
    background-color: #198754;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    white-space: nowrap;
}

.table-item .new-order-link:hover {
    background-color: #157347;
    color: white;
}

.table-item.status-disponible {
    border-color: #198754;
    background-color: #d1e7dd;
}

.table-item.status-disponible .table-number {
    color: #198754;
}

.table-item.status-ocupada {
    border-color: #dc3545;
    background-color: #f8d7da;
}

.table-item.status-ocupada .table-number {
    color: #dc3545;
}

.table-item.status-cuenta_solicitada {
    border-color: #ffc107;
    background-color: #fff3cd;
}

.table-item.status-cuenta_solicitada .table-number {
    color: #856404;
}

#layoutControls {
    position: sticky;
    top: 0;
    z-index: 1001;
    background-color: white;
    padding: 1rem;
    border-bottom: 2px solid #dee2e6;
    margin-bottom: 1rem;
}

.dimension-input {
    max-width: 120px;
}

.symbol-item {
    position: absolute;
    width: 100px;
    height: 100px;
    background-color: #f8f9fa;
    border: 2px solid #6c757d;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: move;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: box-shadow 0.2s, transform 0.2s;
    user-select: none;
}

.symbol-item:hover {
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    transform: scale(1.05);
    z-index: 1000;
}

.symbol-item.dragging {
    opacity: 0.5;
    z-index: 999;
}

.symbol-item .symbol-icon {
    font-size: 2rem;
    margin-bottom: 0.25rem;
}

.symbol-item .symbol-label {
    font-size: 0.7rem;
    font-weight: bold;
    text-align: center;
}

.symbol-item.type-puerta {
    border-color: #8b4513;
    background-color: #f5deb3;
}

.symbol-item.type-entrada {
    border-color: #28a745;
    background-color: #d4edda;
}

.symbol-item.type-barra {
    border-color: #dc3545;
    background-color: #f8d7da;
}

.symbol-item.type-caja {
    border-color: #ffc107;
    background-color: #fff3cd;
}

.symbol-item.type-cocina {
    border-color: #fd7e14;
    background-color: #ffe5d0;
}

.symbol-item.type-alberca {
    border-color: #17a2b8;
    background-color: #d1ecf1;
}

.symbol-item.type-terraza {
    border-color: #6c757d;
    background-color: #e2e3e5;
}

.symbol-item.type-patio {
    border-color: #20c997;
    background-color: #d4f4dd;
}

.symbol-item.type-puerta2 {
    border-color: #8b4513;
    background-color: #f5deb3;
}

.symbol-actions {
    position: absolute;
    bottom: -35px;
    left: 0;
    right: 0;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 1001;
    display: flex;
    justify-content: center;
    gap: 5px;
}

.symbol-item:hover .symbol-actions {
    opacity: 1;
}

.symbol-action-btn {
    display: inline-block;
    font-size: 0.7rem;
    padding: 2px 5px;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    white-space: nowrap;
}

.symbol-action-btn.duplicate {
    background-color: #0d6efd;
}

.symbol-action-btn.duplicate:hover {
    background-color: #0b5ed7;
}

.symbol-action-btn.delete {
    background-color: #dc3545;
}

.symbol-action-btn.delete:hover {
    background-color: #bb2d3b;
}

.zone-area {
    position: absolute;
    border: 2px dashed rgba(0, 0, 0, 0.3);
    border-radius: 8px;
    cursor: move;
    transition: opacity 0.2s, box-shadow 0.2s;
    z-index: 1;
    pointer-events: auto;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 10px;
}

.zone-area:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    border-style: solid;
}

.zone-area.dragging {
    opacity: 0.6;
    z-index: 998;
}

.zone-label {
    font-weight: bold;
    font-size: 0.9rem;
    text-shadow: 1px 1px 2px rgba(255, 255, 255, 0.8);
    pointer-events: none;
    user-select: none;
    padding: 4px 8px;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.7);
}

.zone-resize-handle {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 20px;
    height: 20px;
    cursor: nwse-resize;
    background: linear-gradient(135deg, transparent 50%, rgba(0, 0, 0, 0.3) 50%);
    border-radius: 0 0 6px 0;
}

.zone-actions {
    position: absolute;
    top: 10px;
    right: 10px;
    opacity: 0;
    transition: opacity 0.2s;
    display: flex;
    gap: 5px;
}

.zone-area:hover .zone-actions {
    opacity: 1;
}

.zone-action-btn {
    padding: 4px 8px;
    font-size: 0.75rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
    background-color: rgba(0, 0, 0, 0.6);
    transition: background-color 0.2s;
}

.zone-action-btn:hover {
    background-color: rgba(0, 0, 0, 0.8);
}
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-diagram-3"></i> Layout de Mesas</h1>
    <a href="<?= BASE_URL ?>/tables" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Volver a Mesas
    </a>
</div>

<?php if (isset($error)): ?>
    <div class="alert alert-danger">
        <i class="bi bi-exclamation-triangle"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if (isset($success)): ?>
    <div class="alert alert-success">
        <i class="bi bi-check-circle"></i> <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<div class="card">
    <div id="layoutControls" class="card-header">
        <div class="row align-items-center">
            <div class="col-md-6">
                <?php if ($user['role'] === ROLE_ADMIN): ?>
                <div class="d-flex gap-3 align-items-center">
                    <div>
                        <label class="form-label mb-1 small">Ancho (px):</label>
                        <input type="number" id="layoutWidth" class="form-control form-control-sm dimension-input" 
                               value="<?= isset($layoutSettings['width']) ? $layoutSettings['width'] : 1200 ?>" min="800" max="3000">
                    </div>
                    <div>
                        <label class="form-label mb-1 small">Alto (px):</label>
                        <input type="number" id="layoutHeight" class="form-control form-control-sm dimension-input" 
                               value="<?= isset($layoutSettings['height']) ? $layoutSettings['height'] : 800 ?>" min="600" max="2000">
                    </div>
                    <button type="button" class="btn btn-sm btn-primary mt-3" id="applyDimensions">
                        <i class="bi bi-arrows-fullscreen"></i> Aplicar
                    </button>
                </div>
                <?php else: ?>
                <div class="alert alert-info mb-0 py-2">
                    <i class="bi bi-info-circle"></i> Vista de solo lectura. Solo los administradores pueden modificar el layout.
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-6 text-end">
                <?php if ($user['role'] === ROLE_ADMIN): ?>
                <button type="button" class="btn btn-success" id="saveLayout">
                    <i class="bi bi-save"></i> Guardar Layout
                </button>
                <button type="button" class="btn btn-outline-secondary" id="resetPositions">
                    <i class="bi bi-arrow-clockwise"></i> Resetear Posiciones
                </button>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-3">
            <div class="d-flex gap-3 flex-wrap">
                <div class="d-flex align-items-center">
                    <div style="width: 20px; height: 20px; background-color: #d1e7dd; border: 2px solid #198754; border-radius: 4px;" class="me-2"></div>
                    <span class="small">Disponible</span>
                </div>
                <div class="d-flex align-items-center">
                    <div style="width: 20px; height: 20px; background-color: #f8d7da; border: 2px solid #dc3545; border-radius: 4px;" class="me-2"></div>
                    <span class="small">Ocupada</span>
                </div>
                <div class="d-flex align-items-center">
                    <div style="width: 20px; height: 20px; background-color: #fff3cd; border: 2px solid #ffc107; border-radius: 4px;" class="me-2"></div>
                    <span class="small">Cuenta Solicitada</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-body p-0">
        <div id="layoutContainer" style="width: <?= isset($layoutSettings['width']) ? $layoutSettings['width'] : 1200 ?>px; height: <?= isset($layoutSettings['height']) ? $layoutSettings['height'] : 800 ?>px;">
            <?php if (!empty($zones)): ?>
            <?php foreach ($zones as $zone): ?>
                <?php
                // Convert hex color to rgba with transparency
                $color = $zone['color'];
                if (preg_match('/^#([a-fA-F0-9]{6})$/', $color, $matches)) {
                    $hex = $matches[1];
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                    $bgColor = "rgba($r, $g, $b, 0.15)";
                    $borderColor = "rgba($r, $g, $b, 0.5)";
                } else {
                    $bgColor = "rgba(0, 123, 255, 0.15)";
                    $borderColor = "rgba(0, 123, 255, 0.5)";
                }
                ?>
                <div class="zone-area" 
                     data-zone-id="<?= $zone['id'] ?>"
                     data-zone-name="<?= htmlspecialchars($zone['name']) ?>"
                     data-type="zone"
                     style="left: <?= $zone['position_x'] ?>px; 
                            top: <?= $zone['position_y'] ?>px; 
                            width: <?= $zone['width'] ?>px; 
                            height: <?= $zone['height'] ?>px;
                            background-color: <?= $bgColor ?>;
                            border-color: <?= $borderColor ?>;"
                     <?php if ($user['role'] === ROLE_ADMIN): ?>
                     draggable="true"
                     <?php endif; ?>>
                    <div class="zone-label" style="color: <?= $zone['color'] ?>;">
                        <?= htmlspecialchars($zone['name']) ?>
                    </div>
                    <?php if ($user['role'] === ROLE_ADMIN): ?>
                    <div class="zone-resize-handle" data-zone-id="<?= $zone['id'] ?>"></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
            
            <?php foreach ($tables as $table): ?>
                <?php
                $posX = $table['position_x'] ?? 50 + (($table['id'] - 1) * 100) % 1100;
                $posY = $table['position_y'] ?? 50 + (floor(($table['id'] - 1) / 11) * 100);
                ?>
                <div class="table-item status-<?= htmlspecialchars($table['status']) ?>" 
                     data-table-id="<?= $table['id'] ?>"
                     data-table-number="<?= $table['number'] ?>"
                     data-type="table"
                     style="left: <?= $posX ?>px; top: <?= $posY ?>px;"
                     <?php if ($user['role'] === ROLE_ADMIN): ?>
                     draggable="true"
                     <?php endif; ?>>
                    <div class="table-number">Mesa <?= $table['number'] ?></div>
                    <div class="table-capacity">
                        <i class="bi bi-people"></i> <?= $table['capacity'] ?>
                    </div>
                    <div class="table-actions">
                        <a href="<?= BASE_URL ?>/orders/create?table_id=<?= $table['id'] ?>" 
                           class="new-order-link"
                           onclick="event.stopPropagation();">
                            <i class="bi bi-plus-circle"></i> Nuevo Pedido
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (!empty($symbols)): ?>
            <?php foreach ($symbols as $symbol): ?>
                <div class="symbol-item type-<?= htmlspecialchars($symbol['type']) ?>" 
                     data-symbol-id="<?= $symbol['id'] ?>"
                     data-symbol-type="<?= htmlspecialchars($symbol['type']) ?>"
                     data-type="symbol"
                     style="left: <?= $symbol['position_x'] ?>px; top: <?= $symbol['position_y'] ?>px;"
                     <?php if ($user['role'] === ROLE_ADMIN): ?>
                     draggable="true"
                     <?php endif; ?>>
                    <div class="symbol-icon">
                        <i class="bi <?= htmlspecialchars($symbol['icon'] ?? 'bi-circle') ?>"></i>
                    </div>
                    <div class="symbol-label">
                        <?= htmlspecialchars($symbol['label']) ?>
                    </div>
                    <?php if ($user['role'] === ROLE_ADMIN): ?>
                    <div class="symbol-actions">
                        <button class="symbol-action-btn duplicate" 
                                data-symbol-id="<?= $symbol['id'] ?>"
                                onclick="event.stopPropagation(); duplicateSymbol(<?= $symbol['id'] ?>);">
                            <i class="bi bi-files"></i> Duplicar
                        </button>
                        <button class="symbol-action-btn delete" 
                                data-symbol-id="<?= $symbol['id'] ?>"
                                onclick="event.stopPropagation(); deleteSymbol(<?= $symbol['id'] ?>);">
                            <i class="bi bi-trash"></i> Eliminar
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const layoutContainer = document.getElementById('layoutContainer');
    const tableItems = document.querySelectorAll('.table-item');
    const symbolItems = document.querySelectorAll('.symbol-item');
    const zoneItems = document.querySelectorAll('.zone-area');
    const saveLayoutBtn = document.getElementById('saveLayout');
    const resetPositionsBtn = document.getElementById('resetPositions');
    const applyDimensionsBtn = document.getElementById('applyDimensions');
    const layoutWidthInput = document.getElementById('layoutWidth');
    const layoutHeightInput = document.getElementById('layoutHeight');
    
    const isAdmin = <?= $user['role'] === ROLE_ADMIN ? 'true' : 'false' ?>;
    
    let draggedElement = null;
    let offsetX = 0;
    let offsetY = 0;
    let resizingZone = null;
    let resizeStartX = 0;
    let resizeStartY = 0;
    let resizeStartWidth = 0;
    let resizeStartHeight = 0;
    
    if (!isAdmin) {
        // For non-admin users, make tables clickable to create orders
        tableItems.forEach(item => {
            item.style.cursor = 'pointer';
            item.addEventListener('click', function() {
                const tableId = this.dataset.tableId;
                const tableNumber = this.dataset.tableNumber;
                if (confirm(`¿Desea crear un pedido para la Mesa ${tableNumber}?`)) {
                    window.location.href = '<?= BASE_URL ?>/orders/create?table_id=' + tableId;
                }
            });
        });
        return; // Skip drag-and-drop setup for non-admin users
    }
    
    // Drag and drop functionality (admin only)
    // Setup drag for tables, symbols, and zones
    const draggableItems = [...tableItems, ...symbolItems, ...zoneItems];
    draggableItems.forEach(item => {
        item.addEventListener('dragstart', function(e) {
            draggedElement = this;
            this.classList.add('dragging');
            
            // Calculate offset from mouse to element's top-left corner
            const rect = this.getBoundingClientRect();
            const containerRect = layoutContainer.getBoundingClientRect();
            offsetX = e.clientX - rect.left;
            offsetY = e.clientY - rect.top;
            
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });
        
        item.addEventListener('dragend', function(e) {
            this.classList.remove('dragging');
            draggedElement = null;
        });
    });
    
    layoutContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });
    
    layoutContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        
        if (draggedElement) {
            const containerRect = layoutContainer.getBoundingClientRect();
            
            // Calculate new position relative to container
            let newX = e.clientX - containerRect.left - offsetX + layoutContainer.scrollLeft;
            let newY = e.clientY - containerRect.top - offsetY + layoutContainer.scrollTop;
            
            // Keep within bounds
            const itemWidth = draggedElement.offsetWidth;
            const itemHeight = draggedElement.offsetHeight;
            
            newX = Math.max(0, Math.min(newX, layoutContainer.offsetWidth - itemWidth));
            newY = Math.max(0, Math.min(newY, layoutContainer.offsetHeight - itemHeight));
            
            // Snap to grid (optional - every 10 pixels)
            newX = Math.round(newX / 10) * 10;
            newY = Math.round(newY / 10) * 10;
            
            draggedElement.style.left = newX + 'px';
            draggedElement.style.top = newY + 'px';
        }
    });
    
    // Zone resize functionality (admin only)
    if (isAdmin) {
        const resizeHandles = document.querySelectorAll('.zone-resize-handle');
        
        resizeHandles.forEach(handle => {
            handle.addEventListener('mousedown', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const zoneId = this.dataset.zoneId;
                resizingZone = document.querySelector(`.zone-area[data-zone-id="${zoneId}"]`);
                
                if (resizingZone) {
                    resizeStartX = e.clientX;
                    resizeStartY = e.clientY;
                    resizeStartWidth = resizingZone.offsetWidth;
                    resizeStartHeight = resizingZone.offsetHeight;
                    
                    // Prevent dragging while resizing
                    resizingZone.draggable = false;
                }
            });
        });
        
        document.addEventListener('mousemove', function(e) {
            if (resizingZone) {
                const deltaX = e.clientX - resizeStartX;
                const deltaY = e.clientY - resizeStartY;
                
                let newWidth = resizeStartWidth + deltaX;
                let newHeight = resizeStartHeight + deltaY;
                
                // Minimum size constraints
                newWidth = Math.max(150, newWidth);
                newHeight = Math.max(100, newHeight);
                
                // Maximum size constraints (don't exceed container)
                const zoneLeft = parseInt(resizingZone.style.left);
                const zoneTop = parseInt(resizingZone.style.top);
                newWidth = Math.min(newWidth, layoutContainer.offsetWidth - zoneLeft);
                newHeight = Math.min(newHeight, layoutContainer.offsetHeight - zoneTop);
                
                resizingZone.style.width = newWidth + 'px';
                resizingZone.style.height = newHeight + 'px';
            }
        });
        
        document.addEventListener('mouseup', function(e) {
            if (resizingZone) {
                // Re-enable dragging
                resizingZone.draggable = true;
                resizingZone = null;
            }
        });
    }
    
    // Save layout
    if (saveLayoutBtn) {
        saveLayoutBtn.addEventListener('click', function() {
            const positions = [];
            const symbols = [];
            const zones = [];
            
            tableItems.forEach(item => {
                positions.push({
                    id: parseInt(item.dataset.tableId),
                    x: parseInt(item.style.left),
                    y: parseInt(item.style.top)
                });
            });
            
            symbolItems.forEach(item => {
                symbols.push({
                    id: parseInt(item.dataset.symbolId),
                    x: parseInt(item.style.left),
                    y: parseInt(item.style.top)
                });
            });
            
            zoneItems.forEach(item => {
                zones.push({
                    id: parseInt(item.dataset.zoneId),
                    x: parseInt(item.style.left),
                    y: parseInt(item.style.top),
                    width: parseInt(item.style.width),
                    height: parseInt(item.style.height)
                });
            });
            
            const layoutData = {
                positions: positions,
                symbols: symbols,
                zones: zones,
                width: layoutContainer.offsetWidth,
                height: layoutContainer.offsetHeight
            };
            
            fetch('<?= BASE_URL ?>/tables/saveLayout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(layoutData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Layout guardado exitosamente');
                } else {
                    alert('Error al guardar layout: ' + (data.error || 'Error desconocido'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar layout');
            });
        });
    }
    
    // Reset positions
    if (resetPositionsBtn) {
        resetPositionsBtn.addEventListener('click', function() {
            if (confirm('¿Está seguro de que desea resetear todas las posiciones de las mesas?')) {
                // Arrange in a grid
                let x = 50;
                let y = 50;
                let col = 0;
                const maxCols = 11;
                const spacing = 100;
                
                tableItems.forEach(item => {
                    item.style.left = x + 'px';
                    item.style.top = y + 'px';
                    
                    col++;
                    x += spacing;
                    
                    if (col >= maxCols) {
                        col = 0;
                        x = 50;
                        y += spacing;
                    }
                });
            }
        });
    }
    
    // Apply dimensions
    if (applyDimensionsBtn) {
        applyDimensionsBtn.addEventListener('click', function() {
            const newWidth = parseInt(layoutWidthInput.value);
            const newHeight = parseInt(layoutHeightInput.value);
            
            if (newWidth >= 800 && newWidth <= 3000 && newHeight >= 600 && newHeight <= 2000) {
                layoutContainer.style.width = newWidth + 'px';
                layoutContainer.style.height = newHeight + 'px';
            } else {
                alert('Las dimensiones deben estar entre 800-3000px (ancho) y 600-2000px (alto)');
            }
        });
    }
});

// Functions for duplicating and deleting symbols (available globally for onclick handlers)
function duplicateSymbol(symbolId) {
    if (!confirm('¿Desea duplicar este símbolo?')) {
        return;
    }
    
    fetch('<?= BASE_URL ?>/tables/duplicateSymbol', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: symbolId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.symbol) {
            alert('Símbolo duplicado exitosamente. Recargando...');
            window.location.reload();
        } else {
            alert('Error al duplicar símbolo: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al duplicar símbolo');
    });
}

function deleteSymbol(symbolId) {
    if (!confirm('¿Está seguro de que desea eliminar este símbolo? Esta acción no se puede deshacer.')) {
        return;
    }
    
    fetch('<?= BASE_URL ?>/tables/deleteSymbol', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: symbolId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Símbolo eliminado exitosamente. Recargando...');
            window.location.reload();
        } else {
            alert('Error al eliminar símbolo: ' + (data.error || 'Error desconocido'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar símbolo');
    });
}
</script>
