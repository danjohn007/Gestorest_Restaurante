# 🎨 Demostración Visual - Zonas en Layout de Mesas

## Vista General del Layout con Zonas

```
┌─────────────────────────────────────────────────────────────────────────────┐
│ 🏠 Layout de Mesas                                    [← Volver a Mesas]   │
├─────────────────────────────────────────────────────────────────────────────┤
│                                                                             │
│  📋 CONTROLES (Solo Admin)                                                  │
│  ┌────────────────────────────────────────────────────────────────────┐    │
│  │ Ancho: [1200] px  Alto: [800] px  [Aplicar]                        │    │
│  │ [Guardar Layout] [Resetear Posiciones]                             │    │
│  │ 🟢 Disponible  🔴 Ocupada  🟡 Cuenta Solicitada                     │    │
│  └────────────────────────────────────────────────────────────────────┘    │
│                                                                             │
│  ┏━━━━━━━━━━━━━━━━━━━━━━━━━┓  ┏━━━━━━━━━━━━━━━━━━━━━━━┓                │
│  ┃ 📍 Salón                ┃  ┃ 📍 Terraza            ┃                │
│  ┃ (Azul claro trans.)     ┃  ┃ (Verde claro trans.)  ┃                │
│  ┃                         ┃  ┃                       ┃                │
│  ┃  ┌─────┐  ┌─────┐      ┃  ┃  ┌─────┐  ┌─────┐    ┃                │
│  ┃  │Mesa1│  │Mesa2│      ┃  ┃  │Mesa │  │Mesa │    ┃                │
│  ┃  │ 🟢 4│  │ 🔴 4│      ┃  ┃  │  10 │  │  11 │    ┃                │
│  ┃  └─────┘  └─────┘      ┃  ┃  │ 🟢 6│  │ 🟢 6│    ┃                │
│  ┃                         ┃  ┃  └─────┘  └─────┘    ┃                │
│  ┃  ┌─────┐  ┌─────┐      ┃  ┃                       ┃                │
│  ┃  │Mesa3│  │Mesa4│      ┃  ┃  🚪 PUERTA  🔥 COCINA ┃                │
│  ┃  │ 🟢 6│  │ 🟡 8│      ┃  ┃                  ◢    ┃                │
│  ┃  └─────┘  └─────┘ ◢    ┃  ┃                       ┃                │
│  ┗━━━━━━━━━━━━━━━━━━━━━━━━━┛  ┗━━━━━━━━━━━━━━━━━━━━━━━┛                │
│                                                                             │
│  ┏━━━━━━━━━━━━━━━━━━━━━━━━━┓  ┏━━━━━━━━━━━━━━━━━━━━━━━┓                │
│  ┃ 📍 Alberca              ┃  ┃ 📍 Spa                ┃                │
│  ┃ (Cian claro trans.)     ┃  ┃ (Morado claro trans.) ┃                │
│  ┃                         ┃  ┃                       ┃                │
│  ┃  ┌─────┐  ┌─────┐      ┃  ┃  ┌─────┐             ┃                │
│  ┃  │Mesa │  │Mesa │      ┃  ┃  │Mesa │             ┃                │
│  ┃  │  20 │  │  21 │      ┃  ┃  │  30 │             ┃                │
│  ┃  │ 🟢 4│  │ 🟢 4│      ┃  ┃  │ 🟢 2│             ┃                │
│  ┃  └─────┘  └─────┘ ◢    ┃  ┃  └─────┘        ◢    ┃                │
│  ┗━━━━━━━━━━━━━━━━━━━━━━━━━┛  ┗━━━━━━━━━━━━━━━━━━━━━━━┛                │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘

Leyenda:
━━━  = Borde de zona (punteado semitransparente)
◢    = Control de redimensionamiento (esquina inferior derecha)
🟢   = Mesa disponible
🔴   = Mesa ocupada  
🟡   = Cuenta solicitada
```

## Interacción con Zonas (Solo Administradores)

### 1. Mover una Zona

```
Estado Inicial:
┏━━━━━━━━━━━━━━━┓
┃ 📍 Salón       ┃
┃                ┃
┃  Mesa1  Mesa2  ┃
┃           ◢    ┃
┗━━━━━━━━━━━━━━━┛

     ↓ Arrastrar ↓

Estado Final:
        ┏━━━━━━━━━━━━━━━┓
        ┃ 📍 Salón       ┃
        ┃                ┃
        ┃  Mesa1  Mesa2  ┃
        ┃           ◢    ┃
        ┗━━━━━━━━━━━━━━━┛
```

### 2. Redimensionar una Zona

```
Estado Inicial:
┏━━━━━━━━━━━━━━━┓
┃ 📍 Terraza     ┃
┃                ┃
┃  Mesa10        ┃
┃           ◢    ┃
┗━━━━━━━━━━━━━━━┛

↓ Arrastrar control ◢ →

Estado Final:
┏━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 📍 Terraza             ┃
┃                        ┃
┃  Mesa10  Mesa11        ┃
┃                   ◢    ┃
┗━━━━━━━━━━━━━━━━━━━━━━━┛
```

