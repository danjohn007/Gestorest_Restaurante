<?php
define('BASE_PATH', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

echo "=== Aplicando migración de símbolos adicionales del layout ===\n\n";

try {
    $db = Database::getInstance()->getConnection();
    
    // Read the migration file
    $migrationFile = __DIR__ . '/database/migration_additional_layout_symbols.sql';
    
    if (!file_exists($migrationFile)) {
        die("Error: No se encontró el archivo de migración: $migrationFile\n");
    }
    
    $sql = file_get_contents($migrationFile);
    
    if ($sql === false) {
        die("Error: No se pudo leer el archivo de migración\n");
    }
    
    echo "1. Ejecutando migración...\n";
    
    // Execute the migration
    try {
        $db->exec($sql);
        echo "   ✓ Ejecutado exitosamente\n";
    } catch (PDOException $e) {
        echo "   ⚠ Error al ejecutar migración: " . $e->getMessage() . "\n";
        // Continue to verify data
    }
    
    echo "\n2. Verificando símbolos adicionales...\n";
    $stmt = $db->query("SELECT type, label FROM layout_symbols WHERE type IN ('alberca', 'terraza', 'patio', 'puerta2')");
    $newSymbols = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($newSymbols) > 0) {
        echo "   ✓ Encontrados " . count($newSymbols) . " símbolos adicionales:\n";
        foreach ($newSymbols as $symbol) {
            echo "      - {$symbol['type']}: {$symbol['label']}\n";
        }
    } else {
        echo "   ⚠ No se encontraron los símbolos adicionales\n";
    }
    
    echo "\n3. Verificando total de símbolos...\n";
    $stmt = $db->query("SELECT COUNT(*) as total FROM layout_symbols");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   ✓ Total de símbolos en la base de datos: {$result['total']}\n";
    
    echo "\n✅ Migración completada exitosamente\n\n";
    
} catch (Exception $e) {
    echo "\n❌ Error fatal: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
    exit(1);
}
?>
