-- Migración: Corte de Caja - Ventas de Servicios y cálculo de Efectivo Final
-- Fecha: 2026-05-06
-- Descripción:
--   1. Agrega columna total_service_sales para registrar ventas de servicios por corte.
--   2. El campo final_cash ahora se calcula automáticamente como:
--      initial_cash + cash_ticket_sales + cash_service_sales - total_withdrawals

ALTER TABLE cash_closures
    ADD COLUMN total_service_sales DECIMAL(10,2) NOT NULL DEFAULT 0.00
        COMMENT 'Total de ventas de servicios en el período del corte'
    AFTER total_sales;

-- Actualizar registros existentes con el total de servicios (se deja en 0 ya que no
-- hay forma de recuperar el desglose histórico sin reanalizar transacciones).
-- Los nuevos cortes se calcularán automáticamente desde el código.
