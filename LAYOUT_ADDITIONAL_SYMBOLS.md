# Símbolos Adicionales y Duplicación para Layout de Mesas

## Resumen

Este documento describe las nuevas funcionalidades agregadas al sistema de Layout de Mesas:
1. **Nuevos tipos de símbolos**: Alberca, Terraza, Patio, Puerta 2
2. **Duplicación de símbolos**: Permite crear copias de símbolos existentes
3. **Eliminación de símbolos**: Permite eliminar símbolos duplicados

## 1. Nuevos Tipos de Símbolos

### Símbolos Agregados

Se han agregado 4 nuevos tipos de símbolos al layout:

1. **ALBERCA** (🌊) - Color: Cian (#17a2b8)
   - Icono: `bi-water`
   - Uso: Marcar área de alberca/piscina

2. **TERRAZA** (🌳) - Color: Gris (#6c757d)
   - Icono: `bi-tree`
   - Uso: Indicar área de terraza

3. **PATIO** (🏡) - Color: Verde menta (#20c997)
   - Icono: `bi-house-door`
   - Uso: Marcar área de patio

4. **PUERTA 2** (🚪) - Color: Marrón (#8b4513)
   - Icono: `bi-door-closed`
   - Uso: Marcar puertas/salidas adicionales

### Instalación de Nuevos Símbolos

Para agregar los nuevos símbolos a la base de datos:

```bash
php apply_additional_symbols_migration.php
```

O ejecute manualmente el SQL:

```bash
mysql -u usuario -p nombre_bd < database/migration_additional_layout_symbols.sql
```

## 2. Duplicación de Símbolos

### Descripción

Los administradores ahora pueden duplicar cualquier símbolo existente en el layout. Esto es útil cuando necesita:
- Múltiples puertas en diferentes ubicaciones
- Varias áreas de terraza
- Duplicar cualquier símbolo para mejor organización del espacio

### Cómo Usar

1. Inicie sesión como administrador
2. Navegue al "Layout de Mesas"
3. Pase el cursor sobre el símbolo que desea duplicar
4. Haga clic en el botón "Duplicar" que aparece
5. Confirme la acción
6. El nuevo símbolo aparecerá con un desplazamiento de 30px (x: +30px, y: +30px)
7. Arrastre el símbolo duplicado a la posición deseada
8. Haga clic en "Guardar Layout" para guardar los cambios

### Características

- El símbolo duplicado tendrá el mismo icono y color que el original
- Se le agregará un número al label (ej: "PUERTA" → "PUERTA 2")
- La posición inicial será ligeramente desplazada del original
- Puede crear múltiples duplicados del mismo símbolo

## 3. Eliminación de Símbolos

### Descripción

Los administradores pueden eliminar símbolos duplicados que ya no necesiten. El sistema protege contra la eliminación del último símbolo de cada tipo.

### Cómo Usar

1. Inicie sesión como administrador
2. Navegue al "Layout de Mesas"
3. Pase el cursor sobre el símbolo que desea eliminar
4. Haga clic en el botón "Eliminar" que aparece
5. Confirme la acción
6. El símbolo se eliminará permanentemente

### Restricciones

- **No se puede eliminar el último símbolo de un tipo**: Debe quedar al menos un símbolo de cada tipo en el layout
- Solo administradores pueden eliminar símbolos
- La eliminación es permanente y no se puede deshacer

## Implementación Técnica

### Archivos Modificados

1. **database/migration_additional_layout_symbols.sql** (nuevo)
   - Migración SQL para agregar nuevos símbolos

2. **apply_additional_symbols_migration.php** (nuevo)
   - Script PHP para aplicar la migración

3. **models/LayoutSymbol.php** (modificado)
   - Agregado método `duplicateSymbol($id)`: Duplica un símbolo
   - Agregado método `deleteSymbol($id)`: Elimina un símbolo (con protección)

4. **controllers/TablesController.php** (modificado)
   - Agregado endpoint `duplicateSymbol()`: Maneja solicitudes de duplicación
   - Agregado endpoint `deleteSymbol()`: Maneja solicitudes de eliminación

5. **views/tables/layout.php** (modificado)
   - Agregados estilos CSS para nuevos símbolos (alberca, terraza, patio, puerta2)
   - Agregados estilos para botones de acción de símbolos
   - Agregados botones "Duplicar" y "Eliminar" en cada símbolo (solo admin)
   - Agregadas funciones JavaScript `duplicateSymbol()` y `deleteSymbol()`

### Endpoints API

#### Duplicar Símbolo
```
POST /tables/duplicateSymbol
Content-Type: application/json

{
  "id": 1
}

Response:
{
  "success": true,
  "symbol": {
    "id": 10,
    "type": "puerta",
    "label": "PUERTA 2",
    "position_x": 80,
    "position_y": 80,
    "icon": "bi-door-open"
  }
}
```

#### Eliminar Símbolo
```
POST /tables/deleteSymbol
Content-Type: application/json

{
  "id": 10
}

Response:
{
  "success": true
}

Error (si es el último símbolo del tipo):
{
  "success": false,
  "error": "Cannot delete this symbol. At least one of each type must remain."
}
```

### Estilos CSS

Los nuevos símbolos tienen colores distintivos:

```css
.symbol-item.type-alberca {
    border-color: #17a2b8;
    background-color: #d1ecf1;
}

.symbol-item.type-terraza {
    border-color: #6c757d;
    background-color: #e2e3e5;
}

.symbol-item.type-patio {
    border-color: #20c997;
    background-color: #d4f4dd;
}

.symbol-item.type-puerta2 {
    border-color: #8b4513;
    background-color: #f5deb3;
}
```

## Casos de Uso

### Caso 1: Restaurante con Múltiples Entradas

1. Admin abre el layout de mesas
2. Duplica el símbolo "PUERTA" dos veces
3. Arrastra las puertas duplicadas a las ubicaciones de las otras entradas
4. Guarda el layout
5. Ahora el personal puede ver todas las entradas del restaurante

### Caso 2: Restaurante con Terraza y Patio

1. Admin aplica la migración de nuevos símbolos
2. Abre el layout de mesas
3. Arrastra el símbolo "TERRAZA" al área de terraza
4. Arrastra el símbolo "PATIO" al área de patio
5. Guarda el layout
6. El personal ahora puede identificar fácilmente las diferentes áreas

### Caso 3: Eliminación de Símbolos No Utilizados

1. Admin decide que ya no necesita un símbolo duplicado
2. Pasa el cursor sobre el símbolo
3. Hace clic en "Eliminar"
4. Confirma la eliminación
5. El layout se actualiza automáticamente

## Verificación

Para verificar que los cambios se aplicaron correctamente:

1. **Verificar símbolos en la base de datos**:
```sql
SELECT type, label, icon FROM layout_symbols ORDER BY type;
```

2. **Acceder al layout como admin**:
   - Debe ver todos los símbolos (incluyendo los nuevos)
   - Al pasar el cursor sobre cada símbolo, debe ver los botones "Duplicar" y "Eliminar"

3. **Probar duplicación**:
   - Duplicar un símbolo
   - Verificar que aparece el nuevo símbolo con un label incrementado
   - Arrastrar y guardar

4. **Probar eliminación**:
   - Eliminar un símbolo duplicado → Debe funcionar
   - Intentar eliminar el último símbolo de un tipo → Debe mostrar error

## Seguridad

- Solo usuarios con rol `ROLE_ADMIN` pueden duplicar y eliminar símbolos
- Los usuarios no-admin pueden ver todos los símbolos pero no pueden:
  - Moverlos
  - Duplicarlos
  - Eliminarlos
- Las validaciones se realizan tanto en el frontend (JavaScript) como en el backend (PHP)

## Próximas Mejoras Sugeridas

- [ ] Permitir personalizar el icono al duplicar
- [ ] Permitir editar el label de símbolos duplicados
- [ ] Agregar más tipos de símbolos predefinidos (baño, estacionamiento, etc.)
- [ ] Permitir crear símbolos personalizados desde la interfaz
- [ ] Agregar un panel de administración de símbolos

## Soporte

Para preguntas o problemas relacionados con estas funcionalidades, contacte al equipo de desarrollo.
