# Sistema de Imágenes para Platillos

## Funcionalidades Implementadas

### 1. Carga de Imágenes
- **Ubicación**: Formularios de creación y edición de platillos
- **Formatos soportados**: JPG, JPEG, PNG, GIF
- **Tamaño máximo**: 5MB por imagen
- **Vista previa**: Previsualización antes de guardar

### 2. Almacenamiento
- **Directorio**: `public/uploads/dishes/`
- **Nomenclatura**: `dish_[uniqid]_[timestamp].[extension]`
- **Seguridad**: Archivos .htaccess para protección

### 3. Visualización
- **Listado**: Thumbnails de 60x60px con modal en click
- **Detalles**: Imagen completa con modal
- **Placeholder**: Icono para platillos sin imagen

### 4. Gestión Automática
- **Reemplazo**: Al subir nueva imagen, se elimina la anterior
- **Eliminación**: Al borrar platillo, se elimina su imagen
- **Validación**: Tipo de archivo, tamaño y formato

## Estructura de Archivos

```
public/
├── uploads/
│   ├── .htaccess           # Protección de directorio
│   ├── index.php           # Redirect de seguridad
│   └── dishes/
│       ├── index.php       # Redirect de seguridad
│       └── [imágenes]      # Archivos de imagen
├── css/
│   └── dishes.css          # Estilos específicos
```

## Configuración del Servidor

### Apache
- Asegurar que `mod_rewrite` esté habilitado
- Los archivos .htaccess están configurados automáticamente

### Permisos
```bash
chmod 755 public/uploads/
chmod 755 public/uploads/dishes/
```

### PHP
- Verificar que `file_uploads = On`
- `upload_max_filesize >= 5M`
- `post_max_size >= 5M`

## Base de Datos

El campo `image` ya existe en la tabla `dishes`:
```sql
image varchar(255) NULL
```

No se requieren cambios adicionales en la base de datos.

## Uso

### Para Administradores
1. **Crear platillo**: Subir imagen opcional en el formulario
2. **Editar platillo**: Cambiar imagen o mantener la actual
3. **Ver listado**: Thumbnails clicables en la tabla
4. **Ver detalles**: Imagen completa con modal

### Para Meseros
- **Consultar menú**: Ver imágenes de platillos disponibles

## Características de Seguridad

1. **Validación de tipo MIME**
2. **Verificación de extensión**
3. **Límite de tamaño de archivo**
4. **Protección de directorios**
5. **Nombres de archivo únicos**
6. **Limpieza automática al eliminar**

## Responsive Design

- **Desktop**: Imágenes 60x60px en listado
- **Mobile**: Imágenes 50x50px en listado
- **Modal**: Adaptativo según tamaño de pantalla

## Mantenimiento

### Limpieza Manual
```php
// Función para limpiar archivos huérfanos
function cleanOrphanImages() {
    $uploadDir = 'public/uploads/dishes/';
    $files = glob($uploadDir . '*');
    
    foreach ($files as $file) {
        if (is_file($file)) {
            $filename = basename($file);
            // Verificar si existe en base de datos
            $query = "SELECT id FROM dishes WHERE image LIKE '%$filename%'";
            // Si no existe, eliminar archivo
        }
    }
}
```

### Migración de Imágenes Existentes
Si ya tienes imágenes en otro directorio, puedes moverlas:
```bash
mv /old/path/images/* public/uploads/dishes/
```

Y actualizar la base de datos:
```sql
UPDATE dishes SET image = CONCAT('uploads/dishes/', image) WHERE image IS NOT NULL;
```

## Troubleshooting

### Error de permisos
```bash
sudo chown -R www-data:www-data public/uploads/
sudo chmod -R 755 public/uploads/
```

### Imágenes no se muestran
1. Verificar ruta en BASE_URL
2. Comprobar permisos de archivos
3. Revisar configuración de .htaccess

### Archivos muy grandes
Incrementar límites PHP:
```ini
upload_max_filesize = 10M
post_max_size = 10M
memory_limit = 128M
```