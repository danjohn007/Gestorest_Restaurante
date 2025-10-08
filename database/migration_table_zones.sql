-- Migration to add table zones functionality
-- Date: 2024-12-23
-- Description: Add zone field to tables and create table_zones management

USE ejercito_restaurant;

-- Add zone field to tables
ALTER TABLE tables 
ADD COLUMN zone VARCHAR(50) DEFAULT '' 
AFTER capacity;

-- Create table_zones table for managing available zones
CREATE TABLE IF NOT EXISTS table_zones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#007bff',
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Note: Default zones are not inserted automatically
-- Users should create zones as needed through the interface

-- Update existing tables that have NULL zone to empty string
UPDATE tables SET zone = '' WHERE zone IS NULL;