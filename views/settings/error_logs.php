<?php $title = 'Registro de Errores'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-bug"></i> Registro de Errores</h1>
    <a href="<?= BASE_URL ?>/settings" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Configuraciones
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Nivel:</label>
                <select class="form-select" name="level">
                    <option value="">Todos</option>
                    <option value="info"     <?= ($selectedLevel ?? '') === 'info'     ? 'selected' : '' ?>>Info</option>
                    <option value="warning"  <?= ($selectedLevel ?? '') === 'warning'  ? 'selected' : '' ?>>Warning</option>
                    <option value="error"    <?= ($selectedLevel ?? '') === 'error'    ? 'selected' : '' ?>>Error</option>
                    <option value="critical" <?= ($selectedLevel ?? '') === 'critical' ? 'selected' : '' ?>>Critical</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Límite:</label>
                <select class="form-select" name="limit">
                    <option value="50"  <?= ($limit ?? 100) ==  50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($limit ?? 100) == 100 ? 'selected' : '' ?>>100</option>
                    <option value="250" <?= ($limit ?? 100) == 250 ? 'selected' : '' ?>>250</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<?php
$levelClasses = [
    'info'     => 'info',
    'warning'  => 'warning',
    'error'    => 'danger',
    'critical' => 'dark',
];
?>

<?php if (empty($errorLogs)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-check-circle display-1 text-success"></i>
        <h3 class="mt-3">Sin errores registrados</h3>
    </div>
</div>
<?php else: ?>
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-sm table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha/Hora</th>
                        <th>Nivel</th>
                        <th>Mensaje</th>
                        <th>Archivo</th>
                        <th>Línea</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($errorLogs as $log): ?>
                    <?php $cls = $levelClasses[$log['level']] ?? 'secondary'; ?>
                    <tr class="table-<?= $cls ?>">
                        <td><?= $log['id'] ?></td>
                        <td><small><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></small></td>
                        <td><span class="badge bg-<?= $cls ?>"><?= strtoupper($log['level']) ?></span></td>
                        <td><small><?= htmlspecialchars($log['message']) ?></small></td>
                        <td><small class="text-muted"><?= htmlspecialchars($log['file'] ?? '-') ?></small></td>
                        <td><?= htmlspecialchars($log['line'] ?? '-') ?></td>
                        <td><small><?= htmlspecialchars($log['ip_address'] ?? '-') ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