## Ejemplo Real: Restaurante Multi-Zona

### Escenario: Restaurant "El Mirador"

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                                                                             │
│  ENTRADA PRINCIPAL ➡️                                                       │
│                                                                             │
│  ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓                                          │
│  ┃ 📍 Salón Principal          ┃         🚪 PUERTA COCINA               │
│  ┃ (Azul transparente)         ┃                                          │
│  ┃                             ┃         ┏━━━━━━━━━━━━━━━━━┓            │
│  ┃  Mesa Mesa Mesa Mesa         ┃         ┃ 🔥 Cocina       ┃            │
│  ┃   1    2    3    4          ┃         ┃ (Naranja trans.)┃            │
│  ┃  🟢   🔴   🟢   🟡          ┃         ┃                 ┃            │
│  ┃                             ┃         ┃   Prep. Area    ┃            │
│  ┃  Mesa Mesa Mesa Mesa         ┃         ┃                 ┃            │
│  ┃   5    6    7    8          ┃         ┗━━━━━━━━━━━━━━━━━┛            │
│  ┃  🟢   🟢   🟢   🔴          ┃                                          │
│  ┃                        ◢    ┃                                          │
│  ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛                                          │
│                                                                             │
│  💰 CAJA                                                                    │
│                                                                             │
│  ┏━━━━━━━━━━━━━━━━━━━━━━━┓     ┏━━━━━━━━━━━━━━━━━━━━━┓                │
│  ┃ 📍 Terraza            ┃     ┃ 📍 Bar              ┃                │
│  ┃ (Verde transparente)  ┃     ┃ (Rojo transparente) ┃                │
│  ┃                       ┃     ┃                     ┃                │
│  ┃  Mesa Mesa Mesa       ┃     ┃  🥤 BARRA          ┃                │
│  ┃   10   11   12       ┃     ┃  ┌─────────────┐   ┃                │
│  ┃  🟢   🟢   🟢       ┃     ┃  │   COUNTER   │   ┃                │
│  ┃                       ┃     ┃  └─────────────┘   ┃                │
│  ┃  Mesa Mesa            ┃     ┃                     ┃                │
│  ┃   13   14            ┃     ┃  Banquetas          ┃                │
│  ┃  🔴   🟡        ◢    ┃     ┃  🟢 🟢 🟢 🔴    ◢  ┃                │
│  ┗━━━━━━━━━━━━━━━━━━━━━━━┛     ┗━━━━━━━━━━━━━━━━━━━━━┛                │
│                                                                             │
└─────────────────────────────────────────────────────────────────────────────┘
```

### Descripción del Ejemplo

**Zona "Salón Principal" (Azul)**
- Posición: (50, 100)
- Tamaño: 500x300 px
- Contiene: 8 mesas de diferentes capacidades
- Color: #007bff con 15% opacidad

**Zona "Cocina" (Naranja)**
- Posición: (650, 100)
- Tamaño: 300x200 px
- Contiene: Área de preparación, símbolo de cocina
- Color: #fd7e14 con 15% opacidad

**Zona "Terraza" (Verde)**
- Posición: (50, 450)
- Tamaño: 400x250 px
- Contiene: 5 mesas al aire libre
- Color: #28a745 con 15% opacidad

**Zona "Bar" (Rojo)**
- Posición: (500, 450)
- Tamaño: 450x250 px
- Contiene: Barra, banquetas
- Color: #dc3545 con 15% opacidad

## Estados de Hover y Edición

### Vista Normal (Mesero/Cajero)
```
┏━━━━━━━━━━━━━━━┓
┃ 📍 Salón       ┃  ← Zona visible pero no editable
┃                ┃
┃  Mesa1  Mesa2  ┃
┃                ┃
┗━━━━━━━━━━━━━━━┛
```

### Vista Hover (Administrador)
```
┏━━━━━━━━━━━━━━━┓
┃ 📍 Salón    ⊞ ┃  ← Borde sólido en hover
┃                ┃  ← Botón de opciones (futuro)
┃  Mesa1  Mesa2  ┃
┃           ◢    ┃  ← Control de resize visible
┗━━━━━━━━━━━━━━━┛
```

### Vista Durante Arrastre (Administrador)
```
┏┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┓
┃ 📍 Salón       ┃  ← Opacidad reducida (60%)
┃                ┃  ← Indica que se está moviendo
┃  Mesa1  Mesa2  ┃
┃           ◢    ┃
┗┄┄┄┄┄┄┄┄┄┄┄┄┄┄┄┛
```

## Flujo de Trabajo Típico

### Configuración Inicial (Administrador)

```
1. Acceder al Layout
   ↓
2. Visualizar zonas por defecto
   ↓
3. Arrastrar zonas a posiciones deseadas
   ↓
4. Redimensionar zonas según necesidad
   ↓
5. Organizar mesas dentro de cada zona
   ↓
6. Guardar Layout
   ↓
7. Confirmar guardado exitoso
```

### Uso Diario (Mesero)

```
1. Abrir Layout de Mesas
   ↓
