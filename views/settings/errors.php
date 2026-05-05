<?php $title = 'Registro de Errores'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-bug"></i> Registro de Errores del Sistema</h1>
    <div>
        <form method="POST" action="<?= BASE_URL ?>/settings/clearErrors" class="d-inline">
            <button type="submit" class="btn btn-outline-danger me-2" onclick="return confirm('¿Limpiar todos los registros de errores?')">
                <i class="bi bi-trash"></i> Limpiar
            </button>
        </form>
        <a href="<?= BASE_URL ?>/settings" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Configuraciones
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($errors)): ?>
        <div class="text-center py-4">
            <i class="bi bi-check-circle display-4 text-success"></i>
            <h4 class="mt-3 text-success">¡Sin errores registrados!</h4>
            <p class="text-muted">El sistema funciona correctamente</p>
        </div>
        <?php else: ?>
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle"></i> Se encontraron <strong><?= count($errors) ?></strong> errores registrados.
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Mensaje</th>
                        <th>Archivo</th>
                        <th>Línea</th>
                        <th>URL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($errors as $error): ?>
                    <tr>
                        <td><?= $error['id'] ?></td>
                        <td><small><?= date('d/m/Y H:i:s', strtotime($error['created_at'])) ?></small></td>
                        <td><span class="badge bg-danger"><?= htmlspecialchars($error['error_type'] ?? 'Error') ?></span></td>
                        <td><small><?= htmlspecialchars(substr($error['message'], 0, 100)) ?><?= strlen($error['message']) > 100 ? '...' : '' ?></small></td>
                        <td><small class="text-muted"><?= htmlspecialchars(basename($error['file'] ?? '')) ?></small></td>
                        <td><?= $error['line'] ?></td>
                        <td><small><?= htmlspecialchars(substr($error['url'] ?? '', 0, 50)) ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
