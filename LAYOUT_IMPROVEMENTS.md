# Mejoras al Layout de Mesas

## Resumen de Cambios

Este documento describe las mejoras implementadas al sistema de Layout de Mesas del restaurante.

## 1. Link "Nuevo Pedido" en Cada Mesa

### Descripción
Cada mesa en el layout ahora muestra un link "Nuevo Pedido" al pasar el cursor sobre ella. Este link:
- Se muestra en la parte inferior de la mesa al hacer hover
- Redirige directamente a la página de creación de pedidos
- Precarga automáticamente la mesa seleccionada en el formulario

### Implementación
- **Vista**: `views/tables/layout.php`
  - Añadido `.table-actions` con el link "Nuevo Pedido"
  - Estilos CSS para mostrar el link al hacer hover
  
- **Controlador**: `controllers/OrdersController.php`
  - Modificado método `create()` para aceptar parámetro GET `table_id`
  - El parámetro se pasa a la vista como `$old['table_id']`

### Uso
1. Usuario navega al Layout de Mesas
2. Pasa el cursor sobre cualquier mesa
3. Aparece el botón "Nuevo Pedido"
4. Al hacer clic, se abre el formulario de creación con la mesa preseleccionada

## 2. Símbolos Arrastrables para el Layout

### Descripción
Se agregaron 5 tipos de símbolos que pueden ser arrastrados dentro del perímetro del layout (solo por administradores):

1. **PUERTA** (🚪) - Color: Marrón
2. **ENTRADA** (➡️) - Color: Verde
3. **BARRA** (🥤) - Color: Rojo
4. **CAJA** (💰) - Color: Amarillo
5. **COCINA** (🔥) - Color: Naranja

### Características
- Cada símbolo tiene un ícono Bootstrap y color distintivo
- Solo los administradores pueden moverlos
- Las posiciones se guardan en la base de datos
- Los usuarios no-admin pueden ver los símbolos pero no moverlos

### Implementación

#### Base de Datos
**Archivo**: `database/migration_layout_symbols.sql`

```sql
CREATE TABLE IF NOT EXISTS `layout_symbols` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `type` VARCHAR(50) NOT NULL,
  `label` VARCHAR(100) NOT NULL,
  `position_x` INT DEFAULT 0,
  `position_y` INT DEFAULT 0,
  `icon` VARCHAR(100) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### Modelo
**Archivo**: `models/LayoutSymbol.php`
- Métodos para obtener todos los símbolos
- Actualizar posiciones
- Resetear a posiciones por defecto

#### Controlador
**Archivo**: `controllers/TablesController.php`
- Método `layout()` carga los símbolos desde la BD
- Método `saveLayout()` guarda posiciones de símbolos junto con las mesas

#### Vista
**Archivo**: `views/tables/layout.php`
- Renderiza símbolos con estilos personalizados
- JavaScript maneja drag-and-drop de símbolos (solo admin)

## 3. Acceso Directo al Layout en Navegación Principal

### Descripción
Se agregó un link destacado "Layout de Mesas" en la barra de navegación principal, visible para:
- Administradores (ROLE_ADMIN)
- Meseros (ROLE_WAITER)
- Cajeros (ROLE_CASHIER)

### Implementación
**Archivo**: `views/layouts/header.php`

```php
<li class="nav-item">
    <a class="nav-link" href="<?= BASE_URL ?>/tables/layout">
        <i class="bi bi-diagram-3"></i> Layout de Mesas
    </a>
