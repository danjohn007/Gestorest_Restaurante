-- Services table
CREATE TABLE IF NOT EXISTS `services` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10,2) NOT NULL,
  `category` VARCHAR(100),
  `active` TINYINT(1) DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Service sales table
CREATE TABLE IF NOT EXISTS `service_sales` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `service_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `quantity` INT NOT NULL DEFAULT 1,
  `unit_price` DECIMAL(10,2) NOT NULL,
  `total` DECIMAL(10,2) NOT NULL,
  `payment_method` ENUM('efectivo','tarjeta','transferencia') DEFAULT 'efectivo',
  `cash_received` DECIMAL(10,2) NULL,
  `change_amount` DECIMAL(10,2) NULL,
  `notes` TEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`service_id`) REFERENCES `services`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
);

-- Global settings table
CREATE TABLE IF NOT EXISTS `global_settings` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `setting_key` VARCHAR(100) UNIQUE NOT NULL,
  `setting_value` TEXT,
  `setting_group` VARCHAR(50) DEFAULT 'general',
  `description` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Action logs table
CREATE TABLE IF NOT EXISTS `action_logs` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NULL,
  `action` VARCHAR(100) NOT NULL,
  `entity_type` VARCHAR(100),
  `entity_id` INT,
  `description` TEXT,
  `ip_address` VARCHAR(45),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
);

-- Error logs table
CREATE TABLE IF NOT EXISTS `error_logs` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `error_type` VARCHAR(50),
  `message` TEXT NOT NULL,
  `file` VARCHAR(500),
  `line` INT,
  `stack_trace` TEXT,
  `url` VARCHAR(500),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add cash fields to tickets
ALTER TABLE `tickets` ADD COLUMN IF NOT EXISTS `cash_received` DECIMAL(10,2) NULL;
ALTER TABLE `tickets` ADD COLUMN IF NOT EXISTS `change_amount` DECIMAL(10,2) NULL;
