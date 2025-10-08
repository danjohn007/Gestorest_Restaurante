# Plan de Pruebas - Mejoras UI Sistema Restaurante

## 🎯 Objetivo
Verificar que todas las funcionalidades implementadas funcionan correctamente según los requerimientos.

---

## 📋 Pre-requisitos

- [ ] Base de datos actualizada con migración `migration_table_layout.sql`
- [ ] Servidor web corriendo (Apache/Nginx + PHP 7.4+)
- [ ] Usuarios de prueba creados (Admin, Mesero, Cajero)
- [ ] Navegador moderno (Chrome, Firefox, Safari, Edge)
- [ ] Cache del navegador limpiado

---

## 🧪 Suite de Pruebas

### Test Suite 1: Imágenes de Platillos

**Objetivo:** Verificar que no aparece ícono duplicado debajo de imágenes

#### Test 1.1: Imagen válida de platillo
**Pasos:**
1. Login como cualquier usuario
2. Ir a "Crear Pedido"
3. Buscar platillos con imagen

**Resultado esperado:**
- ✅ Solo se muestra la imagen del platillo
- ✅ NO hay ícono `bi-image` debajo de la imagen
- ✅ Vista limpia y profesional

**Criterios de éxito:**
- [ ] Imagen se carga correctamente
- [ ] No hay elementos duplicados visuales
- [ ] Espaciado correcto alrededor de la imagen

#### Test 1.2: Platillo sin imagen
**Pasos:**
1. Buscar platillo sin imagen asignada

**Resultado esperado:**
- ✅ Se muestra placeholder con ícono de imagen
- ✅ Placeholder tiene dimensiones correctas (70x70px)
- ✅ Ícono centrado y visible

**Criterios de éxito:**
- [ ] Placeholder visible
- [ ] Ícono centrado
- [ ] Color gris claro apropiado

---

### Test Suite 2: Botón Flotante de Confirmación

**Objetivo:** Verificar comportamiento del botón flotante

#### Test 2.1: Botón con carrito vacío
**Pasos:**
1. Login como mesero
2. Ir a "Crear Pedido"
3. NO agregar platillos

**Resultado esperado:**
- ✅ Botón flotante NO visible
- ✅ No hay elementos flotantes en pantalla

**Criterios de éxito:**
- [ ] `fixedConfirmBar` tiene `display: none`
- [ ] Ningún elemento bloqueando vista inferior

#### Test 2.2: Botón con items en carrito
**Pasos:**
1. Agregar 1 platillo (Ej: Tacos $50.00)
2. Verificar botón flotante

**Resultado esperado:**
- ✅ Botón flotante aparece en parte inferior
- ✅ Muestra total: "$50.00"
- ✅ Texto: "CONFIRMAR PEDIDO"
- ✅ Botón verde con ícono

**Criterios de éxito:**
- [ ] Botón visible
- [ ] Total correcto
- [ ] Fixed position
- [ ] z-index: 1000
- [ ] Fondo blanco con sombra

#### Test 2.3: Actualización de total
**Pasos:**
1. Agregar Tacos $50.00
2. Agregar Hamburguesa $80.00
3. Verificar total

**Resultado esperado:**
- ✅ Total actualizado a "$130.00"
- ✅ Actualización instantánea
- ✅ Sin recargar página

**Criterios de éxito:**
- [ ] Total = $130.00
- [ ] Actualización en tiempo real
- [ ] Formato correcto ($XXX.XX)

#### Test 2.4: Scroll con botón flotante
**Pasos:**
1. Agregar varios platillos
2. Hacer scroll hacia arriba y abajo

**Resultado esperado:**
- ✅ Botón siempre visible en parte inferior
- ✅ No se mueve con el scroll
- ✅ Siempre accesible

**Criterios de éxito:**
- [ ] Position: fixed
- [ ] Visible en todo momento
- [ ] No interfiere con contenido

#### Test 2.5: Click en botón flotante
**Pasos:**
1. Agregar platillos
2. Click en "CONFIRMAR PEDIDO"

**Resultado esperado:**
- ✅ Envía el formulario
- ✅ Crea el pedido
- ✅ Redirige correctamente

