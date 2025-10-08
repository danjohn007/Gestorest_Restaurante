# 📍 Guía de Visualización de Zonas en Layout de Mesas

## 🎯 Descripción General

Esta mejora agrega la capacidad de visualizar zonas en el layout de mesas mediante áreas con colores transparentes. Permite a los administradores organizar visualmente el espacio del restaurante definiendo diferentes zonas (Salón, Terraza, Alberca, etc.) con colores distintivos.

## ✨ Características Principales

### 1. **Áreas de Zona con Color Transparente**
- Cada zona se muestra como un área rectangular con color de fondo transparente
- El color de cada zona se define en la configuración de zonas
- Las áreas tienen bordes punteados semitransparentes para fácil identificación

### 2. **Movimiento de Zonas (Solo Administradores)**
- Las zonas se pueden arrastrar y soltar para reposicionarlas
- Funcionalidad drag-and-drop intuitiva
- Alineación automática a la cuadrícula

### 3. **Redimensionamiento de Zonas (Solo Administradores)**
- Cada zona tiene un control de redimensionamiento en la esquina inferior derecha
- Se puede ajustar el tamaño arrastrando el control
- Restricciones de tamaño mínimo y máximo

### 4. **Etiquetas de Zona**
- Cada zona muestra su nombre en la esquina superior izquierda
- La etiqueta tiene fondo semitransparente blanco para legibilidad
- Color del texto coincide con el color de la zona

### 5. **Integración con Sistema Existente**
- Compatible con mesas, símbolos y todas las funcionalidades existentes
- Las zonas se muestran debajo de mesas y símbolos (z-index: 1)
- No interfieren con la interacción de otros elementos

## 📋 Instalación

### Paso 1: Aplicar Migración de Base de Datos

Ejecute el script de migración para agregar los campos necesarios a la tabla `table_zones`:

```bash
php apply_zone_areas_migration.php
```

O manualmente:

```bash
mysql -u usuario -p nombre_bd < database/migration_zone_areas.sql
```

### Paso 2: Verificar Instalación

La migración agrega los siguientes campos a la tabla `table_zones`:
- `position_x` (INT): Posición horizontal de la zona en el layout
- `position_y` (INT): Posición vertical de la zona en el layout
- `width` (INT): Ancho de la zona en píxeles
- `height` (INT): Alto de la zona en píxeles

### Paso 3: Configurar Zonas Iniciales

Las zonas existentes se configuran automáticamente con posiciones y tamaños por defecto:

| Zona | Posición (x, y) | Tamaño (ancho x alto) |
|------|----------------|----------------------|
| Salón | (100, 100) | 450 x 300 |
| Terraza | (600, 100) | 450 x 300 |
| Alberca | (100, 450) | 450 x 250 |
| Spa | (600, 450) | 450 x 250 |
| Room Service | (300, 300) | 400 x 200 |

## 🎨 Uso del Sistema

### Para Administradores

#### 1. **Ver Zonas en el Layout**
- Navegar a "Layout de Mesas" desde el menú
- Las zonas aparecen como áreas rectangulares con colores transparentes
- Cada zona muestra su nombre en la esquina superior izquierda

#### 2. **Mover una Zona**
- Hacer clic y arrastrar el área de la zona
- Soltar en la nueva posición deseada
- La zona se alinea automáticamente a la cuadrícula

#### 3. **Redimensionar una Zona**
- Pasar el cursor sobre la esquina inferior derecha de la zona
- Aparece un control de redimensionamiento (flecha diagonal)
- Hacer clic y arrastrar para ajustar el tamaño
- Tamaño mínimo: 150px x 100px

#### 4. **Guardar Cambios**
- Después de mover o redimensionar zonas
- Hacer clic en el botón "Guardar Layout"
- Se confirma el guardado exitoso con un mensaje

#### 5. **Gestionar Zonas**
- Ir a "Gestión de Mesas" → "Zonas"
- Crear nuevas zonas con nombre, descripción y color
- Editar zonas existentes
- Eliminar zonas no utilizadas

### Para Meseros y Cajeros

- **Vista de Solo Lectura**: Pueden ver las zonas pero no moverlas ni redimensionarlas
- **Orientación Visual**: Las zonas ayudan a ubicar rápidamente las mesas
- **Códigos de Color**: Identificación rápida de diferentes áreas del restaurante

## 🎨 Personalización de Colores

### Cómo se Aplican los Colores

