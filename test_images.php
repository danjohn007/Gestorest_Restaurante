<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test de Imágenes - Sistema de Platillos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php
// Define constants for testing
define('BASE_PATH', __DIR__);
define('BASE_URL', '/administración');
?>
    <div class="container mt-5">
        <h1>Prueba de Sistema de Imágenes</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Configuración Actual</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>BASE_URL:</strong> <?= BASE_URL ?></p>
                        <p><strong>BASE_PATH:</strong> <?= BASE_PATH ?></p>
                        <p><strong>Directorio de uploads:</strong> <?= BASE_PATH ?>/public/uploads/dishes/</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Prueba de Imagen</h5>
                    </div>
                    <div class="card-body text-center">
                        <img src="<?= BASE_URL ?>/public/uploads/dishes/test_image.svg" 
                             alt="Imagen de prueba" 
                             class="img-fluid"
                             style="max-width: 200px;"
                             onerror="this.nextElementSibling.style.display='block'; this.style.display='none';">
                        <div class="alert alert-danger" style="display: none;">
                            <strong>Error:</strong> No se pudo cargar la imagen de prueba.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Verificación de Directorios</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Directorio uploads existe:</strong> 
                            <?= is_dir(BASE_PATH . '/public/uploads/dishes/') ? 
                                '<span class="text-success">✓ Sí</span>' : 
                                '<span class="text-danger">✗ No</span>' ?>
                        </p>
                        <p><strong>Archivo de prueba existe:</strong> 
                            <?= file_exists(BASE_PATH . '/public/uploads/dishes/test_image.svg') ? 
                                '<span class="text-success">✓ Sí</span>' : 
                                '<span class="text-danger">✗ No</span>' ?>
                        </p>
                        <p><strong>URL completa de prueba:</strong> 
                            <code><?= BASE_URL ?>/public/uploads/dishes/test_image.svg</code>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <a href="<?= BASE_URL ?>/dishes" class="btn btn-primary">
                    Ir a Gestión de Platillos
                </a>
                <a href="<?= BASE_URL ?>/dishes/create" class="btn btn-success">
                    Crear Nuevo Platillo
                </a>
            </div>
        </div>
    </div>
</body>
</html>