**Criterios de éxito:**
- [ ] Form submit ejecutado
- [ ] Pedido creado en BD
- [ ] Redirección exitosa

---

### Test Suite 3: Búsqueda por Categoría

**Objetivo:** Verificar que búsqueda respeta categoría seleccionada

#### Test 3.1: Búsqueda con "Todas" las categorías
**Pasos:**
1. Ir a "Crear Pedido"
2. Categoría: "Todas" (activa por defecto)
3. Buscar: "pollo"

**Resultado esperado:**
- ✅ Muestra todos los platillos con "pollo"
- ✅ Busca en todas las categorías
- ✅ Resultados: Entradas, Platos Fuertes, etc.

**Criterios de éxito:**
- [ ] Al menos 3 categorías en resultados
- [ ] Todos los matches incluidos
- [ ] Headers de categorías visibles

#### Test 3.2: Búsqueda con categoría específica
**Pasos:**
1. Seleccionar categoría: "Platos Fuertes"
2. Buscar: "pollo"

**Resultado esperado:**
- ✅ Solo muestra platillos de "Platos Fuertes"
- ✅ NO muestra platillos de otras categorías
- ✅ Resultados filtrados correctamente

**Criterios de éxito:**
- [ ] Solo 1 categoría en resultados
- [ ] Matches solo de categoría seleccionada
- [ ] Otras categorías ocultas

#### Test 3.3: Cambiar categoría con búsqueda activa
**Pasos:**
1. Categoría: "Todas"
2. Buscar: "taco"
3. Cambiar a: "Entradas"

**Resultado esperado:**
- ✅ Resultados actualizados automáticamente
- ✅ Solo muestra "tacos" de "Entradas"
- ✅ Búsqueda se mantiene activa

**Criterios de éxito:**
- [ ] Actualización automática
- [ ] Filtro combinado funciona
- [ ] Query de búsqueda se mantiene

#### Test 3.4: Limpiar búsqueda con categoría activa
**Pasos:**
1. Categoría: "Bebidas"
2. Buscar: "refresco"
3. Limpiar búsqueda (X)

**Resultado esperado:**
- ✅ Muestra todos los platillos de "Bebidas"
- ✅ NO muestra otras categorías
- ✅ Filtro de categoría se mantiene

**Criterios de éxito:**
- [ ] Solo categoría "Bebidas" visible
- [ ] Todos los items de la categoría
- [ ] Input de búsqueda limpio

---

### Test Suite 4: Layout de Mesas (Administrador)

**Objetivo:** Verificar funcionalidad completa para admin

#### Test 4.1: Acceso al layout
**Pasos:**
1. Login como Admin
2. Ir a "Gestión de Mesas"
3. Buscar botón "LAYOUT"

**Resultado esperado:**
- ✅ Botón "LAYOUT" visible (azul)
- ✅ Ícono `bi-diagram-3`
- ✅ Click redirige a `/tables/layout`

**Criterios de éxito:**
- [ ] Botón presente
- [ ] Color correcto (outline-info)
- [ ] Redirección funciona

#### Test 4.2: Vista del layout
**Pasos:**
1. Acceder al layout
2. Observar contenido

**Resultado esperado:**
- ✅ Área de trabajo con grid visual
- ✅ Todas las mesas mostradas
- ✅ Controles de dimensiones visibles
- ✅ Botones "Guardar" y "Resetear" visibles

**Criterios de éxito:**
- [ ] Grid de fondo visible
- [ ] Mesas renderizadas
- [ ] Controles de admin presentes
- [ ] Layout con dimensiones correctas

#### Test 4.3: Drag & Drop básico
**Pasos:**
1. Seleccionar Mesa 1
2. Arrastrar a nueva posición
3. Soltar

**Resultado esperado:**
- ✅ Mesa se mueve con cursor
- ✅ Mesa se coloca en nueva posición
- ✅ Snap to grid (cada 10px)

**Criterios de éxito:**
- [ ] Mesa draggable
- [ ] Cursor cambia a "move"
- [ ] Posición actualizada
- [ ] Alineación automática

#### Test 4.4: Drag & Drop con límites
**Pasos:**
1. Intentar arrastrar mesa fuera del área
2. Soltar

**Resultado esperado:**
- ✅ Mesa se mantiene dentro del área
- ✅ No se sale de los límites
- ✅ Posición válida

