-- Migration: Add layout_symbols table for storing positions of symbols (PUERTAS, ENTRADA, BARRA, CAJA, COCINA)
-- Date: 2025-01-XX

CREATE TABLE IF NOT EXISTS `layout_symbols` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL COMMENT 'Type of symbol: puerta, entrada, barra, caja, cocina',
  `label` VARCHAR(100) NOT NULL COMMENT 'Display label for the symbol',
  `position_x` INT DEFAULT 0 COMMENT 'X position in layout',
  `position_y` INT DEFAULT 0 COMMENT 'Y position in layout',
  `icon` VARCHAR(100) DEFAULT NULL COMMENT 'Bootstrap icon class',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default symbols
INSERT INTO `layout_symbols` (`type`, `label`, `position_x`, `position_y`, `icon`) VALUES
('puerta', 'PUERTA', 50, 50, 'bi-door-open'),
('entrada', 'ENTRADA', 200, 50, 'bi-box-arrow-in-right'),
('barra', 'BARRA', 350, 50, 'bi-cup-straw'),
('caja', 'CAJA', 500, 50, 'bi-cash-coin'),
('cocina', 'COCINA', 650, 50, 'bi-fire');
