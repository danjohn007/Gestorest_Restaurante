# 🔔 Sistema de Alertas de Pedidos - Guía Visual

## Vista Previa de la Alerta

Cuando se crea un nuevo pedido, los usuarios con rol de **Administrador** o **Cajero** verán lo siguiente en la parte superior de su dashboard:

```
╔════════════════════════════════════════════════════════════════════╗
║                      🏠 Sistema GestoRest                           ║
║        Dashboard | Pedidos | Layout de Mesas | Tickets            ║
╠════════════════════════════════════════════════════════════════════╣
║                                                                     ║
║  ┏━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┓  ║
║  ┃  🔔  ¡Nuevo Pedido Recibido!                            ❌  ┃  ║
║  ┃                                                              ┃  ║
║  ┃  Pedido #214 - Mesa 1                                       ┃  ║
║  ┃  👤 Enoc Estrada Resendiz | 🕐 13:33:32 | 📋 4 items        ┃  ║
║  ┃                                                              ┃  ║
║  ┃                              [ 👁️  Ver Pedido ]  ◄━━━━━━━━  ┃  ║
║  ┗━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━┛  ║
║                                                                     ║
║  📊 Quick Stats Cards                                              ║
║  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐           ║
║  │ Total Mesas  │  │ Ventas       │  │ Pedidos      │           ║
║  │    24        │  │ $490.00      │  │   3          │           ║
║  └──────────────┘  └──────────────┘  └──────────────┘           ║
║                                                                     ║
╚════════════════════════════════════════════════════════════════════╝
```

## 🎨 Elementos de la Alerta

