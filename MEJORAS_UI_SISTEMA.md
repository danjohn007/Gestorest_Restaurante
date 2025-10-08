# Mejoras al Sistema de Restaurante

## Resumen de Cambios

Este documento describe las mejoras implementadas en el sistema de gestión de restaurante según los requerimientos especificados.

---

## 1. Mejoras en la Gestión de Pedidos (Orders)

### 1.1 Eliminación del Ícono de Imagen Vacío
**Archivo modificado:** `views/orders/create.php`

**Problema:** Cuando una imagen de platillo se cargaba correctamente, aparecía un ícono de imagen vacío debajo de ella, causando confusión visual.

**Solución:** Se eliminó el elemento div fallback que se mostraba cuando una imagen fallaba al cargar (`onerror`). Ahora, si una imagen se carga correctamente, solo se muestra la imagen sin elementos adicionales.

**Cambios específicos:**
- Eliminadas líneas 253-256 que contenían el div fallback con el ícono `bi-image`
- Simplificado el código de carga de imágenes para mejor claridad visual

### 1.2 Botón Fijo de "CONFIRMAR PEDIDO"
**Archivo modificado:** `views/orders/create.php`

**Mejora:** Se agregó un botón flotante fijo en la parte inferior de la pantalla que muestra:
- Total acumulado del pedido en tiempo real
- Botón grande y visible de "CONFIRMAR PEDIDO"
- Se muestra automáticamente cuando hay platillos en el carrito
- Se oculta cuando el carrito está vacío

**Características:**
- Posición fija en la parte inferior (`fixed-bottom`)
- Fondo blanco con sombra para mejor visibilidad
- Actualización en tiempo real del total
- z-index alto para mantenerse visible sobre otros elementos
- Diseño responsivo con Bootstrap

### 1.3 Búsqueda Filtrada por Categoría
**Archivo modificado:** `views/orders/create.php`

**Mejora:** El buscador de platillos ahora respeta la categoría seleccionada.

**Comportamiento:**
- Si se selecciona "Todas" las categorías: busca en todos los platillos
- Si se selecciona una categoría específica: solo busca dentro de esa categoría
- La búsqueda considera nombre, descripción y categoría del platillo
- Los resultados se actualizan dinámicamente mientras se escribe

**Funciones modificadas:**
- `filterDishes()`: Ahora verifica la categoría activa antes de filtrar
- `filterByCategory()`: Respeta el query de búsqueda activo al cambiar de categoría

---

## 2. Mejoras en la Gestión de Mesas (Tables)

### 2.1 Botón LAYOUT
**Archivo modificado:** `views/tables/index.php`

**Mejora:** Se agregó un nuevo botón "LAYOUT" en la barra superior.

**Características:**
- Visible para administradores con texto "LAYOUT"
- Visible para meseros con texto "Ver Layout"
- Ícono distintivo `bi-diagram-3`
- Color azul distintivo (`btn-outline-info`)

### 2.2 Vista de Layout Interactivo
**Archivo nuevo:** `views/tables/layout.php`

**Funcionalidad principal:**
- Vista tipo "plano" del restaurante con todas las mesas
- Área de trabajo con rejilla visual para mejor alineación
- Mesas representadas como elementos visuales arrastrable

**Características para Administradores:**
- **Drag & Drop**: Arrastrar y soltar mesas para posicionarlas
- **Dimensiones ajustables**: Cambiar ancho y alto del área de layout (800-3000px x 600-2000px)
- **Guardar layout**: Persistir posiciones de mesas en base de datos
- **Resetear posiciones**: Reorganizar mesas en rejilla automática
- **Snap to grid**: Las mesas se alinean a cada 10 píxeles automáticamente

**Características para Meseros y Cajeros:**
- Vista de solo lectura del layout
- Pueden hacer clic en mesas para crear pedidos directamente
- No pueden mover ni modificar posiciones

**Indicadores visuales:**
- Verde: Mesa disponible
- Rojo: Mesa ocupada
- Amarillo: Cuenta solicitada
- Cada mesa muestra: número y capacidad

### 2.3 Migración de Base de Datos
**Archivo nuevo:** `database/migration_table_layout.sql`

**Cambios en la tabla `tables`:**
```sql
ALTER TABLE tables 
ADD COLUMN position_x INT DEFAULT NULL COMMENT 'X position in layout (pixels)',
ADD COLUMN position_y INT DEFAULT NULL COMMENT 'Y position in layout (pixels)';

CREATE INDEX idx_tables_position ON tables(position_x, position_y);
```

**Campos agregados:**
- `position_x`: Posición horizontal de la mesa en píxeles
- `position_y`: Posición vertical de la mesa en píxeles
- Índice compuesto para optimizar consultas de posición

### 2.4 Endpoints del Controlador
**Archivo modificado:** `controllers/TablesController.php`

**Nuevos métodos:**

#### `layout()`
- **Ruta:** `/tables/layout`
- **Roles permitidos:** ADMIN, WAITER
- **Función:** Muestra la vista de layout con todas las mesas activas
- **Datos cargados:** 
  - Lista de mesas con información de meseros
  - Configuración de dimensiones del layout