1. **Color de Zona**: Se define en la gestión de zonas (formato hexadecimal, ej: #007bff)
2. **Fondo Transparente**: El color se convierte automáticamente a RGBA con 15% de opacidad
3. **Borde**: Usa el mismo color con 50% de opacidad

### Ejemplo de Transformación de Color

```php
Color original: #007bff (azul)
Fondo: rgba(0, 123, 255, 0.15) - 15% de opacidad
Borde: rgba(0, 123, 255, 0.5) - 50% de opacidad
```

### Colores Recomendados por Tipo de Zona

| Tipo de Zona | Color Recomendado | Código Hex |
|--------------|-------------------|------------|
| Salón Principal | Azul | #007bff |
| Terraza | Verde | #28a745 |
| Alberca | Cian | #17a2b8 |
| Spa | Morado | #6f42c1 |
| Room Service | Naranja | #fd7e14 |
| Bar | Rojo | #dc3545 |
| VIP | Dorado | #ffc107 |

## 🔧 Detalles Técnicos

### Archivos Modificados

1. **database/migration_zone_areas.sql** (nuevo)
   - Migración de base de datos para agregar campos de posición y tamaño

2. **apply_zone_areas_migration.php** (nuevo)
   - Script para aplicar la migración de forma sencilla

3. **models/TableZone.php** (modificado)
   - Método `getZonesForLayout()`: Obtiene zonas con información de posición
   - Método `updateZoneArea()`: Actualiza posición y tamaño de zona

4. **controllers/TablesController.php** (modificado)
   - Método `layout()`: Carga zonas para visualización
   - Método `saveLayout()`: Guarda posiciones y tamaños de zonas

5. **views/tables/layout.php** (modificado)
   - CSS para estilos de áreas de zona
   - HTML para renderizar zonas con colores transparentes
   - JavaScript para drag-and-drop y redimensionamiento

### Estructura de Datos de Zona

```javascript
{
    id: 1,
    name: "Salón",
    color: "#007bff",
    position_x: 100,
    position_y: 100,
    width: 450,
    height: 300
}
```

### Flujo de Guardado

1. Usuario arrastra/redimensiona zonas
2. Hace clic en "Guardar Layout"
3. JavaScript recopila datos de todas las zonas
4. Envía petición POST a `/tables/saveLayout`
5. Controlador actualiza base de datos
6. Respuesta confirma éxito

## 🎯 Casos de Uso

### Caso 1: Restaurante con Diferentes Ambientes
```
┌─────────────────────────────────────────┐
│  [Salón Principal - Azul]               │
│   Mesa 1, Mesa 2, Mesa 3...             │
│                                          │
├─────────────────────────────────────────┤
│  [Terraza - Verde]                      │
│   Mesa 10, Mesa 11...                   │
└─────────────────────────────────────────┘
```

### Caso 2: Hotel con Múltiples Zonas de Servicio
```
┌──────────────┬──────────────┐
│ [Room Service│ [Spa - Morado]
│  - Naranja]  │               │
├──────────────┼──────────────┤
│ [Alberca     │ [Bar - Rojo] │
│  - Cian]     │               │
└──────────────┴──────────────┘
```

### Caso 3: Organización por Capacidad
```
┌─────────────────────────────────────────┐
│  [Zona VIP - Dorado]                    │
│   Mesas grandes: 8-12 personas          │
│                                          │
├─────────────────────────────────────────┤
│  [Zona Familiar - Verde]                │
│   Mesas medianas: 4-6 personas          │
│                                          │
├─────────────────────────────────────────┤
│  [Zona Íntima - Azul]                   │
│   Mesas pequeñas: 2 personas            │
└─────────────────────────────────────────┘
```

## 💡 Mejores Prácticas

### 1. **Organización Espacial**
- Agrupe mesas relacionadas dentro de la misma zona
- Deje espacio entre zonas para claridad visual
- Use el redimensionamiento para ajustar zonas al contenido

### 2. **Selección de Colores**
- Use colores contrastantes para zonas adyacentes
- Mantenga consistencia con la decoración física del restaurante
- Evite colores muy similares que dificulten la distinción

### 3. **Nomenclatura**
- Use nombres descriptivos y cortos
- Sea consistente con la señalización física
- Considere el uso de abreviaturas para zonas grandes

### 4. **Mantenimiento**
- Actualice las zonas cuando cambie la distribución física
- Revise periódicamente que las zonas reflejen la realidad
- Guarde cambios después de cada modificación

## 🐛 Resolución de Problemas

### Problema: Las zonas no se muestran
**Solución:**
1. Verificar que la migración se aplicó correctamente
2. Revisar que existan zonas activas en la base de datos
3. Comprobar permisos de usuario (debe tener acceso a layout)

### Problema: No puedo mover las zonas
**Solución:**
- Solo los administradores pueden mover zonas
- Verificar que el usuario tenga rol ROLE_ADMIN

### Problema: Las zonas no se guardan
**Solución:**
1. Verificar que se hace clic en "Guardar Layout"
2. Revisar la consola del navegador para errores
3. Comprobar permisos de base de datos

### Problema: Colores no se muestran correctamente
**Solución:**
- Verificar que los colores en la tabla `table_zones` sean códigos hexadecimales válidos (#RRGGBB)
- Limpiar caché del navegador

## 📊 Ventajas del Sistema

✅ **Organización Visual Mejorada**
- Identificación rápida de áreas del restaurante
- Mejor orientación para meseros nuevos
- Comunicación clara de la distribución espacial

✅ **Flexibilidad**
- Fácil adaptación a cambios de distribución
- Personalización de colores por zona
- Ajuste dinámico de tamaños

✅ **Compatibilidad**
- Funciona con todas las funcionalidades existentes
- No interfiere con mesas ni símbolos
- Integración transparente

✅ **Usabilidad**
- Interfaz intuitiva de arrastrar y soltar
- Redimensionamiento fácil
- Vista previa en tiempo real

## 🚀 Próximas Mejoras (Futuras)

- [ ] Agregar opacidad configurable por zona
- [ ] Permitir formas personalizadas (no solo rectángulos)
- [ ] Agregar descripción emergente al pasar el cursor
- [ ] Estadísticas por zona (ocupación, ventas)
- [ ] Exportar/importar configuración de zonas
- [ ] Plantillas predefinidas de distribución

## 📞 Soporte

Para reportar problemas o sugerir mejoras, contacte con el equipo de desarrollo o abra un issue en el repositorio del proyecto.

---

**Versión:** 1.0  
**Fecha:** Diciembre 2024  
**Compatibilidad:** Sistema Gestorest 2.0+
