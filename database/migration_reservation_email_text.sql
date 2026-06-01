INSERT INTO `global_settings` (`setting_key`, `setting_value`, `setting_group`, `description`)
VALUES (
    'reservation_cancellation_text',
    'Si necesita modificar o cancelar su reservación, por favor contacte con nosotros lo antes posible.',
    'email',
    'Texto mostrado debajo de la información de contacto en correos de confirmación de reservaciones'
)
ON DUPLICATE KEY UPDATE
    `setting_value` = COALESCE(NULLIF(`setting_value`, ''), VALUES(`setting_value`)),
    `setting_group` = VALUES(`setting_group`),
    `description` = VALUES(`description`);
