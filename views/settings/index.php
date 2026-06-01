<?php $title = 'Configuraciones Globales'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1><i class="bi bi-sliders"></i> Configuraciones Globales</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="list-group" id="settingsTabs" role="tablist">
            <a class="list-group-item list-group-item-action active" data-bs-toggle="list" href="#general">
                <i class="bi bi-building"></i> Sitio y Logotipo
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#email">
                <i class="bi bi-envelope"></i> Configurar Correo
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#test_email">
                <i class="bi bi-send-check"></i> Test de Correo
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#contacto">
                <i class="bi bi-telephone"></i> Contacto y Horarios
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#apariencia">
                <i class="bi bi-palette"></i> Estilos de Color
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#paypal">
                <i class="bi bi-paypal"></i> Configurar PayPal
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#qr">
                <i class="bi bi-qr-code"></i> API QR Masivos
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#iot">
                <i class="bi bi-cpu"></i> Dispositivos IoT
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#gps">
                <i class="bi bi-geo-alt"></i> GPS Tracker
            </a>
            <a class="list-group-item list-group-item-action" href="<?= BASE_URL ?>/settings/logs">
                <i class="bi bi-journal-text"></i> Bitácora de Acciones
            </a>
            <a class="list-group-item list-group-item-action" href="<?= BASE_URL ?>/settings/errors">
                <i class="bi bi-bug"></i> Registro de Errores
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#chatbot">
                <i class="bi bi-chat-dots"></i> Chatbot WhatsApp
            </a>
            <a class="list-group-item list-group-item-action" data-bs-toggle="list" href="#btn_pedidos">
                <i class="bi bi-toggles"></i> Mostrar Botón Pedidos
            </a>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="tab-content">
            <!-- General -->
            <div class="tab-pane fade show active" id="general">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-building"></i> Nombre del Sitio y Logotipo</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="general">
                            <div class="mb-3">
                                <label class="form-label">Nombre del Sitio</label>
                                <input type="text" class="form-control" name="fields[site_name]" value="<?= htmlspecialchars($settings['general']['site_name'] ?? APP_NAME) ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Eslogan</label>
                                <input type="text" class="form-control" name="fields[site_slogan]" value="<?= htmlspecialchars($settings['general']['site_slogan'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL del Logotipo</label>
                                <input type="text" class="form-control" name="fields[site_logo]" value="<?= htmlspecialchars($settings['general']['site_logo'] ?? '') ?>" placeholder="URL o ruta de la imagen">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dirección del Restaurante</label>
                                <input type="text" class="form-control" name="fields[site_address]" value="<?= htmlspecialchars($settings['general']['site_address'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Email -->
            <div class="tab-pane fade" id="email">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-envelope"></i> Configurar Correo Principal</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="email">
                            <div class="mb-3">
                                <label class="form-label">Servidor SMTP</label>
                                <input type="text" class="form-control" name="fields[smtp_host]" value="<?= htmlspecialchars($settings['email']['smtp_host'] ?? '') ?>" placeholder="smtp.example.com">
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Puerto SMTP</label>
                                    <input type="number" class="form-control" name="fields[smtp_port]" value="<?= htmlspecialchars($settings['email']['smtp_port'] ?? '587') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Seguridad</label>
                                    <select class="form-select" name="fields[smtp_security]">
                                        <option value="tls" <?= ($settings['email']['smtp_security'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                                        <option value="ssl" <?= ($settings['email']['smtp_security'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                                        <option value="none" <?= ($settings['email']['smtp_security'] ?? '') === 'none' ? 'selected' : '' ?>>Ninguna</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Usuario SMTP</label>
                                <input type="text" class="form-control" name="fields[smtp_user]" value="<?= htmlspecialchars($settings['email']['smtp_user'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Contraseña SMTP</label>
                                <input type="password" class="form-control" name="fields[smtp_pass]" value="<?= htmlspecialchars($settings['email']['smtp_pass'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo Remitente</label>
                                <input type="email" class="form-control" name="fields[from_email]" value="<?= htmlspecialchars($settings['email']['from_email'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nombre del Remitente</label>
                                <input type="text" class="form-control" name="fields[from_name]" value="<?= htmlspecialchars($settings['email']['from_name'] ?? APP_NAME) ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Test de Correo -->
            <div class="tab-pane fade" id="test_email">
                <?php $reservationCancellationText = $settings['email']['reservation_cancellation_text'] ?? GlobalSetting::getDefaultReservationCancellationText(); ?>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-send-check text-success"></i> Prueba de Envío de Correo</h5>
                        <small class="text-muted">Valida la configuración SMTP del sistema enviando un correo de prueba</small>
                    </div>
                </div>
                <div class="row g-3">
                    <!-- Enviar correo de prueba -->
                    <div class="col-md-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-envelope-check text-success"></i> Enviar Correo de Prueba</h6>
                                <p class="text-muted small">
                                    La configuración SMTP se lee directamente desde la base de datos (<code>global_config</code>).
                                    Asegúrate de que los campos <strong>smtp_host</strong>, <strong>smtp_user</strong>,
                                    <strong>smtp_password</strong> y <strong>smtp_port</strong> estén configurados en
                                    <a href="#email" data-bs-toggle="list">Configuración del Sistema</a>.
                                </p>
                                <div id="testEmailAlert"></div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Email de Destino <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="testEmailTo" placeholder="ejemplo@correo.com">
                                </div>
                                <button type="button" class="btn btn-primary w-100" id="btnSendTestEmail">
                                    <i class="bi bi-send"></i> Enviar Correo de Prueba
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Configuración SMTP activa -->
                    <div class="col-md-5">
                        <div class="card h-100">
                            <div class="card-body">
                                <h6 class="card-title"><i class="bi bi-list-check text-primary"></i> Configuración SMTP Activa</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <?php if (!empty($settings['email']['smtp_host'])): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            <?php else: ?>
                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                            <?php endif; ?>
                                            Servidor (Host):
                                        </span>
                                        <code><?= htmlspecialchars($settings['email']['smtp_host'] ?? '—') ?></code>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <?php if (!empty($settings['email']['smtp_user'])): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            <?php else: ?>
                                                <i class="bi bi-x-circle-fill text-danger"></i>
                                            <?php endif; ?>
                                            Usuario SMTP:
                                        </span>
                                        <code><?= htmlspecialchars($settings['email']['smtp_user'] ?? '—') ?></code>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <?php if (!empty($settings['email']['smtp_port'])): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            <?php else: ?>
                                                <i class="bi bi-info-circle-fill text-info"></i>
                                            <?php endif; ?>
                                            Puerto SMTP:
                                        </span>
                                        <span>
                                            <code><?= htmlspecialchars($settings['email']['smtp_port'] ?? '587') ?></code>
                                            <?php
                                                $port = (int)($settings['email']['smtp_port'] ?? 587);
                                                $sec  = strtolower($settings['email']['smtp_security'] ?? 'tls');
                                                if ($port === 465 || $sec === 'ssl') echo '<span class="badge bg-secondary ms-1">SSL/SMTPS</span>';
                                                elseif ($port === 587 || $sec === 'tls') echo '<span class="badge bg-info ms-1">STARTTLS</span>';
                                            ?>
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <i class="bi bi-shield-lock-fill text-secondary"></i>
                                            Contraseña:
                                        </span>
                                        <code><?= !empty($settings['email']['smtp_pass']) ? str_repeat('•', 8) : '—' ?></code>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <?php if (!empty($settings['email']['from_email'])): ?>
                                                <i class="bi bi-check-circle-fill text-success"></i>
                                            <?php else: ?>
                                                <i class="bi bi-info-circle-fill text-info"></i>
                                            <?php endif; ?>
                                            Correo Remitente:
                                        </span>
                                        <code><?= htmlspecialchars($settings['email']['from_email'] ?? '—') ?></code>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <span>
                                            <i class="bi bi-info-circle-fill text-info"></i>
                                            Seguridad:
                                        </span>
                                        <code><?= htmlspecialchars(strtoupper($settings['email']['smtp_security'] ?? 'TLS')) ?></code>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title"><i class="bi bi-pencil-square text-primary"></i> Texto Cancelación</h6>
                            <p class="text-muted small mb-3">
                                Este texto se mostrará debajo de la información de contacto en los correos de confirmación de reservaciones.
                            </p>
                            <form method="POST" action="<?= BASE_URL ?>/settings/save">
                                <input type="hidden" name="group" value="email">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold" for="reservation_cancellation_text">Texto Cancelación</label>
                                    <textarea class="form-control" id="reservation_cancellation_text" name="fields[reservation_cancellation_text]" rows="3"><?= htmlspecialchars($reservationCancellationText) ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto -->
            <div class="tab-pane fade" id="contacto">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-telephone"></i> Teléfonos y Horarios de Atención</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="contacto">
                            <div class="mb-3">
                                <label class="form-label">Teléfono Principal</label>
                                <input type="text" class="form-control" name="fields[phone_main]" value="<?= htmlspecialchars($settings['contacto']['phone_main'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Teléfono Secundario</label>
                                <input type="text" class="form-control" name="fields[phone_secondary]" value="<?= htmlspecialchars($settings['contacto']['phone_secondary'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" class="form-control" name="fields[whatsapp]" value="<?= htmlspecialchars($settings['contacto']['whatsapp'] ?? '') ?>" placeholder="+52 ...">
                            </div>
                            <hr>
                            <h6>Horario de Atención</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Apertura</label>
                                    <input type="time" class="form-control" name="fields[opening_time]" value="<?= htmlspecialchars($settings['contacto']['opening_time'] ?? '08:00') ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Cierre</label>
                                    <input type="time" class="form-control" name="fields[closing_time]" value="<?= htmlspecialchars($settings['contacto']['closing_time'] ?? '22:00') ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Días de Operación</label>
                                <input type="text" class="form-control" name="fields[operation_days]" value="<?= htmlspecialchars($settings['contacto']['operation_days'] ?? 'Lunes a Domingo') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Apariencia -->
            <div class="tab-pane fade" id="apariencia">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-palette"></i> Estilos Principales de Color</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="apariencia">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Color Principal (Sidebar)</label>
                                    <input type="color" class="form-control form-control-color w-100" name="fields[color_primary]" value="<?= htmlspecialchars($settings['apariencia']['color_primary'] ?? '#1565C0') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Color Acento</label>
                                    <input type="color" class="form-control form-control-color w-100" name="fields[color_accent]" value="<?= htmlspecialchars($settings['apariencia']['color_accent'] ?? '#0dcaf0') ?>">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Color de Fondo</label>
                                    <input type="color" class="form-control form-control-color w-100" name="fields[color_bg]" value="<?= htmlspecialchars($settings['apariencia']['color_bg'] ?? '#f8f9fa') ?>">
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> Los cambios de color se aplican en el próximo inicio de sesión.
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- PayPal -->
            <div class="tab-pane fade" id="paypal">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-paypal"></i> Configurar Cuenta PayPal</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="paypal">
                            <div class="mb-3">
                                <label class="form-label">Modo</label>
                                <select class="form-select" name="fields[paypal_mode]">
                                    <option value="sandbox" <?= ($settings['paypal']['paypal_mode'] ?? '') === 'sandbox' ? 'selected' : '' ?>>Sandbox (Pruebas)</option>
                                    <option value="live" <?= ($settings['paypal']['paypal_mode'] ?? '') === 'live' ? 'selected' : '' ?>>Live (Producción)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Client ID</label>
                                <input type="text" class="form-control" name="fields[paypal_client_id]" value="<?= htmlspecialchars($settings['paypal']['paypal_client_id'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Client Secret</label>
                                <input type="password" class="form-control" name="fields[paypal_client_secret]" value="<?= htmlspecialchars($settings['paypal']['paypal_client_secret'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Correo PayPal</label>
                                <input type="email" class="form-control" name="fields[paypal_email]" value="<?= htmlspecialchars($settings['paypal']['paypal_email'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- QR API -->
            <div class="tab-pane fade" id="qr">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-qr-code"></i> API para QR Masivos</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="qr">
                            <div class="mb-3">
                                <label class="form-label">API Key QR</label>
                                <input type="text" class="form-control" name="fields[qr_api_key]" value="<?= htmlspecialchars($settings['qr']['qr_api_key'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL del Servicio QR</label>
                                <input type="text" class="form-control" name="fields[qr_api_url]" value="<?= htmlspecialchars($settings['qr']['qr_api_url'] ?? '') ?>" placeholder="https://api.qrservice.com">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tamaño por defecto (px)</label>
                                <input type="number" class="form-control" name="fields[qr_default_size]" value="<?= htmlspecialchars($settings['qr']['qr_default_size'] ?? '300') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- IoT -->
            <div class="tab-pane fade" id="iot">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-cpu"></i> Dispositivos IoT</h5></div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#shelly">Shelly Cloud</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#hikvision">HikVision</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="shelly">
                                <form method="POST" action="<?= BASE_URL ?>/settings/save">
                                    <input type="hidden" name="group" value="iot_shelly">
                                    <div class="mb-3">
                                        <label class="form-label">Shelly Cloud Auth Key</label>
                                        <input type="text" class="form-control" name="fields[shelly_auth_key]" value="<?= htmlspecialchars($settings['iot_shelly']['shelly_auth_key'] ?? '') ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Shelly Cloud Server</label>
                                        <input type="text" class="form-control" name="fields[shelly_server]" value="<?= htmlspecialchars($settings['iot_shelly']['shelly_server'] ?? '') ?>" placeholder="shelly-65-eu.shelly.cloud">
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar Shelly</button>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="hikvision">
                                <form method="POST" action="<?= BASE_URL ?>/settings/save">
                                    <input type="hidden" name="group" value="iot_hik">
                                    <div class="mb-3">
                                        <label class="form-label">IP del NVR/DVR</label>
                                        <input type="text" class="form-control" name="fields[hik_ip]" value="<?= htmlspecialchars($settings['iot_hik']['hik_ip'] ?? '') ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Puerto</label>
                                            <input type="number" class="form-control" name="fields[hik_port]" value="<?= htmlspecialchars($settings['iot_hik']['hik_port'] ?? '8000') ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Usuario</label>
                                            <input type="text" class="form-control" name="fields[hik_user]" value="<?= htmlspecialchars($settings['iot_hik']['hik_user'] ?? 'admin') ?>">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" class="form-control" name="fields[hik_pass]" value="<?= htmlspecialchars($settings['iot_hik']['hik_pass'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar HikVision</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- GPS -->
            <div class="tab-pane fade" id="gps">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-geo-alt"></i> API GPS Tracker</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="gps">
                            <div class="mb-3">
                                <label class="form-label">API Key GPS</label>
                                <input type="text" class="form-control" name="fields[gps_api_key]" value="<?= htmlspecialchars($settings['gps']['gps_api_key'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">URL del Servidor GPS</label>
                                <input type="text" class="form-control" name="fields[gps_server_url]" value="<?= htmlspecialchars($settings['gps']['gps_server_url'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Proveedor GPS</label>
                                <input type="text" class="form-control" name="fields[gps_provider]" value="<?= htmlspecialchars($settings['gps']['gps_provider'] ?? '') ?>" placeholder="Traccar, Wialon, etc.">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Chatbot -->
            <div class="tab-pane fade" id="chatbot">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-chat-dots"></i> Configuración del Chatbot WhatsApp</h5></div>
                    <div class="card-body">
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="chatbot">
                            <div class="mb-3">
                                <label class="form-label">Proveedor del Chatbot</label>
                                <select class="form-select" name="fields[chatbot_provider]">
                                    <option value="">Seleccionar...</option>
                                    <option value="twilio" <?= ($settings['chatbot']['chatbot_provider'] ?? '') === 'twilio' ? 'selected' : '' ?>>Twilio</option>
                                    <option value="meta" <?= ($settings['chatbot']['chatbot_provider'] ?? '') === 'meta' ? 'selected' : '' ?>>Meta Business API</option>
                                    <option value="wapi" <?= ($settings['chatbot']['chatbot_provider'] ?? '') === 'wapi' ? 'selected' : '' ?>>WAPI</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Token de Acceso</label>
                                <input type="text" class="form-control" name="fields[chatbot_token]" value="<?= htmlspecialchars($settings['chatbot']['chatbot_token'] ?? '') ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Número de WhatsApp Business</label>
                                <input type="text" class="form-control" name="fields[chatbot_phone]" value="<?= htmlspecialchars($settings['chatbot']['chatbot_phone'] ?? '') ?>" placeholder="+52...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Webhook URL</label>
                                <input type="text" class="form-control" name="fields[chatbot_webhook]" value="<?= htmlspecialchars($settings['chatbot']['chatbot_webhook'] ?? '') ?>">
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mostrar Botón Pedidos -->
            <div class="tab-pane fade" id="btn_pedidos">
                <div class="card">
                    <div class="card-header"><h5 class="mb-0"><i class="bi bi-toggles"></i> Mostrar Botón Pedidos</h5></div>
                    <div class="card-body">
                        <p class="text-muted mb-4">Configure en qué módulos se muestra el botón flotante <strong>"Nuevo Pedido"</strong> para cada rol de usuario.</p>
                        <form method="POST" action="<?= BASE_URL ?>/settings/save">
                            <input type="hidden" name="group" value="btn_pedidos">

                            <?php
                            $roleOptions = [
                                ROLE_ADMIN      => '<i class="bi bi-shield-fill"></i> Administrador',
                                ROLE_WAITER     => '<i class="bi bi-person-badge"></i> Mesero',
                                ROLE_CASHIER    => '<i class="bi bi-cash-register"></i> Cajero',
                                ROLE_SUPERADMIN => '<i class="bi bi-star-fill"></i> Superadmin',
                            ];
                            $moduleOptions = [
                                'dashboard'    => '<i class="bi bi-speedometer2"></i> Dashboard',
                                'orders'       => '<i class="bi bi-clipboard-check"></i> Pedidos',
                                'tables'       => '<i class="bi bi-diagram-3"></i> Mesas / Layout',
                                'reservations' => '<i class="bi bi-calendar-check"></i> Reservaciones',
                                'financial'    => '<i class="bi bi-calculator"></i> Financiero',
                                'inventory'    => '<i class="bi bi-boxes"></i> Inventario',
                                'customers'    => '<i class="bi bi-people"></i> Clientes',
                                'best_diners'  => '<i class="bi bi-trophy"></i> Mejores Comensales',
                                'services'     => '<i class="bi bi-stars"></i> Servicios',
                                'tickets'      => '<i class="bi bi-receipt"></i> Tickets',
                                'users'        => '<i class="bi bi-person-gear"></i> Usuarios',
                                'waiters'      => '<i class="bi bi-person-badge"></i> Meseros',
                                'dishes'       => '<i class="bi bi-cup-hot"></i> Menú / Platillos',
                                'settings'     => '<i class="bi bi-sliders"></i> Configuraciones',
                            ];
                            $allModules = array_keys($moduleOptions);

                            // Load per-role config (new format)
                            $btnConfigJson = $settings['btn_pedidos']['btn_pedidos_config'] ?? null;
                            if ($btnConfigJson !== null) {
                                $btnConfig = json_decode($btnConfigJson, true) ?? [];
                            } else {
                                // Backward-compat: convert old flat roles+modules to per-role config
                                $oldRoles   = json_decode($settings['btn_pedidos']['btn_pedidos_roles']   ?? 'null', true);
                                $oldModules = json_decode($settings['btn_pedidos']['btn_pedidos_modules'] ?? 'null', true);
                                if ($oldRoles === null)   $oldRoles   = array_keys($roleOptions);
                                if ($oldModules === null) $oldModules = $allModules;
                                $btnConfig = [];
                                foreach (array_keys($roleOptions) as $r) {
                                    $btnConfig[$r] = in_array($r, $oldRoles) ? $oldModules : [];
                                }
                            }
                            ?>

                            <?php foreach ($roleOptions as $roleVal => $roleLabel): ?>
                            <?php $enabledModules = $btnConfig[$roleVal] ?? []; ?>
                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-semibold fs-6"><?= $roleLabel ?></span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary btn-pedidos-toggle-all"
                                            data-role="<?= htmlspecialchars($roleVal) ?>">
                                        <i class="bi bi-check2-all"></i> Todos / Ninguno
                                    </button>
                                </div>
                                <div class="row g-2 p-3 border rounded bg-light">
                                    <?php foreach ($moduleOptions as $modVal => $modLabel): ?>
                                    <div class="col-md-4 col-6">
                                        <div class="form-check">
                                            <input class="form-check-input btn-pedidos-check"
                                                   type="checkbox"
                                                   name="fields[btn_pedidos_config][<?= htmlspecialchars($roleVal) ?>][]"
                                                   value="<?= htmlspecialchars($modVal) ?>"
                                                   id="bpc_<?= htmlspecialchars($roleVal) ?>_<?= htmlspecialchars($modVal) ?>"
                                                   data-role="<?= htmlspecialchars($roleVal) ?>"
                                                   <?= in_array($modVal, $enabledModules) ? 'checked' : '' ?>>
                                            <label class="form-check-label"
                                                   for="bpc_<?= htmlspecialchars($roleVal) ?>_<?= htmlspecialchars($modVal) ?>">
                                                <?= $modLabel ?>
                                            </label>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Guardar</button>
                        </form>
                    </div>
                </div>
            </div>

            <script>
            (function () {
                document.querySelectorAll('.btn-pedidos-toggle-all').forEach(function (btn) {
                    btn.addEventListener('click', function () {
                        var role = this.getAttribute('data-role');
                        var escapedRole = CSS.escape(role);
                        var boxes = document.querySelectorAll('.btn-pedidos-check[data-role="' + escapedRole + '"]');
                        var allChecked = Array.prototype.every.call(boxes, function (cb) { return cb.checked; });
                        Array.prototype.forEach.call(boxes, function (cb) { cb.checked = !allChecked; });
                    });
                });
            }());
            </script>

            <script>
            (function () {
                var btn = document.getElementById('btnSendTestEmail');
                if (!btn) return;
                btn.addEventListener('click', function () {
                    var emailInput = document.getElementById('testEmailTo');
                    var alertBox  = document.getElementById('testEmailAlert');
                    var email = emailInput ? emailInput.value.trim() : '';
                    alertBox.innerHTML = '';

                    if (!email) {
                        alertBox.innerHTML = '<div class="alert alert-warning"><i class="bi bi-exclamation-triangle"></i> Ingresa un email de destino.</div>';
                        return;
                    }

                    btn.disabled = true;
                    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Enviando...';

                    var formData = new FormData();
                    formData.append('to_email', email);

                    fetch('<?= BASE_URL ?>/settings/testEmail', {
                        method: 'POST',
                        body: formData
                    })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (data.success) {
                            alertBox.innerHTML = '<div class="alert alert-success"><i class="bi bi-check-circle"></i> ' + data.message + '</div>';
                        } else {
                            alertBox.innerHTML = '<div class="alert alert-danger"><i class="bi bi-x-circle"></i> ' + data.message + '</div>';
                        }
                    })
                    .catch(function (err) {
                        var msg = document.createElement('span');
                        msg.textContent = String(err);
                        alertBox.innerHTML = '<div class="alert alert-danger"><i class="bi bi-x-circle"></i> Error de conexión: </div>';
                        alertBox.querySelector('.alert').appendChild(msg);
                    })
                    .finally(function () {
                        btn.disabled = false;
                        btn.innerHTML = '<i class="bi bi-send"></i> Enviar Correo de Prueba';
                    });
                });
            }());
            </script>
        </div>
    </div>
</div>