2. Identificar zona por color
   ↓
3. Localizar mesa específica
   ↓
4. Ver estado de la mesa
   ↓
5. Crear pedido o verificar ocupación
```

## Comparación: Antes vs Después

### ANTES (Sin Zonas Visuales)
```
┌──────────────────────────────┐
│ Layout de Mesas              │
├──────────────────────────────┤
│                              │
│  Mesa1  Mesa2  Mesa3         │
│  🟢    🔴    🟢             │
│                              │
│  Mesa4  Mesa5  Mesa6         │
│  🟡    🟢    🔴             │
│                              │
│  Mesa7  Mesa8  Mesa9         │
│  🟢    🟢    🟢             │
│                              │
└──────────────────────────────┘
```
❌ Difícil identificar áreas
❌ Sin contexto espacial
❌ No refleja distribución física

### DESPUÉS (Con Zonas Visuales)
```
┌──────────────────────────────┐
│ Layout de Mesas              │
├──────────────────────────────┤
│                              │
│ ┏━━━━━━━━━━┓  ┏━━━━━━━━━┓ │
│ ┃ Salón    ┃  ┃ Terraza ┃ │
│ ┃          ┃  ┃         ┃ │
│ ┃ Mesa1    ┃  ┃ Mesa7   ┃ │
│ ┃ Mesa2    ┃  ┃ Mesa8   ┃ │
│ ┃ Mesa3 ◢  ┃  ┃ Mesa9 ◢ ┃ │
│ ┗━━━━━━━━━━┛  ┗━━━━━━━━━┛ │
│                              │
│ ┏━━━━━━━━━━━━━━━━━━━━━━┓   │
│ ┃ Bar                  ┃   │
│ ┃ Mesa4 Mesa5 Mesa6    ┃   │
│ ┃                   ◢  ┃   │
│ ┗━━━━━━━━━━━━━━━━━━━━━━┛   │
└──────────────────────────────┘
```
✅ Zonas claramente definidas
✅ Colores distintivos
✅ Refleja distribución real
✅ Fácil orientación

## Características Visuales Detalladas

### 1. Transparencia de Colores
```
Opacidad del Fondo: 15%
Opacidad del Borde: 50%
Opacidad de Etiqueta: 70% (fondo blanco)

Ejemplo con color azul #007bff:
- Fondo: rgba(0, 123, 255, 0.15)
- Borde: rgba(0, 123, 255, 0.5)
- Texto: #007bff (sólido)
```

### 2. Capas Z-Index
```
Zonas (z-index: 1)
    ↑
Mesas (z-index: 2-999)
    ↑
Símbolos (z-index: 2-999)
    ↑
Zona en hover (z-index: 1000)
    ↑
Controles (z-index: 1001)
```

### 3. Animaciones
```
Hover: 0.2s transition
- Border: dashed → solid
- Box-shadow: none → visible
- Opacity controls: 0 → 1

Drag: Opacity change
- Normal: 100%
- Dragging: 60%
```

## Casos de Uso Avanzados

### Caso 1: Evento Especial
```
Configuración temporal para boda:

┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓
┃ 📍 Área Principal           ┃
┃ (Dorado - Evento especial)  ┃
┃                             ┃
┃  Mesa      Mesa      Mesa   ┃
┃  Novios    Padres    Amigos ┃
┃                             ┃
┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛
```

### Caso 2: Zonas Temporales
```
Durante brunch dominical:

┏━━━━━━━━━━━━━━━━━┓  ┏━━━━━━━━━━━━━━━━┓
┃ Buffet Salado   ┃  ┃ Buffet Dulce   ┃
┃ (Amarillo)      ┃  ┃ (Rosa)         ┃
┗━━━━━━━━━━━━━━━━━┛  ┗━━━━━━━━━━━━━━━━┛
```

### Caso 3: Zonas por Servicio
```
┏━━━━━━━━━━━━┓  ┏━━━━━━━━━━━┓  ┏━━━━━━━━━━━┓
┃ Desayuno   ┃  ┃ Comida    ┃  ┃ Cena      ┃
┃ 7am-11am   ┃  ┃ 1pm-5pm   ┃  ┃ 7pm-11pm  ┃
┃ (Naranja)  ┃  ┃ (Rojo)    ┃  ┃ (Morado)  ┃
┗━━━━━━━━━━━━┛  ┗━━━━━━━━━━━┛  ┗━━━━━━━━━━━┛
```

## Beneficios Visuales

✨ **Claridad Espacial**
- Comprensión inmediata de la distribución
- Identificación rápida de áreas
- Reducción de errores de ubicación

✨ **Comunicación Mejorada**
- Lenguaje visual común
- Código de colores intuitivo
- Referencia clara para nuevos empleados

✨ **Flexibilidad**
- Adaptación rápida a cambios
- Configuración personalizable
- Múltiples escenarios posibles

---

**Nota:** Esta visualización usa caracteres ASCII/Unicode para demostración. En el sistema real, las zonas se renderizan con CSS moderno, colores RGBA verdaderos y controles interactivos.
