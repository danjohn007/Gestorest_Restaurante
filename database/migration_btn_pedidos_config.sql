-- Migration: Upgrade "Mostrar Botón Pedidos" to per-role / per-module configuration
-- Replaces the previous flat btn_pedidos_roles + btn_pedidos_modules settings with a
-- single btn_pedidos_config JSON object keyed by role, where each value is an array
-- of module slugs for which the button is visible.
--
-- Default values mirror the previous behaviour: ALL roles see the button in ALL modules.
-- Compatible with MySQL 5.7.
--
-- Role values match the PHP constants in config/config.php:
--   ROLE_ADMIN      = 'administrador'
--   ROLE_WAITER     = 'mesero'
--   ROLE_CASHIER    = 'cajero'
--   ROLE_SUPERADMIN = 'superadmin'

INSERT INTO `global_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
VALUES (
  'btn_pedidos_config',
  '{"administrador":["dashboard","orders","tables","reservations","financial","inventory","customers","best_diners","services","tickets","users","waiters","dishes","settings"],"mesero":["dashboard","orders","tables","reservations","financial","inventory","customers","best_diners","services","tickets","users","waiters","dishes","settings"],"cajero":["dashboard","orders","tables","reservations","financial","inventory","customers","best_diners","services","tickets","users","waiters","dishes","settings"],"superadmin":["dashboard","orders","tables","reservations","financial","inventory","customers","best_diners","services","tickets","users","waiters","dishes","settings"]}',
  'btn_pedidos',
  'Configuración por rol y módulo del botón flotante Nuevo Pedido'
)
ON DUPLICATE KEY UPDATE setting_key = setting_key;
