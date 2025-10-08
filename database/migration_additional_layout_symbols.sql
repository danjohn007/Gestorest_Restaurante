-- Migration: Add additional layout symbols (alberca, terraza, patio, puerta2)
-- Date: 2025-01-XX

-- Insert new symbols (only if they don't exist)
INSERT INTO `layout_symbols` (`type`, `label`, `position_x`, `position_y`, `icon`) 
SELECT * FROM (
    SELECT 'alberca' as type, 'ALBERCA' as label, 800 as position_x, 50 as position_y, 'bi-water' as icon
    UNION ALL
    SELECT 'terraza', 'TERRAZA', 950, 50, 'bi-tree'
    UNION ALL
    SELECT 'patio', 'PATIO', 50, 200, 'bi-house-door'
    UNION ALL
    SELECT 'puerta2', 'PUERTA 2', 200, 200, 'bi-door-closed'
) AS tmp
WHERE NOT EXISTS (
    SELECT 1 FROM `layout_symbols` WHERE `type` = tmp.type
);
