<?php $title = 'Configuraciones Globales'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-sliders"></i> Configuraciones Globales</h1>
</div>

<form method="POST" action="<?= BASE_URL ?>/settings/save" enctype="multipart/form-data">

<!-- SITE -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="bi bi-globe"></i> Nombre del Sitio y Logotipo</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombre del Sitio</label>
                <input type="text" class="form-control" name="site_name"
                       value="<?= htmlspecialchars($settings['site_name'] ?? 'Sistema GestoRest') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Logotipo actual</label><br>
                <?php if (!empty($settings['site_logo'])): ?>
                <img src="<?= BASE_URL ?>/public/images/<?= htmlspecialchars($settings['site_logo']) ?>"
                     style="max-height:60px;" alt="Logo" class="mb-2 d-block">
                <?php endif; ?>
                <input type="file" class="form-control" name="site_logo_file"
                       accept="image/jpeg,image/png,image/gif,image/svg+xml">
                <small class="text-muted">JPG, PNG, GIF o SVG – máx. 2 MB</small>
            </div>
        </div>
    </div>
</div>

<!-- EMAIL -->
<div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0"><i class="bi bi-envelope"></i> Configuración de Correo</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Correo Remitente</label>
                <input type="email" class="form-control" name="mail_from"
                       value="<?= htmlspecialchars($settings['mail_from'] ?? '') ?>"
                       placeholder="noreply@tudominio.com">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Nombre Remitente</label>
                <input type="text" class="form-control" name="mail_name"
                       value="<?= htmlspecialchars($settings['mail_name'] ?? '') ?>">
            </div>
        </div>
    </div>
</div>

<!-- CONTACT & HOURS -->
<div class="card mb-4">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-telephone"></i> Teléfonos y Horarios de Atención</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Teléfono Principal</label>
                <input type="text" class="form-control" name="contact_phone_1"
                       value="<?= htmlspecialchars($settings['contact_phone_1'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Teléfono Secundario</label>
                <input type="text" class="form-control" name="contact_phone_2"
                       value="<?= htmlspecialchars($settings['contact_phone_2'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Hora de Apertura</label>
                <input type="time" class="form-control" name="business_hours_open"
                       value="<?= htmlspecialchars($settings['business_hours_open'] ?? '08:00') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Hora de Cierre</label>
                <input type="time" class="form-control" name="business_hours_close"
                       value="<?= htmlspecialchars($settings['business_hours_close'] ?? '22:00') ?>">
            </div>
        </div>
    </div>
</div>

<!-- COLORS -->
<div class="card mb-4">
    <div class="card-header" style="background:#6f42c1;color:#fff;">
        <h5 class="mb-0"><i class="bi bi-palette"></i> Estilos Principales de Color</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Color Principal</label>
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" name="primary_color"
                           value="<?= htmlspecialchars($settings['primary_color'] ?? '#0d6efd') ?>">
                    <input type="text" class="form-control" id="primaryColorHex"
                           value="<?= htmlspecialchars($settings['primary_color'] ?? '#0d6efd') ?>"
                           readonly>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Color Secundario</label>
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" name="secondary_color"
                           value="<?= htmlspecialchars($settings['secondary_color'] ?? '#6c757d') ?>">
                    <input type="text" class="form-control" id="secondaryColorHex"
                           value="<?= htmlspecialchars($settings['secondary_color'] ?? '#6c757d') ?>"
                           readonly>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PAYPAL -->
