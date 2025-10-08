-- Migration to add layout position fields to tables
-- This allows the admin to arrange tables in a visual layout

ALTER TABLE tables 
ADD COLUMN position_x INT DEFAULT NULL COMMENT 'X position in layout (pixels)',
ADD COLUMN position_y INT DEFAULT NULL COMMENT 'Y position in layout (pixels)';

-- Add index for position queries
CREATE INDEX idx_tables_position ON tables(position_x, position_y);
