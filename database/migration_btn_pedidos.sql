-- Migration: Mostrar Botón Pedidos settings
-- Adds configurable visibility settings for the floating "Nuevo Pedido" button.
-- Default values preserve current behavior (visible to all roles on all modules).
-- Compatible with MySQL 5.7
--
-- Role string values correspond to the PHP constants in config/config.php:
--   ROLE_ADMIN      = 'administrador'
--   ROLE_WAITER     = 'mesero'
--   ROLE_CASHIER    = 'cajero'
--   ROLE_SUPERADMIN = 'superadmin'

INSERT INTO `global_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
VALUES
  (
    'btn_pedidos_roles',
    '["administrador","mesero","cajero","superadmin"]',
    'btn_pedidos',
    'Roles de usuario que pueden ver el botón Nuevo Pedido'
  ),
  (
    'btn_pedidos_modules',
    '["dashboard","orders","tables","reservations","financial","inventory","customers","best_diners","services","tickets","users","waiters","dishes","settings"]',
    'btn_pedidos',
    'Módulos donde se muestra el botón Nuevo Pedido'
  )
ON DUPLICATE KEY UPDATE `setting_key` = `setting_key`;