**Criterios de éxito:**
- [ ] x >= 0
- [ ] x <= width - 80
- [ ] y >= 0
- [ ] y <= height - 80

#### Test 4.5: Guardar layout
**Pasos:**
1. Mover varias mesas
2. Click en "Guardar Layout"
3. Esperar respuesta

**Resultado esperado:**
- ✅ Alert: "Layout guardado exitosamente"
- ✅ Posiciones persistidas en BD
- ✅ Sin errores

**Criterios de éxito:**
- [ ] Request POST exitoso
- [ ] Response JSON: `{success: true}`
- [ ] BD actualizada (verificar en MySQL)

#### Test 4.6: Recargar y verificar
**Pasos:**
1. Después de guardar
2. Refrescar página (F5)
3. Observar posiciones

**Resultado esperado:**
- ✅ Mesas en mismas posiciones
- ✅ Layout se recupera de BD
- ✅ Sin cambios visuales

**Criterios de éxito:**
- [ ] Posiciones idénticas
- [ ] Datos cargados de BD
- [ ] No hay resets

#### Test 4.7: Resetear posiciones
**Pasos:**
1. Click en "Resetear Posiciones"
2. Confirmar diálogo
3. Observar resultado

**Resultado esperado:**
- ✅ Mesas reorganizadas en rejilla
- ✅ Distribución uniforme
- ✅ 11 columnas, múltiples filas

**Criterios de éxito:**
- [ ] Grid automático aplicado
- [ ] Espaciado de 100px
- [ ] Inicio en (50, 50)

#### Test 4.8: Ajustar dimensiones
**Pasos:**
1. Cambiar ancho a 1500px
2. Cambiar alto a 900px
3. Click "Aplicar"

**Resultado esperado:**
- ✅ Área redimensionada
- ✅ Dimensiones aplicadas
- ✅ Grid redibujado

**Criterios de éxito:**
- [ ] width = 1500px
- [ ] height = 900px
- [ ] Área visible completa

---

### Test Suite 5: Layout de Mesas (Mesero)

**Objetivo:** Verificar funcionalidad limitada para mesero

#### Test 5.1: Acceso al layout
**Pasos:**
1. Login como Mesero
2. Ir a "Consultar Mesas"
3. Buscar botón "Ver Layout"

**Resultado esperado:**
- ✅ Botón "Ver Layout" visible
- ✅ Click redirige a `/tables/layout`

**Criterios de éxito:**
- [ ] Botón presente
- [ ] Texto correcto
- [ ] Redirección funciona

#### Test 5.2: Vista de solo lectura
**Pasos:**
1. Acceder al layout como mesero
2. Intentar arrastrar mesa

**Resultado esperado:**
- ✅ Alert: "Vista de solo lectura"
- ✅ Mesas NO draggables
- ✅ Sin controles de edición

**Criterios de éxito:**
- [ ] draggable="false"
- [ ] cursor: pointer (no move)
- [ ] Botones de admin ocultos

#### Test 5.3: Click en mesa para pedido
**Pasos:**
1. Click en Mesa 5
2. Confirmar diálogo

**Resultado esperado:**
- ✅ Diálogo: "¿Crear pedido para Mesa 5?"
- ✅ Redirige a crear pedido
- ✅ Mesa pre-seleccionada

**Criterios de éxito:**
- [ ] Confirm dialog mostrado
- [ ] URL: `/orders/create?table_id=5`
- [ ] Select pre-poblado

#### Test 5.4: Colores de estado
**Pasos:**
1. Observar mesas en layout
2. Identificar colores

**Resultado esperado:**
- ✅ Verde = Disponible
- ✅ Rojo = Ocupada
- ✅ Amarillo = Cuenta solicitada

**Criterios de éxito:**
- [ ] Colores claramente distinguibles
- [ ] Leyenda visible
- [ ] Estados correctos

---

### Test Suite 6: Base de Datos

**Objetivo:** Verificar cambios en estructura de BD

#### Test 6.1: Campos agregados
**Pasos:**
1. Ejecutar query:
```sql
DESCRIBE tables;
```

**Resultado esperado:**
- ✅ Campo `position_x` existe (INT, NULL)
- ✅ Campo `position_y` existe (INT, NULL)