</li>
```

### Ubicación
El link aparece en el menú principal, después del link "Pedidos" y está disponible para todos los niveles de usuario mencionados.

## 4. Permisos y Roles

### Administradores (ROLE_ADMIN)
- ✅ Ver layout completo
- ✅ Mover mesas
- ✅ Mover símbolos
- ✅ Guardar configuración del layout
- ✅ Cambiar dimensiones del área
- ✅ Resetear posiciones

### Meseros (ROLE_WAITER)
- ✅ Ver layout completo
- ✅ Ver símbolos
- ✅ Hacer clic en mesas para crear pedidos
- ❌ No pueden mover mesas
- ❌ No pueden mover símbolos
- ❌ No pueden cambiar dimensiones

### Cajeros (ROLE_CASHIER)
- ✅ Ver layout completo
- ✅ Ver símbolos
- ✅ Hacer clic en mesas para crear pedidos
- ❌ No pueden mover mesas
- ❌ No pueden mover símbolos
- ❌ No pueden cambiar dimensiones

## Instalación

### 1. Aplicar Migración de Base de Datos

Ejecute el siguiente comando desde la raíz del proyecto:

```bash
php apply_layout_symbols_migration.php
```

O ejecute manualmente el SQL:

```bash
mysql -u usuario -p nombre_bd < database/migration_layout_symbols.sql
```

### 2. Verificar Instalación

Después de aplicar la migración, verifique que:

1. La tabla `layout_symbols` existe:
```sql
SHOW TABLES LIKE 'layout_symbols';
```

2. Los símbolos por defecto están insertados:
```sql
SELECT * FROM layout_symbols;
```

Debería ver 5 registros (puerta, entrada, barra, caja, cocina).

## Uso del Sistema

### Para Administradores

1. **Acceder al Layout**
   - Navegar a "Layout de Mesas" en el menú principal
   - O desde "Gestión de Mesas" → "LAYOUT"

2. **Organizar Mesas**
   - Arrastrar mesas a la posición deseada
   - Las mesas se alinean automáticamente a la rejilla

3. **Organizar Símbolos**
   - Arrastrar símbolos (PUERTA, ENTRADA, etc.) a sus posiciones
   - Los símbolos ayudan a orientar el espacio

4. **Ajustar Dimensiones** (Opcional)
   - Modificar ancho y alto del área
   - Hacer clic en "Aplicar"

5. **Guardar Cambios**
   - Hacer clic en "Guardar Layout"
   - Confirmar que se guardó exitosamente

### Para Meseros y Cajeros

1. **Ver Layout**
   - Navegar a "Layout de Mesas" en el menú principal
   - Ver distribución actual de mesas y símbolos

2. **Crear Pedido desde el Layout**
   - Pasar el cursor sobre una mesa
   - Hacer clic en "Nuevo Pedido"
   - El formulario se abre con la mesa preseleccionada

3. **Verificar Estado de Mesas**
   - Verde: Disponible
   - Rojo: Ocupada
   - Amarillo: Cuenta solicitada

## Estructura de Archivos Modificados

```
controllers/
  ├── OrdersController.php (modificado)
  └── TablesController.php (modificado)

models/
  └── LayoutSymbol.php (nuevo)

views/
  ├── layouts/
  │   └── header.php (modificado)
  └── tables/
      └── layout.php (modificado)

database/
  └── migration_layout_symbols.sql (nuevo)

apply_layout_symbols_migration.php (nuevo)
```

## Tecnologías Utilizadas

- **Backend**: PHP
- **Base de Datos**: MySQL
- **Frontend**: 
  - Bootstrap 5.3
  - Bootstrap Icons
  - JavaScript nativo (ES6+)
- **Drag & Drop**: HTML5 Drag and Drop API

## Consideraciones Técnicas

1. **Rendimiento**
   - Las posiciones se guardan con snap-to-grid (alineación a 10px)
   - Una sola llamada AJAX guarda todas las posiciones

2. **Compatibilidad**
   - Funciona en navegadores modernos (Chrome, Firefox, Safari, Edge)
   - Requiere JavaScript habilitado

3. **Seguridad**
   - Solo administradores pueden modificar el layout
   - Validación de roles en el servidor
   - Protección CSRF incluida

## Resolución de Problemas

### Los símbolos no aparecen
- Verificar que la migración se aplicó correctamente
- Verificar que hay registros en `layout_symbols`

### No puedo mover mesas/símbolos
- Verificar que tiene rol de administrador
- Verificar que JavaScript está habilitado

### El layout no se guarda
- Verificar permisos de escritura en la base de datos
- Revisar logs de error de PHP
- Verificar conexión a la base de datos

## Próximas Mejoras (Opcional)

- [ ] Agregar más tipos de símbolos (baño, terraza, etc.)
- [ ] Permitir personalizar colores de símbolos
- [ ] Agregar zoom in/out al layout
- [ ] Vista en miniatura del layout completo
- [ ] Exportar/importar configuración del layout

## Contacto

Para soporte o preguntas sobre estas mejoras, contacte al equipo de desarrollo.