#### `saveLayout()`
- **Ruta:** `/tables/saveLayout` (POST con JSON)
- **Rol permitido:** Solo ADMIN
- **Función:** Guarda las posiciones de las mesas
- **Parámetros esperados:**
  ```json
  {
    "positions": [
      {"id": 1, "x": 100, "y": 50},
      {"id": 2, "x": 200, "y": 50}
    ],
    "width": 1200,
    "height": 800
  }
  ```
- **Respuesta:** JSON con `success: true/false`

### 2.5 Modelo de Configuración
**Archivo modificado:** `models/SystemSettings.php`

**Métodos agregados:**
- `get($key, $default)`: Alias para obtener configuración
- `set($key, $value, $description)`: Alias para establecer configuración

**Uso:** Almacenar dimensiones del layout (`layout_width`, `layout_height`)

---

## Instalación y Configuración

### 1. Aplicar Migración de Base de Datos

Ejecutar el siguiente comando SQL en su base de datos:

```bash
mysql -u usuario -p nombre_base_datos < database/migration_table_layout.sql
```

O desde phpMyAdmin/MySQL Workbench:
1. Abrir el archivo `database/migration_table_layout.sql`
2. Ejecutar el script completo

### 2. Verificar Permisos

Asegurarse de que:
- Los usuarios con rol ADMIN tienen acceso completo a todas las funcionalidades
- Los usuarios con rol WAITER pueden ver pero no modificar el layout
- Los usuarios con rol CASHIER pueden ver el layout (si es necesario)

### 3. Configuración Inicial del Layout

1. Iniciar sesión como administrador
2. Ir a "Gestión de Mesas"
3. Hacer clic en el botón "LAYOUT"
4. Ajustar las dimensiones del área según el tamaño de su restaurante
5. Arrastrar y posicionar las mesas según la distribución real
6. Hacer clic en "Guardar Layout"

---

## Guía de Uso

### Para Administradores

#### Configurar Layout de Mesas:
1. Navegar a **Gestión de Mesas → LAYOUT**
2. Ajustar dimensiones del área (si es necesario)
3. Arrastrar cada mesa a su posición deseada
4. Las mesas se alinean automáticamente a la rejilla
5. Hacer clic en **"Guardar Layout"**

#### Resetear Posiciones:
1. En la vista de Layout
2. Hacer clic en **"Resetear Posiciones"**
3. Confirmar la acción
4. Las mesas se reorganizarán en una rejilla automática

### Para Meseros

#### Ver Layout:
1. Navegar a **Consultar Mesas → Ver Layout**
2. Ver la distribución visual de las mesas
3. Los colores indican el estado de cada mesa

#### Crear Pedido desde Layout:
1. En la vista de Layout
2. Hacer clic en cualquier mesa
3. Confirmar para crear un pedido
4. Se redirige automáticamente al formulario de creación de pedido

### Para Todos los Usuarios

#### Crear Pedidos:
1. El botón flotante "CONFIRMAR PEDIDO" aparece automáticamente al agregar platillos
2. Muestra el total acumulado en tiempo real
3. Siempre visible en la parte inferior de la pantalla
4. Hacer clic para enviar el pedido

#### Buscar Platillos por Categoría:
1. Seleccionar una categoría de platillo
2. Usar el buscador
3. Solo se mostrarán resultados de la categoría seleccionada
4. Seleccionar "Todas" para buscar en todas las categorías

---

## Notas Técnicas

### Rendimiento
- Las posiciones de mesas se almacenan en la base de datos
- El índice compuesto en `position_x, position_y` optimiza las consultas
- Las actualizaciones de posición son transaccionales

### Seguridad
- Solo administradores pueden modificar el layout
- Las peticiones POST requieren autenticación
- Validación de roles en el backend

### Compatibilidad
- Diseño responsivo usando Bootstrap 5
- Compatible con navegadores modernos (Chrome, Firefox, Safari, Edge)
- Funcionalidad drag-and-drop nativa de HTML5

### Límites
- Dimensiones del layout: 800-3000px (ancho) × 600-2000px (alto)
- Mesas se posicionan en píxeles absolutos
- Área de trabajo tiene scroll si es necesario

---

## Solución de Problemas

### Las mesas no se guardan
- Verificar que el usuario tenga rol ADMIN
- Verificar la conexión a la base de datos
- Revisar la consola del navegador para errores JavaScript

### El botón flotante no aparece
- Verificar que haya platillos agregados al pedido
- Limpiar caché del navegador
- Verificar que JavaScript esté habilitado

### No se pueden arrastrar las mesas
- Verificar que el usuario tenga rol ADMIN
- Verificar que el atributo `draggable="true"` esté presente
- Probar en un navegador diferente

---

## Archivos Modificados

1. `views/orders/create.php` - Vista de creación de pedidos
2. `views/tables/index.php` - Vista principal de mesas
3. `views/tables/layout.php` - **NUEVO** - Vista de layout interactivo
4. `controllers/TablesController.php` - Controlador de mesas
5. `models/SystemSettings.php` - Modelo de configuración
6. `database/migration_table_layout.sql` - **NUEVO** - Migración de BD

---

## Autor y Fecha

Implementado por: GitHub Copilot Agent  
Fecha: 2024  
Versión: 1.0