**Criterios de éxito:**
- [ ] position_x: INT, DEFAULT NULL
- [ ] position_y: INT, DEFAULT NULL
- [ ] Ambos permiten NULL

#### Test 6.2: Índice creado
**Pasos:**
1. Ejecutar query:
```sql
SHOW INDEXES FROM tables;
```

**Resultado esperado:**
- ✅ Índice `idx_tables_position` existe
- ✅ Columnas: (position_x, position_y)

**Criterios de éxito:**
- [ ] Index presente
- [ ] Tipo: INDEX (no UNIQUE)
- [ ] Columnas correctas

#### Test 6.3: Datos existentes
**Pasos:**
1. Ejecutar query:
```sql
SELECT id, number, position_x, position_y FROM tables;
```

**Resultado esperado:**
- ✅ Mesas existentes tienen position NULL
- ✅ No hay errores
- ✅ Estructura válida

**Criterios de éxito:**
- [ ] Queries ejecutan sin error
- [ ] NULL en posiciones es válido
- [ ] IDs preservados

---

## 📊 Matriz de Compatibilidad

### Navegadores

| Navegador | Versión | Test 1 | Test 2 | Test 3 | Test 4 | Test 5 |
|-----------|---------|--------|--------|--------|--------|--------|
| Chrome | 120+ | [ ] | [ ] | [ ] | [ ] | [ ] |
| Firefox | 120+ | [ ] | [ ] | [ ] | [ ] | [ ] |
| Safari | 17+ | [ ] | [ ] | [ ] | [ ] | [ ] |
| Edge | 120+ | [ ] | [ ] | [ ] | [ ] | [ ] |

### Dispositivos

| Dispositivo | Resolución | Test 1 | Test 2 | Test 3 | Test 4 | Test 5 |
|-------------|-----------|--------|--------|--------|--------|--------|
| Desktop | 1920x1080 | [ ] | [ ] | [ ] | [ ] | [ ] |
| Laptop | 1366x768 | [ ] | [ ] | [ ] | [ ] | [ ] |
| Tablet | 1024x768 | [ ] | [ ] | [ ] | [ ] | [ ] |

---

## 🐛 Registro de Bugs

### Bug Template
```
**Bug ID:** 
**Severidad:** (Crítico/Alto/Medio/Bajo)
**Test Fallido:** 
**Descripción:** 
**Pasos para reproducir:**
1. 
2. 
3. 
**Resultado esperado:**
**Resultado actual:**
**Screenshot:** (si aplica)
**Navegador/OS:**
```

---

## ✅ Checklist Final

### Preparación
- [ ] Base de datos actualizada
- [ ] Cache limpiado
- [ ] Usuarios de prueba creados
- [ ] Datos de prueba cargados

### Ejecución
- [ ] Test Suite 1: Imágenes (4 tests)
- [ ] Test Suite 2: Botón flotante (5 tests)
- [ ] Test Suite 3: Búsqueda (4 tests)
- [ ] Test Suite 4: Layout Admin (8 tests)
- [ ] Test Suite 5: Layout Mesero (4 tests)
- [ ] Test Suite 6: Base de datos (3 tests)

### Compatibilidad
- [ ] Chrome testado
- [ ] Firefox testado
- [ ] Safari testado
- [ ] Edge testado

### Documentación
- [ ] Tests documentados
- [ ] Bugs registrados (si hay)
- [ ] Screenshots tomados
- [ ] Resultados compilados

---

## 📈 Criterios de Aceptación

**Para aprobar el PR, se requiere:**
- ✅ 100% de tests pasados
- ✅ 0 bugs críticos o altos
- ✅ Compatible con 3+ navegadores
- ✅ Performance aceptable (<2s carga)
- ✅ Documentación completa

---

## 📞 Reportar Resultados

Después de completar los tests:

1. Llenar la matriz de compatibilidad
2. Documentar cualquier bug encontrado
3. Tomar screenshots de características clave
4. Compilar reporte final
5. Aprobar o rechazar PR según criterios

---

**Plan preparado por:** GitHub Copilot Agent  
**Última actualización:** Diciembre 2024  
**Versión:** 1.0  
**Total de tests:** 28
