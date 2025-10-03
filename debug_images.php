<?php
// Diagnóstico de sistema de imágenes
define('BASE_PATH', __DIR__);
define('BASE_URL', '/administración');

// Include configuration to access database
require_once BASE_PATH . '/config/config.php';
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/core/BaseModel.php';
require_once BASE_PATH . '/models/Dish.php';

$dishModel = new Dish();

// Get some dishes with images
$query = "SELECT * FROM dishes WHERE active = 1 AND image IS NOT NULL LIMIT 5";
$stmt = $dishModel->db->prepare($query);
$stmt->execute();
$dishes = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagnóstico de Imágenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Diagnóstico del Sistema de Imágenes</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Configuración del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>BASE_URL:</strong> <code><?= BASE_URL ?></code></p>
                        <p><strong>BASE_PATH:</strong> <code><?= BASE_PATH ?></code></p>
                        <p><strong>Directorio uploads:</strong> <code><?= BASE_PATH ?>/public/uploads/dishes/</code></p>
                        <p><strong>URL actual:</strong> <code><?= $_SERVER['REQUEST_URI'] ?></code></p>
                        <p><strong>Host:</strong> <code><?= $_SERVER['HTTP_HOST'] ?></code></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Verificación de Archivos</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Directorio existe:</strong> 
                            <?= is_dir(BASE_PATH . '/public/uploads/dishes/') ? 
                                '<span class="text-success">✓ Sí</span>' : 
                                '<span class="text-danger">✗ No</span>' ?>
                        </p>
                        <p><strong>Archivos en directorio:</strong></p>
                        <ul class="small">
                            <?php
                            $uploadDir = BASE_PATH . '/public/uploads/dishes/';
                            if (is_dir($uploadDir)) {
                                $files = scandir($uploadDir);
                                foreach ($files as $file) {
                                    if ($file != '.' && $file != '..') {
                                        $fullPath = $uploadDir . $file;
                                        echo "<li>{$file} (" . filesize($fullPath) . " bytes)</li>";
                                    }
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Platillos con Imágenes en Base de Datos</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($dishes)): ?>
                            <div class="alert alert-warning">
                                <strong>No hay platillos con imágenes en la base de datos.</strong>
                                <p>Esto podría explicar por qué no ves imágenes. Intenta crear un platillo con imagen.</p>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Path en BD</th>
                                            <th>URL Generada</th>
                                            <th>Archivo Existe</th>
                                            <th>Prueba</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dishes as $dish): ?>
                                        <tr>
                                            <td><?= $dish['id'] ?></td>
                                            <td><?= htmlspecialchars($dish['name']) ?></td>
                                            <td><code class="small"><?= htmlspecialchars($dish['image']) ?></code></td>
                                            <td><code class="small"><?= BASE_URL . '/' . $dish['image'] ?></code></td>
                                            <td>
                                                <?php
                                                $fullPath = BASE_PATH . '/' . $dish['image'];
                                                echo file_exists($fullPath) ? 
                                                    '<span class="text-success">✓ Sí</span>' : 
                                                    '<span class="text-danger">✗ No</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <img src="<?= BASE_URL ?>/<?= htmlspecialchars($dish['image']) ?>" 
                                                     alt="<?= htmlspecialchars($dish['name']) ?>" 
                                                     style="width: 50px; height: 50px; object-fit: cover;"
                                                     onerror="this.nextElementSibling.style.display='block'; this.style.display='none';">
                                                <span class="text-danger small" style="display: none;">Error</span>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Prueba de Acceso Directo</h5>
                    </div>
                    <div class="card-body">
                        <p>Prueba acceder directamente a la imagen de prueba:</p>
                        <p><a href="<?= BASE_URL ?>/public/uploads/dishes/test_image.svg" target="_blank" class="btn btn-primary">
                            Abrir imagen de prueba
                        </a></p>
                        <p class="small text-muted">Si esta imagen no se abre, hay un problema de configuración del servidor.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <a href="<?= BASE_URL ?>/dishes" class="btn btn-success">Volver a Platillos</a>
                <a href="<?= BASE_URL ?>/dishes/create" class="btn btn-primary">Crear Platillo</a>
            </div>
        </div>
    </div>
</body>
</html>