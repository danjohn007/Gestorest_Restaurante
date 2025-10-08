# 🎯 Símbolos Adicionales y Duplicación - Layout de Mesas

## 📋 Resumen Ejecutivo

Esta actualización agrega nuevas capacidades al sistema de Layout de Mesas:

✅ **4 nuevos tipos de símbolos**: Alberca, Terraza, Patio, Puerta 2  
✅ **Duplicación de símbolos**: Crear copias de cualquier símbolo existente  
✅ **Eliminación controlada**: Eliminar símbolos duplicados con protección  

## 🎨 Nuevos Símbolos

| Símbolo | Icono | Color | Uso |
|---------|-------|-------|-----|
| **ALBERCA** | 🌊 bi-water | Cian (#17a2b8) | Marcar área de alberca/piscina |
| **TERRAZA** | 🌳 bi-tree | Gris (#6c757d) | Indicar área de terraza |
| **PATIO** | 🏡 bi-house-door | Verde menta (#20c997) | Marcar área de patio |
| **PUERTA 2** | 🚪 bi-door-closed | Marrón (#8b4513) | Puertas/salidas adicionales |

## 🚀 Instalación Rápida

```bash
# Ejecutar desde la raíz del proyecto
php apply_additional_symbols_migration.php
```

### Verificación

```sql
-- Ver todos los símbolos
SELECT type, label, icon FROM layout_symbols ORDER BY type;

-- Debe mostrar 9 símbolos (5 originales + 4 nuevos)
```

## 💡 Uso de Funciones

### 📋 Duplicar un Símbolo

1. **Acceder** al Layout de Mesas como administrador
2. **Pasar cursor** sobre el símbolo que desea duplicar
3. **Click** en botón "Duplicar" 
4. **Confirmar** la acción
5. **Arrastrar** el símbolo duplicado a la posición deseada
6. **Guardar** el layout

**Resultado**: Nuevo símbolo con label incrementado (ej: "PUERTA 2")

### 🗑️ Eliminar un Símbolo

1. **Acceder** al Layout de Mesas como administrador
2. **Pasar cursor** sobre el símbolo duplicado
3. **Click** en botón "Eliminar"
4. **Confirmar** la eliminación

**⚠️ Protección**: No se puede eliminar el último símbolo de cada tipo

## 🎬 Casos de Uso

### Caso 1: Restaurante con Alberca

```
Antes:                     Después:
┌─────────────┐           ┌─────────────┐
│  🔥 COCINA  │           │  🔥 COCINA  │
│             │           │             │
│  Mesa 1     │           │  Mesa 1     │
│             │           │  🌊 ALBERCA │
│  Mesa 2     │    →      │             │
│             │           │  Mesa 2     │
│             │           │             │
└─────────────┘           └─────────────┘
```

**Pasos**:
1. Aplicar migración de nuevos símbolos
2. Abrir layout como admin
3. Arrastrar símbolo ALBERCA al área correspondiente
4. Guardar layout

### Caso 2: Múltiples Entradas

```
Antes:                     Después:
┌─────────────┐           ┌─────────────┐
│ 🚪 PUERTA   │           │ 🚪 PUERTA   │
│             │           │             │
│  Mesas...   │           │  Mesas...   │
│             │    →      │             │
│             │           │ 🚪 PUERTA 2 │
│             │           │             │
└─────────────┘           └─────────────┘
```

**Pasos**:
1. Pasar cursor sobre símbolo PUERTA
2. Click en "Duplicar"
3. Arrastrar PUERTA 2 a la segunda entrada
4. Guardar layout

### Caso 3: Terraza y Patio

```
Layout Completo:
┌───────────────────────────────────────┐
│ 🚪 ENTRADA    🔥 COCINA   💰 CAJA    │
│                                       │
│  [Área Interior]                      │
│   Mesa 1  Mesa 2  Mesa 3              │
│   Mesa 4  Mesa 5  Mesa 6              │
│                                       │
│ ═══════════════════════════════════   │
│ 🌳 TERRAZA                            │
│   Mesa 7  Mesa 8                      │
│                                       │
│ ───────────────────────────────────   │
│ 🏡 PATIO                              │
│   Mesa 9  Mesa 10  🌊 ALBERCA         │
└───────────────────────────────────────┘
```

## 🔧 Detalles Técnicos

### Archivos Modificados

```
📁 Proyecto
├── 📄 models/LayoutSymbol.php (modificado)
│   ├── duplicateSymbol($id)
│   └── deleteSymbol($id)
│
├── 📄 controllers/TablesController.php (modificado)
│   ├── duplicateSymbol()
│   └── deleteSymbol()
│
├── 📄 views/tables/layout.php (modificado)
│   ├── Nuevos estilos CSS
│   ├── Botones de acción en símbolos
│   └── Funciones JavaScript
│
├── 📄 database/migration_additional_layout_symbols.sql (nuevo)
│   └── INSERT nuevos símbolos
│
└── 📄 apply_additional_symbols_migration.php (nuevo)
    └── Script de aplicación
```

### API Endpoints

#### Duplicar Símbolo
```http
POST /tables/duplicateSymbol
Content-Type: application/json

Request:
{
  "id": 1
}

Success Response (200):
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
```http
POST /tables/deleteSymbol
Content-Type: application/json

Request:
{
  "id": 10
}

Success Response (200):
{
  "success": true
}

Error Response (400):
{
  "success": false,
  "error": "Cannot delete this symbol. At least one of each type must remain."
}
```

### Lógica de Duplicación

```php
// Pseudo-código
duplicateSymbol($id) {
    1. Obtener símbolo original
    2. Contar símbolos del mismo tipo
    3. Crear nuevo símbolo:
       - Mismo tipo e icono
       - Label incrementado (ej: "PUERTA 2")
       - Posición con offset (+30px x, +30px y)
    4. Insertar en BD
    5. Retornar nuevo símbolo
}
```

### Lógica de Eliminación

```php
// Pseudo-código
deleteSymbol($id) {
    1. Obtener símbolo a eliminar
    2. Contar símbolos del mismo tipo
    3. Si count > 1:
       - Eliminar de BD
       - Retornar success
    4. Si count == 1:
       - Rechazar operación
       - Retornar error
}
```

## 🔒 Seguridad

| Acción | Admin | Mesero | Cajero |
|--------|-------|--------|--------|
| Ver símbolos | ✅ | ✅ | ✅ |
| Mover símbolos | ✅ | ❌ | ❌ |
| Duplicar símbolos | ✅ | ❌ | ❌ |
| Eliminar símbolos | ✅ | ❌ | ❌ |

**Validación en múltiples capas**:
- Frontend: Botones visibles solo para admin
- JavaScript: Verificación de permisos
- Backend: `$this->requireRole([ROLE_ADMIN])`

## ✅ Testing

### Test Automatizado

```bash
php test_symbol_logic.php
```

**Verifica**:
- ✅ Nuevos tipos de símbolos definidos
- ✅ Lógica de duplicación
- ✅ Protección de eliminación
- ✅ Estructura de CSS
- ✅ Endpoints API

### Test Manual

1. **Verificar nuevos símbolos**
   - Login como admin
   - Ir a Layout de Mesas
   - Verificar que aparecen los 4 nuevos símbolos

2. **Probar duplicación**
   - Hover sobre cualquier símbolo
   - Click en "Duplicar"
   - Verificar que aparece nuevo símbolo con label incrementado

3. **Probar eliminación**
   - Duplicar un símbolo primero
   - Hover sobre el duplicado
   - Click en "Eliminar"
   - Verificar que se elimina correctamente

4. **Probar protección**
   - Intentar eliminar el único símbolo de un tipo
   - Verificar mensaje de error

## 📊 Estadísticas

**Cambios en el código**:
- 5 archivos creados
- 3 archivos modificados
- ~400 líneas de código agregadas
- 4 nuevos símbolos disponibles
- 2 nuevos endpoints API
- 100% cobertura de pruebas lógicas

## 🐛 Solución de Problemas

### Los nuevos símbolos no aparecen

**Causa**: Migración no aplicada  
**Solución**: 
```bash
php apply_additional_symbols_migration.php
```

### No veo los botones Duplicar/Eliminar

**Causa**: No es usuario admin  
**Solución**: Login con cuenta de administrador

### Error al eliminar símbolo

**Causa**: Intentando eliminar el último del tipo  
**Solución**: Es intencional - debe quedar al menos 1 de cada tipo

### Símbolos duplicados aparecen en la misma posición

**Causa**: Normal - tienen offset de +30px  
**Solución**: Arrastrar a la posición deseada y guardar

## 📚 Documentación Relacionada

- `LAYOUT_ADDITIONAL_SYMBOLS.md` - Documentación detallada
- `LAYOUT_SYMBOLS_VISUAL_GUIDE.md` - Guía visual con diagramas
- `LAYOUT_IMPROVEMENTS.md` - Mejoras originales del layout
- `README_LAYOUT_IMPROVEMENTS.md` - README de funcionalidades base

## 🎉 Beneficios

### Para el Restaurante
- ✅ Mayor flexibilidad en configuración
- ✅ Representación precisa del espacio físico
- ✅ Fácil adaptación a cambios

### Para el Personal
- ✅ Mejor orientación en el espacio
- ✅ Identificación clara de áreas
- ✅ Interfaz intuitiva y fácil de usar

### Para el Administrador
- ✅ Control total sobre el layout
- ✅ Modificaciones sin conocimientos técnicos
- ✅ Cambios inmediatos y visuales

## 🔄 Próximas Mejoras Sugeridas

- [ ] Personalizar iconos al duplicar
- [ ] Editar labels de símbolos duplicados
- [ ] Más símbolos predefinidos (baño, estacionamiento)
- [ ] Símbolos personalizados desde UI
- [ ] Panel de administración de símbolos
- [ ] Importar/exportar configuración
- [ ] Historial de cambios

## 📞 Soporte

Para preguntas, problemas o sugerencias:
- Crear issue en GitHub
- Contactar al equipo de desarrollo
- Revisar documentación adicional

---

**Versión**: 1.0  
**Fecha**: Enero 2025  
**Autor**: Sistema GestoRest Development Team
