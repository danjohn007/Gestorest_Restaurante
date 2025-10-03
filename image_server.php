<?php
/**
 * Servidor de imágenes para platillos
 * Este script sirve imágenes cuando el servidor no permite acceso directo
 */

// Definir constantes básicas
define('BASE_PATH', __DIR__);

// Obtener el archivo solicitado
$file = $_GET['file'] ?? '';

// Sanitizar el nombre del archivo
$file = basename($file);

// Validar que el archivo existe
$imagePath = BASE_PATH . '/public/uploads/dishes/' . $file;

// Verificar que el archivo existe y es una imagen
if (!file_exists($imagePath)) {
    http_response_code(404);
    header('Content-Type: text/plain');
    echo 'Imagen no encontrada';
    exit;
}

// Verificar que es un archivo de imagen
$imageInfo = getimagesize($imagePath);
if ($imageInfo === false) {
    http_response_code(400);
    header('Content-Type: text/plain');
    echo 'Archivo no es una imagen válida';
    exit;
}

// Determinar el tipo MIME
$mimeType = $imageInfo['mime'];

// Establecer headers apropiados
header('Content-Type: ' . $mimeType);
header('Content-Length: ' . filesize($imagePath));
header('Cache-Control: public, max-age=31536000'); // Cache por 1 año
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 31536000) . ' GMT');

// Servir el archivo
readfile($imagePath);
exit;
?>