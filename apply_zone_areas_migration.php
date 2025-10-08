<?php
/**
 * Apply zone areas migration
 * This script adds zone area visualization fields to the table_zones table
 */

require_once __DIR__ . '/config/database.php';

try {
    $db = Database::getInstance()->getConnection();
    
    echo "=== Aplicando migración de áreas de zona ===\n\n";
    
    // Read and execute migration file
    $migrationFile = __DIR__ . '/database/migration_zone_areas.sql';
    
    if (!file_exists($migrationFile)) {
        die("Error: No se encuentra el archivo de migración: {$migrationFile}\n");
    }
    
    $sql = file_get_contents($migrationFile);
    
    // Remove USE statement to avoid issues if DB is already selected
    $sql = preg_replace('/USE\s+\w+;/i', '', $sql);
    
    // Split by semicolon and execute each statement
    $statements = array_filter(array_map('trim', explode(';', $sql)));
    
    $db->beginTransaction();
    
    foreach ($statements as $statement) {
        if (empty($statement) || strpos($statement, '--') === 0) {
            continue;
        }
        
        echo "Ejecutando: " . substr($statement, 0, 100) . "...\n";
        $db->exec($statement);
    }
    
    $db->commit();
    
    echo "\n✓ Migración aplicada exitosamente\n";
    echo "✓ Las zonas ahora tienen campos de posición y tamaño para el layout\n";
    
    // Verify the migration
    echo "\n=== Verificando zonas configuradas ===\n";
    $stmt = $db->query("SELECT name, color, position_x, position_y, width, height FROM table_zones WHERE active = 1");
    $zones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (!empty($zones)) {
        foreach ($zones as $zone) {
            echo sprintf(
                "- %s: posición (%d, %d), tamaño %dx%d, color %s\n",
                $zone['name'],
                $zone['position_x'],
                $zone['position_y'],
                $zone['width'],
                $zone['height'],
                $zone['color']
            );
        }
    }
    
} catch (PDOException $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollback();
    }
    die("Error en la base de datos: " . $e->getMessage() . "\n");
} catch (Exception $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollback();
    }
    die("Error: " . $e->getMessage() . "\n");
}
?>
