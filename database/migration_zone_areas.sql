-- Migration to add zone areas to the layout
-- Date: 2024-12-23
-- Description: Add zone area visualization support to table layout

USE ejercito_restaurant;

-- Add position and size fields to table_zones for layout visualization
ALTER TABLE table_zones 
ADD COLUMN position_x INT DEFAULT 100 AFTER color,
ADD COLUMN position_y INT DEFAULT 100 AFTER position_x,
ADD COLUMN width INT DEFAULT 400 AFTER position_y,
ADD COLUMN height INT DEFAULT 300 AFTER width;

-- Update existing zones with default positions if they don't have them
UPDATE table_zones SET 
    position_x = 100,
    position_y = 100
WHERE active = 1 AND (position_x IS NULL OR position_x = 0);
