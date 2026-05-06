-- Migración: Fecha de Reservación en Ventas de Servicios
-- Fecha: 2026-05-06
-- Descripción:
--   Agrega el campo reservation_date a la tabla service_sales para registrar
--   la fecha en que se llevará a cabo el servicio (reservación).
--   Esto permite que los cortes de caja contabilicen correctamente las ventas
--   de servicios por fecha de reservación, no solo por fecha de creación.

ALTER TABLE `service_sales`
    ADD COLUMN `reservation_date` DATE NULL
        COMMENT 'Fecha de la reservación del servicio. Si es NULL, se usa DATE(created_at).'
    AFTER `notes`;

-- Actualizar registros existentes: usar la fecha de creación como fecha de reservación
UPDATE `service_sales` SET `reservation_date` = DATE(`created_at`) WHERE `reservation_date` IS NULL;