<div class="card mb-4">
    <div class="card-header" style="background:#003087;color:#fff;">
        <h5 class="mb-0"><i class="bi bi-paypal"></i> Cuenta de PayPal</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-5 mb-3">
                <label class="form-label fw-bold">Client ID</label>
                <input type="text" class="form-control" name="paypal_client_id"
                       value="<?= htmlspecialchars($settings['paypal_client_id'] ?? '') ?>">
            </div>
            <div class="col-md-5 mb-3">
                <label class="form-label fw-bold">Secret</label>
                <input type="password" class="form-control" name="paypal_secret"
                       value="<?= htmlspecialchars($settings['paypal_secret'] ?? '') ?>">
            </div>
            <div class="col-md-2 mb-3">
                <label class="form-label fw-bold">Modo</label>
                <select class="form-select" name="paypal_mode">
                    <option value="sandbox" <?= (($settings['paypal_mode'] ?? 'sandbox') === 'sandbox') ? 'selected' : '' ?>>Sandbox</option>
                    <option value="live" <?= (($settings['paypal_mode'] ?? '') === 'live') ? 'selected' : '' ?>>Live</option>
                </select>
            </div>
        </div>
    </div>
</div>

<!-- QR API -->
<div class="card mb-4">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0"><i class="bi bi-qr-code"></i> API para QR Masivos</h5>
    </div>
    <div class="card-body">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">API Key</label>
            <input type="text" class="form-control" name="qr_api_key"
                   value="<?= htmlspecialchars($settings['qr_api_key'] ?? '') ?>">
        </div>
    </div>
</div>

<!-- IOT -->
<div class="card mb-4">
    <div class="card-header bg-warning">
        <h5 class="mb-0"><i class="bi bi-cpu"></i> Dispositivos IoT (Shelly Cloud / HikVision)</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Token Shelly Cloud</label>
                <input type="text" class="form-control" name="shelly_cloud_token"
                       value="<?= htmlspecialchars($settings['shelly_cloud_token'] ?? '') ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">HikVision Host / IP</label>
                <input type="text" class="form-control" name="hikvision_host"
                       value="<?= htmlspecialchars($settings['hikvision_host'] ?? '') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Usuario HikVision</label>
                <input type="text" class="form-control" name="hikvision_user"
                       value="<?= htmlspecialchars($settings['hikvision_user'] ?? '') ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Contraseña HikVision</label>
                <input type="password" class="form-control" name="hikvision_pass"
                       value="<?= htmlspecialchars($settings['hikvision_pass'] ?? '') ?>">
            </div>
        </div>
    </div>
</div>

<!-- CHATBOT -->
<div class="card mb-4">
    <div class="card-header" style="background:#25d366;color:#fff;">
        <h5 class="mb-0"><i class="bi bi-whatsapp"></i> Chatbot de WhatsApp</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Token de Acceso</label>
                <input type="text" class="form-control" name="chatbot_whatsapp_token"
                       value="<?= htmlspecialchars($settings['chatbot_whatsapp_token'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Phone Number ID</label>
                <input type="text" class="form-control" name="chatbot_phone_number_id"
                       value="<?= htmlspecialchars($settings['chatbot_phone_number_id'] ?? '') ?>">
            </div>
        </div>
    </div>
</div>

<!-- GPS -->
<div class="card mb-4">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0"><i class="bi bi-geo-alt"></i> API GPS Tracker</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">API Key GPS</label>
                <input type="text" class="form-control" name="gps_tracker_api_key"
                       value="<?= htmlspecialchars($settings['gps_tracker_api_key'] ?? '') ?>">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">URL Base del Servicio</label>
                <input type="url" class="form-control" name="gps_tracker_url"
                       value="<?= htmlspecialchars($settings['gps_tracker_url'] ?? '') ?>"
                       placeholder="https://api.gpstracker.com">
            </div>
        </div>
    </div>
</div>

<div class="mb-4">
    <button type="submit" class="btn btn-primary btn-lg">
        <i class="bi bi-save"></i> Guardar Todas las Configuraciones
    </button>
</div>

</form>

<script>
// Sync color pickers with hex text inputs
document.querySelectorAll('input[type="color"]').forEach(function(picker) {
    picker.addEventListener('input', function() {
        var hexInput = this.parentElement.querySelector('input[type="text"]');
        if (hexInput) hexInput.value = this.value;
    });
});
</script>
