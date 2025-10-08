<?php
define('BASE_PATH', __DIR__);
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/config/database.php';

echo "=== Aplicando migración de símbolos del layout ===\n\n";

try {
    $db = Database::getInstance()->getConnection();
    
    // Read the migration file
    $migrationFile = __DIR__ . '/database/migration_layout_symbols.sql';
    
    if (!file_exists($migrationFile)) {
        die("Error: No se encontró el archivo de migración: $migrationFile\n");
    }
    
    $sql = file_get_contents($migrationFile);
    
    if ($sql === false) {
        die("Error: No se pudo leer el archivo de migración\n");
    }
    
    echo "1. Ejecutando migración...\n";
    
    // Split by semicolons and execute each statement
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        function($stmt) {
            return !empty($stmt) && !preg_match('/^--/', $stmt);
        }
    );
    
    foreach ($statements as $statement) {
        if (!empty($statement)) {
            try {
                $db->exec($statement);
                echo "   ✓ Ejecutado exitosamente\n";
            } catch (PDOException $e) {
                // If table already exists, it's okay
                if (strpos($e->getMessage(), 'already exists') !== false) {
                    echo "   ℹ Tabla ya existe, continuando...\n";
                } else {
                    throw $e;
                }
            }
        }
    }
    
    echo "\n2. Verificando tabla layout_symbols...\n";
    $stmt = $db->query("SHOW TABLES LIKE 'layout_symbols'");
    if ($stmt->rowCount() > 0) {
        echo "   ✓ Tabla layout_symbols creada correctamente\n";
    } else {
        echo "   ✗ Error: Tabla layout_symbols no fue creada\n";
        exit(1);
    }
    
    echo "\n3. Verificando datos de símbolos...\n";
    $stmt = $db->query("SELECT COUNT(*) as count FROM layout_symbols");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "   ✓ Encontrados {$result['count']} símbolos\n";
    
    if ($result['count'] == 0) {
        echo "\n4. Insertando símbolos por defecto...\n";
        $insertSQL = "INSERT INTO `layout_symbols` (`type`, `label`, `position_x`, `position_y`, `icon`) VALUES
            ('puerta', 'PUERTA', 50, 50, 'bi-door-open'),
            ('entrada', 'ENTRADA', 200, 50, 'bi-box-arrow-in-right'),
            ('barra', 'BARRA', 350, 50, 'bi-cup-straw'),
            ('caja', 'CAJA', 500, 50, 'bi-cash-coin'),
            ('cocina', 'COCINA', 650, 50, 'bi-fire')";
        $db->exec($insertSQL);
        echo "   ✓ Símbolos insertados exitosamente\n";
    }
    
    echo "\n✅ Migración completada exitosamente\n";
    
} catch (Exception $e) {
    echo "\n❌ Error durante la migración: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
?>
