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

-- Update existing zones with default positions
UPDATE table_zones SET 
    position_x = CASE name
        WHEN 'Salón' THEN 100
        WHEN 'Terraza' THEN 600
        WHEN 'Alberca' THEN 100
        WHEN 'Spa' THEN 600
        WHEN 'Room Service' THEN 300
        ELSE 100
    END,
    position_y = CASE name
        WHEN 'Salón' THEN 100
        WHEN 'Terraza' THEN 100
        WHEN 'Alberca' THEN 450
        WHEN 'Spa' THEN 450
        WHEN 'Room Service' THEN 300
        ELSE 100
    END,
    width = CASE name
        WHEN 'Salón' THEN 450
        WHEN 'Terraza' THEN 450
        WHEN 'Alberca' THEN 450
        WHEN 'Spa' THEN 450
        WHEN 'Room Service' THEN 400
        ELSE 400
    END,
    height = CASE name
        WHEN 'Salón' THEN 300
        WHEN 'Terraza' THEN 300
        WHEN 'Alberca' THEN 250
        WHEN 'Spa' THEN 250
        WHEN 'Room Service' THEN 200
        ELSE 300
    END
WHERE active = 1;
