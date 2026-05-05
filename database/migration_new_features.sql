-- ============================================================
-- MIGRATION: New features for Gestorest Restaurant System
-- Compatible with MySQL 5.7
-- Run this script to add support for:
--   1. Services module (amenities sales)
--   2. Cash change calculation fields on tickets
--   3. Global settings extended fields
--   4. Action log (bitácora)
--   5. Error log table
-- ============================================================

-- Use the production database
-- (adjust database name as needed, currently: exhacien_restaurante)

-- ------------------------------------------------------------
-- 1. SERVICES MODULE
--    Services are amenities sold separately from regular dishes.
--    Their sales credit the financial balance as revenues.
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `services` (
    `id`          INT PRIMARY KEY AUTO_INCREMENT,
    `name`        VARCHAR(255) NOT NULL,
    `description` TEXT,
    `price`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    `category`    VARCHAR(100) DEFAULT NULL,
    `image`       VARCHAR(255) DEFAULT NULL,
    `active`      TINYINT(1) NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX IF NOT EXISTS `idx_services_active` ON `services` (`active`);
CREATE INDEX IF NOT EXISTS `idx_services_category` ON `services` (`category`);

-- Service sales register (each sale of a service)
CREATE TABLE IF NOT EXISTS `service_sales` (
    `id`             INT PRIMARY KEY AUTO_INCREMENT,
    `service_id`     INT NOT NULL,
    `cashier_id`     INT NOT NULL,
    `quantity`       INT NOT NULL DEFAULT 1,
    `unit_price`     DECIMAL(10,2) NOT NULL,
    `subtotal`       DECIMAL(10,2) NOT NULL,
    `payment_method` ENUM('efectivo','tarjeta','transferencia','intercambio','pendiente_por_cobrar') NOT NULL DEFAULT 'efectivo',
    `cash_received`  DECIMAL(10,2) DEFAULT NULL COMMENT 'Amount of cash received from customer',
    `change_amount`  DECIMAL(10,2) DEFAULT NULL COMMENT 'Change to be returned to customer',
    `notes`          TEXT,
    `created_at`     TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`cashier_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX IF NOT EXISTS `idx_service_sales_date` ON `service_sales` (`created_at`);
CREATE INDEX IF NOT EXISTS `idx_service_sales_cashier` ON `service_sales` (`cashier_id`);

-- ------------------------------------------------------------
-- 2. CASH CHANGE CALCULATION FIELDS ON TICKETS
--    When payment method is 'efectivo', store the cash received
--    and the change to be returned.
-- ------------------------------------------------------------

-- Add cash_received and change_amount columns to tickets (if not present)
ALTER TABLE `tickets`
    ADD COLUMN IF NOT EXISTS `cash_received` DECIMAL(10,2) DEFAULT NULL COMMENT 'Cash amount received from customer',
    ADD COLUMN IF NOT EXISTS `change_amount`  DECIMAL(10,2) DEFAULT NULL COMMENT 'Change returned to customer';

-- ------------------------------------------------------------
-- 3. GLOBAL SETTINGS EXTENDED
--    The system_settings table already exists, but we seed
--    the new configuration keys required by the new modules.
-- ------------------------------------------------------------

-- Create system_settings table if it does not exist yet
CREATE TABLE IF NOT EXISTS `system_settings` (
    `id`            INT PRIMARY KEY AUTO_INCREMENT,
    `setting_key`   VARCHAR(100) UNIQUE NOT NULL,
    `setting_value` TEXT,
    `description`   VARCHAR(255),
    `created_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`    TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed default global settings (INSERT IGNORE avoids duplicates)
INSERT IGNORE INTO `system_settings` (`setting_key`, `setting_value`, `description`) VALUES
    ('site_name',            'Sistema GestoRest',     'Nombre del sitio'),
    ('site_logo',            '',                       'Ruta del logotipo del sitio'),
    ('mail_from',            '',                       'Correo remitente principal del sistema'),
    ('mail_name',            'Sistema GestoRest',     'Nombre remitente del correo'),
    ('contact_phone_1',      '',                       'Teléfono de contacto principal'),
    ('contact_phone_2',      '',                       'Teléfono de contacto secundario'),
    ('business_hours_open',  '08:00',                  'Hora de apertura del establecimiento'),
    ('business_hours_close', '22:00',                  'Hora de cierre del establecimiento'),
    ('primary_color',        '#0d6efd',                'Color principal del sistema (CSS hex)'),
    ('secondary_color',      '#6c757d',                'Color secundario del sistema (CSS hex)'),
    ('paypal_client_id',     '',                       'Client ID de la cuenta PayPal'),
    ('paypal_secret',        '',                       'Secret de la cuenta PayPal'),
    ('paypal_mode',          'sandbox',                'Modo PayPal: sandbox o live'),
    ('qr_api_key',           '',                       'API Key para generación masiva de QR'),
    ('shelly_cloud_token',   '',                       'Token de Shelly Cloud IoT'),
    ('hikvision_host',       '',                       'Host/IP del servidor HikVision'),
    ('hikvision_user',       '',                       'Usuario HikVision'),
    ('hikvision_pass',       '',                       'Contraseña HikVision'),
    ('chatbot_whatsapp_token','',                      'Token de acceso al chatbot de WhatsApp'),
    ('chatbot_phone_number_id','',                     'Phone Number ID del chatbot WhatsApp'),
    ('gps_tracker_api_key',  '',                       'API Key del servicio GPS Tracker'),
    ('gps_tracker_url',      '',                       'URL base del servicio GPS Tracker'),
    ('collections_enabled',  '1',                      'Módulo de cobranza habilitado'),
    ('inventory_enabled',    '1',                      'Módulo de inventario habilitado'),
    ('auto_deduct_inventory','1',                      'Descontar inventario automáticamente al generar ticket');

-- ------------------------------------------------------------
-- 4. ACTION LOG (BITÁCORA DE ACCIONES)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `action_logs` (
    `id`          INT PRIMARY KEY AUTO_INCREMENT,
    `user_id`     INT DEFAULT NULL,
    `user_name`   VARCHAR(255) DEFAULT NULL,
    `action`      VARCHAR(100) NOT NULL COMMENT 'e.g. create_ticket, delete_order',
    `module`      VARCHAR(100) DEFAULT NULL COMMENT 'e.g. tickets, orders, services',
    `description` TEXT,
    `ip_address`  VARCHAR(45) DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX IF NOT EXISTS `idx_action_logs_user`   ON `action_logs` (`user_id`);
CREATE INDEX IF NOT EXISTS `idx_action_logs_action` ON `action_logs` (`action`);
CREATE INDEX IF NOT EXISTS `idx_action_logs_date`   ON `action_logs` (`created_at`);

-- ------------------------------------------------------------
-- 5. ERROR LOG (REGISTRO DE ERRORES)
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `error_logs` (
    `id`          INT PRIMARY KEY AUTO_INCREMENT,
    `level`       ENUM('info','warning','error','critical') NOT NULL DEFAULT 'error',
    `message`     TEXT NOT NULL,
    `context`     TEXT COMMENT 'JSON encoded additional context',
    `file`        VARCHAR(500) DEFAULT NULL,
    `line`        INT DEFAULT NULL,
    `ip_address`  VARCHAR(45) DEFAULT NULL,
    `user_id`     INT DEFAULT NULL,
    `created_at`  TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE INDEX IF NOT EXISTS `idx_error_logs_level` ON `error_logs` (`level`);
CREATE INDEX IF NOT EXISTS `idx_error_logs_date`  ON `error_logs` (`created_at`);

-- ============================================================
-- END OF MIGRATION
-- ============================================================
