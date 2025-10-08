# Guía Visual: Nuevos Símbolos y Duplicación

## Símbolos Disponibles

### Símbolos Originales

```
┌─────────────────────────────────────────────────────────────┐
│                   SÍMBOLOS ORIGINALES                       │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  1. 🚪 PUERTA                                               │
│     Color: Marrón (#8b4513)                                 │
│     Icono: bi-door-open                                     │
│     Uso: Marcar puertas/salidas                             │
│                                                             │
│  2. ➡️  ENTRADA                                             │
│     Color: Verde (#28a745)                                  │
│     Icono: bi-box-arrow-in-right                            │
│     Uso: Indicar entrada principal                          │
│                                                             │
│  3. 🥤 BARRA                                                │
│     Color: Rojo (#dc3545)                                   │
│     Icono: bi-cup-straw                                     │
│     Uso: Ubicación de la barra                              │
│                                                             │
│  4. 💰 CAJA                                                 │
│     Color: Amarillo (#ffc107)                               │
│     Icono: bi-cash-coin                                     │
│     Uso: Ubicación de la caja registradora                  │
│                                                             │
│  5. 🔥 COCINA                                               │
│     Color: Naranja (#fd7e14)                                │
│     Icono: bi-fire                                          │
│     Uso: Ubicación de la cocina                             │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

### Símbolos Nuevos

```
┌─────────────────────────────────────────────────────────────┐
│                     SÍMBOLOS NUEVOS                         │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│  6. 🌊 ALBERCA                                              │
│     Color: Cian (#17a2b8)                                   │
│     Icono: bi-water                                         │
│     Uso: Marcar área de alberca/piscina                     │
│                                                             │
│  7. 🌳 TERRAZA                                              │
│     Color: Gris (#6c757d)                                   │
│     Icono: bi-tree                                          │
│     Uso: Indicar área de terraza                            │
│                                                             │
│  8. 🏡 PATIO                                                │
│     Color: Verde menta (#20c997)                            │
│     Icono: bi-house-door                                    │
│     Uso: Marcar área de patio                               │
│                                                             │
│  9. 🚪 PUERTA 2                                             │
│     Color: Marrón (#8b4513)                                 │
│     Icono: bi-door-closed                                   │
│     Uso: Marcar puertas/salidas adicionales                 │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

## Interacción con Símbolos (Admin)

### Vista Normal del Símbolo

```
┌────────────────┐
│                │
│      🚪        │
│    PUERTA      │
│                │
└────────────────┘
```

### Vista al Pasar el Cursor (Hover)

```
┌────────────────┐
│                │
│      🚪        │  ← Símbolo se agranda levemente
│    PUERTA      │
│                │
└────────────────┘
     ↓ ↓ ↓
┌──────────────┐
│ 📋 Duplicar  │ 🗑️ Eliminar │
└──────────────┘
```

## Flujo de Duplicación

### Paso 1: Estado Inicial
```
Layout antes de duplicar:

┌─────────────────────────────────────────┐
│  🚪 PUERTA                              │
│                                         │
│                                         │
│                                         │
│                                         │
└─────────────────────────────────────────┘
```

### Paso 2: Click en "Duplicar"
```
Se solicita confirmación:

┌──────────────────────────────────┐
│  ¿Desea duplicar este símbolo?   │
│                                  │
│     [Cancelar]    [Aceptar]      │
└──────────────────────────────────┘
```

### Paso 3: Símbolo Duplicado Creado
```
Layout después de duplicar:

┌─────────────────────────────────────────┐
│  🚪 PUERTA        🚪 PUERTA 2           │
│                      ↖ +30px offset     │
│                                         │
│                                         │
│                                         │
└─────────────────────────────────────────┘
```

### Paso 4: Reposicionar y Guardar
```
Admin arrastra el nuevo símbolo:

┌─────────────────────────────────────────┐
│  🚪 PUERTA                              │
│                                         │
│                                         │
│                          🚪 PUERTA 2    │
│                                         │
└─────────────────────────────────────────┘
           ↓
    [Guardar Layout]
```

## Flujo de Eliminación

### Paso 1: Hover sobre Símbolo Duplicado
```
┌────────────────┐
│      🚪        │
│   PUERTA 2     │  ← Este es un duplicado
└────────────────┘
     ↓ ↓ ↓
│ 📋 Duplicar │ 🗑️ Eliminar │
```

### Paso 2: Click en "Eliminar"
```
Se solicita confirmación:

┌────────────────────────────────────────────┐
│  ¿Está seguro de que desea eliminar       │
│  este símbolo? Esta acción no se puede    │
│  deshacer.                                │
│                                           │
│       [Cancelar]    [Eliminar]            │
└────────────────────────────────────────────┘
```

### Paso 3: Símbolo Eliminado
```
Layout después de eliminar:

┌─────────────────────────────────────────┐
│  🚪 PUERTA                              │
│                                         │
│                                         │
│                            [eliminado]  │
│                                         │
└─────────────────────────────────────────┘
```

### Protección: No se Puede Eliminar el Último
```
Intento de eliminar el último símbolo de un tipo:

┌────────────────┐
│      🚪        │
│    PUERTA      │  ← Este es el único
└────────────────┘
     ↓ ↓ ↓
│ 📋 Duplicar │ 🗑️ Eliminar │
                      ↓
                   [Click]
                      ↓
┌────────────────────────────────────────────┐
│  ❌ Error al eliminar símbolo:             │
│  Cannot delete this symbol. At least one  │
│  of each type must remain.                │
│                                           │
│                [Aceptar]                  │
└────────────────────────────────────────────┘
```

## Ejemplo Completo: Restaurante con Múltiples Áreas

```
┌───────────────────────────────────────────────────────────────────┐
│ 🗺️  LAYOUT DE MESAS                          [Guardar Layout]   │
├───────────────────────────────────────────────────────────────────┤
│                                                                   │
│  🚪 ENTRADA      ➡️                    🔥                         │
│  PRINCIPAL     ENTRADA               COCINA                       │
│                                                                   │
│                                                                   │
│    🟢 Mesa 1    🟢 Mesa 2                                         │
│    👥 4         👥 2          🥤                                  │
│                              BARRA                                │
│    🟢 Mesa 3    🔴 Mesa 4                                         │
│    👥 6         👥 4           │                                  │
│                               │                                   │
│  ══════════════════════════════════════════                       │
│                                           │                       │
│  🌳 TERRAZA                               │   💰                  │
│                                           │  CAJA                 │
│    🟢 Mesa 5    🟢 Mesa 6    🟡 Mesa 7    │                       │
│    👥 4         👥 4         👥 2         │                       │
│                                           │                       │
│                                     🚪    │                       │
│                                  SALIDA   │                       │
│                                    A      │                       │
│  🏡 PATIO                          │      │                       │
│                                    │      │                       │
│    🟢 Mesa 8    🟢 Mesa 9    🌊   ▼      │                       │
│    👥 6         👥 8        ALBERCA       │                       │
│                                           │                       │
└───────────────────────────────────────────────────────────────────┘

Leyenda:
🟢 = Mesa Disponible
🔴 = Mesa Ocupada
🟡 = Cuenta Solicitada
👥 = Capacidad de personas
══ = Separador visual (área diferente)
```

## Beneficios de las Nuevas Funcionalidades

### 1. Flexibilidad
- Puedes agregar tantos símbolos como necesites
- Cada restaurante puede configurar su layout único
- Fácil de adaptar a cambios en el espacio físico

### 2. Claridad Visual
- Símbolos con colores distintivos
- Fácil identificación de diferentes áreas
- Mejor orientación para el personal

### 3. Facilidad de Gestión
- Duplicación con un solo clic
- Eliminación segura con protecciones
- Cambios se guardan inmediatamente

### 4. Casos de Uso Reales
- Restaurantes con múltiples entradas/salidas
- Espacios con áreas exteriores (terraza, patio, alberca)
- Configuraciones complejas con múltiples zonas

## Notas Importantes

⚠️ **Solo Administradores**
- Solo usuarios con rol de administrador pueden duplicar y eliminar símbolos
- Los meseros y cajeros pueden ver los símbolos pero no modificarlos

🔒 **Protección de Datos**
- No se puede eliminar el último símbolo de cada tipo
- Los cambios se guardan en la base de datos
- Cada símbolo duplicado tiene un ID único

💾 **Guardar Cambios**
- Después de duplicar o eliminar, recuerde hacer clic en "Guardar Layout"
- Los cambios se aplican a todos los usuarios del sistema
- La página se recarga automáticamente después de duplicar o eliminar

## Solución de Problemas

### No veo los botones de Duplicar/Eliminar
✓ Verifique que está conectado como administrador
✓ Pase el cursor sobre el símbolo para que aparezcan los botones

### No puedo eliminar un símbolo
✓ Verifique que no sea el último símbolo de ese tipo
✓ El sistema protege contra la eliminación del último símbolo de cada tipo

### Los nuevos símbolos no aparecen
✓ Ejecute la migración: `php apply_additional_symbols_migration.php`
✓ Verifique que los símbolos existan en la base de datos
✓ Recargue la página del layout
