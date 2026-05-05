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
        </div>
    </div>
</div>
