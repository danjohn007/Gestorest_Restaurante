<?php $title = 'Bitácora de Acciones'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-journal-text"></i> Bitácora de Acciones</h1>
    <a href="<?= BASE_URL ?>/settings" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Configuraciones
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Fecha:</label>
                <input type="date" class="form-control" name="date"
                       value="<?= htmlspecialchars($selectedDate ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">Módulo:</label>
                <input type="text" class="form-control" name="module"
                       value="<?= htmlspecialchars($selectedModule ?? '') ?>"
                       placeholder="tickets, orders, services...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Límite:</label>
                <select class="form-select" name="limit">
                    <option value="50"  <?= ($limit ?? 100) ==  50 ? 'selected' : '' ?>>50</option>
                    <option value="100" <?= ($limit ?? 100) == 100 ? 'selected' : '' ?>>100</option>
                    <option value="250" <?= ($limit ?? 100) == 250 ? 'selected' : '' ?>>250</option>
                    <option value="500" <?= ($limit ?? 100) == 500 ? 'selected' : '' ?>>500</option>
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

<?php if (empty($logs)): ?>
<div class="card">
    <div class="card-body text-center py-5">
        <i class="bi bi-journal-x display-1 text-muted"></i>
        <h3 class="mt-3">Sin registros en esta selección</h3>
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
                        <th>Usuario</th>
                        <th>Módulo</th>
                        <th>Acción</th>
                        <th>Descripción</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><small><?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?></small></td>
                        <td><?= htmlspecialchars($log['user_display'] ?? $log['user_name'] ?? '-') ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($log['module'] ?? '-') ?></span></td>
                        <td><code><?= htmlspecialchars($log['action']) ?></code></td>
                        <td><small><?= htmlspecialchars($log['description'] ?? '-') ?></small></td>
                        <td><small class="text-muted"><?= htmlspecialchars($log['ip_address'] ?? '-') ?></small></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
