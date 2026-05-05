<?php $title = 'Bitácora de Acciones'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-journal-text"></i> Bitácora de Acciones</h1>
    <a href="<?= BASE_URL ?>/settings" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Configuraciones
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Fecha Desde</label>
                <input type="date" class="form-control" name="date_from" value="<?= htmlspecialchars($filters['date_from']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Fecha Hasta</label>
                <input type="date" class="form-control" name="date_to" value="<?= htmlspecialchars($filters['date_to']) ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Acción</label>
                <input type="text" class="form-control" name="action" value="<?= htmlspecialchars($filters['action']) ?>" placeholder="Filtrar por acción...">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary me-2"><i class="bi bi-funnel"></i> Filtrar</button>
                <a href="<?= BASE_URL ?>/settings/logs" class="btn btn-outline-secondary"><i class="bi bi-x"></i></a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($logs)): ?>
        <div class="text-center py-4">
            <i class="bi bi-journal display-4 text-muted"></i>
            <p class="mt-2">No hay registros de acciones para los filtros seleccionados</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha/Hora</th>
                        <th>Usuario</th>
                        <th>Acción</th>
                        <th>Entidad</th>
                        <th>Descripción</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><small><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></small></td>
                        <td><?= htmlspecialchars($log['user_name'] ?? 'Sistema') ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($log['action']) ?></span></td>
                        <td><?= htmlspecialchars($log['entity_type'] ?? '') ?> <?= $log['entity_id'] ? '#'.$log['entity_id'] : '' ?></td>
                        <td><small><?= htmlspecialchars($log['description'] ?? '') ?></small></td>
                        <td><small><?= htmlspecialchars($log['ip_address'] ?? '') ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