### 1. Icono de Notificación 🔔
- Color: Amarillo/Naranja (#ffc107)
- Tamaño: Grande (2.5rem)
- Ubicación: Lado izquierdo

### 2. Título
- **"¡Nuevo Pedido Recibido!"**
- Font: Bold
- Icono de exclamación incluido

### 3. Información del Pedido
```
Pedido #214 - Mesa 1
└─ Formato: "Pedido #{ID} - {Ubicación}"
   Ubicación puede ser:
   - Mesa {número}
   - Para llevar
```

### 4. Detalles Adicionales
```
👤 Enoc Estrada Resendiz  |  🕐 13:33:32  |  📋 4 items
└─┬─────────────────────┘  └─┬─────────┘  └─┬────────┘
  │                          │              │
  Mesero asignado           Hora           Cantidad items
```

### 5. Botón de Acción
```
┌─────────────────┐
│ 👁️  Ver Pedido │  ← Botón principal
└─────────────────┘
   │
   ├─ Color: Amarillo (#ffc107)
   ├─ Tamaño: Grande (btn-lg)
   └─ Acción: Redirige a /orders/show/214
```

### 6. Botón de Cerrar
```
  ❌  ← Esquina superior derecha
  │
  └─ Acción: Cierra la alerta sin ver el pedido
```

## 🎵 Sonido de Notificación

### Características del Audio
```
Acorde Musical: Do Mayor (C Major)
┌─────────────────────────────────┐
│  Do (C5)  : 523.25 Hz           │
│  Mi (E5)  : 659.25 Hz           │
│  Sol (G5) : 783.99 Hz           │
└─────────────────────────────────┘

Patrón de Reproducción:
├─ Duración: 0.7 segundos
├─ Volumen: 15% (0.15)
├─ Forma: Suave (attack/decay)
├─ Repetición: Cada 3 segundos
└─ Detención: Al atender alerta
```

### Visualización de Onda
```
Amplitud
   │
15%┤   ╱╲
   │  ╱  ╲___
   │ ╱       ╲___
 0%├─────────────────► Tiempo
   0   0.05s  0.7s
   │   │      │
   │   │      └─ Fin del sonido
   │   └─ Máximo volumen
   └─ Inicio
```

## 🔄 Flujo de Interacción

### Escenario 1: Ver el Pedido
```
1. Usuario ve la alerta
        ↓
2. Hace clic en "Ver Pedido"
        ↓
3. Sonido se detiene inmediatamente
        ↓
4. Alerta desaparece con animación
        ↓
5. Redirige a página del pedido
        ↓
6. Sistema continúa monitoreando
```

### Escenario 2: Cerrar la Alerta
```
1. Usuario ve la alerta
        ↓
2. Hace clic en ❌
        ↓
3. Sonido se detiene
        ↓
4. Alerta desaparece
        ↓
5. Pedido sigue pendiente
        ↓
6. Sistema continúa monitoreando
```

### Escenario 3: Múltiples Alertas
```
Pedido A creado (13:33:32)
        ↓
┌───────────────────┐
│ Alerta A          │
│ Pedido #214       │
└───────────────────┘
        ↓
Pedido B creado (13:33:45)
        ↓
┌───────────────────┐
│ Alerta B          │ ← Nueva alerta aparece arriba
│ Pedido #215       │
├───────────────────┤
│ Alerta A          │ ← Alerta anterior se desplaza
│ Pedido #214       │
└───────────────────┘
        ↓
🎵 Sonido continúa hasta atender ambas
```

## 📱 Responsive Design

### Desktop (> 992px)
```
┌─────────────────────────────────────────┐
│         Alerta (max-width: 800px)       │
│              Centrada                    │
└─────────────────────────────────────────┘
```

### Tablet (768px - 992px)
```
┌───────────────────────────────────┐
│   Alerta (width: 90%)             │
│        Centrada                    │
└───────────────────────────────────┘
```

### Mobile (< 768px)
```
┌─────────────────────────────┐
│ Alerta (width: 90%)         │
│  Stacked Layout             │
│                             │
│  👤 Info                    │
│  [ Ver Pedido ]             │
└─────────────────────────────┘
```

## 🎬 Animaciones

### Entrada de Alerta (slideDown)
```
Frame 1 (0ms):     ▲ (invisible, -20px arriba)
Frame 2 (100ms):   ↑ (semi-transparente)
Frame 3 (200ms):   ↓ (más visible)
Frame 4 (300ms):   ▼ (100% visible, posición final)
```

### Salida de Alerta (slideUp)
```
Frame 1 (0ms):     ▼ (visible, posición actual)
Frame 2 (100ms):   ↓ (semi-transparente)
Frame 3 (200ms):   ↑ (menos visible)
Frame 4 (300ms):   ▲ (invisible, -20px arriba)
```

## 🎯 Posicionamiento

```
Viewport
┌────────────────────────────────────────┐
│  Navbar (fijo arriba)                  │ ← 0px
├────────────────────────────────────────┤
│                                        │
│         ⬇ 80px de margen               │
│                                        │
│  ┌──────────────────────────────────┐ │
│  │     Alerta (fixed, z-index: 9999) │ │
│  └──────────────────────────────────┘ │
│                                        │
│         Contenido Dashboard            │
│                                        │
└────────────────────────────────────────┘
```

## 💡 Tips de Uso

### Para Administradores
✅ Monitorear todas las alertas desde el dashboard
✅ Hacer clic rápidamente para ver detalles
✅ El sonido ayuda si estás en otra pestaña

### Para Cajeros
✅ Preparar la cuenta cuando veas la alerta
✅ Coordinar con meseros sobre nuevos pedidos
✅ Usar el botón "Ver Pedido" para detalles completos

## 🔧 Solución de Problemas

### No se escucha el sonido
**Causa**: Navegadores requieren interacción del usuario
**Solución**: Hacer clic en cualquier parte de la página

### Alerta no aparece
**Verificar**:
- ¿Eres Admin o Cajero?
- ¿Hay pedidos nuevos (últimos 10 segundos)?
- ¿La página está en primer plano?

### Sonido no se detiene
**Solución**: Hacer clic en ❌ o en "Ver Pedido"

---

**¿Preguntas?** Consulta:
- ALERT_SYSTEM_DOCUMENTATION.md (técnico)
- DEMO_ALERT_SYSTEM.md (funcional)
- IMPLEMENTATION_COMPLETE.md (resumen)
