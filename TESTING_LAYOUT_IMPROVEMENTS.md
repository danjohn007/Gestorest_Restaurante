# Plan de Pruebas - Mejoras al Layout de Mesas

## Pre-requisitos

Antes de comenzar las pruebas, asegúrese de que:

1. ✅ La migración de base de datos ha sido aplicada
2. ✅ Tiene acceso a usuarios con diferentes roles:
   - Administrador
   - Mesero
   - Cajero
3. ✅ Hay mesas creadas en el sistema
4. ✅ El navegador tiene JavaScript habilitado

## 1. Aplicar Migración de Base de Datos

### Opción A: Script Automático
```bash
cd /ruta/al/proyecto
php apply_layout_symbols_migration.php
```

### Opción B: Manual (MySQL)
```bash
mysql -u usuario -p nombre_bd < database/migration_layout_symbols.sql
```

### Verificación
Ejecute en MySQL:
```sql
-- Verificar tabla
SHOW TABLES LIKE 'layout_symbols';

-- Verificar datos
SELECT * FROM layout_symbols;
```

**Resultado esperado**: 5 símbolos (puerta, entrada, barra, caja, cocina)

## 2. Pruebas de Navegación

### Test 2.1: Acceso Directo al Layout (Admin)
**Como**: Administrador  
**Pasos**:
1. Iniciar sesión como administrador
2. Verificar menú de navegación principal

**Resultado esperado**:
- ✅ Link "Layout de Mesas" visible en la barra de navegación
- ✅ Ícono de diagrama (bi-diagram-3) presente
- ✅ Link funciona al hacer clic

**Estado**: [ ] Passed / [ ] Failed

---

### Test 2.2: Acceso Directo al Layout (Mesero)
**Como**: Mesero  
**Pasos**:
1. Iniciar sesión como mesero
2. Verificar menú de navegación principal

**Resultado esperado**:
- ✅ Link "Layout de Mesas" visible
- ✅ Link funciona al hacer clic

**Estado**: [ ] Passed / [ ] Failed

---

### Test 2.3: Acceso Directo al Layout (Cajero)
**Como**: Cajero  
**Pasos**:
1. Iniciar sesión como cajero
2. Verificar menú de navegación principal

**Resultado esperado**:
- ✅ Link "Layout de Mesas" visible
- ✅ Link funciona al hacer clic

**Estado**: [ ] Passed / [ ] Failed

---

## 3. Pruebas de Visualización del Layout

### Test 3.1: Cargar Layout con Mesas
**Como**: Cualquier usuario autenticado  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Observar el área del layout

**Resultado esperado**:
- ✅ Todas las mesas se muestran
- ✅ Mesas tienen número visible
- ✅ Mesas muestran capacidad (ícono de personas + número)
- ✅ Colores de estado correctos:
  - Verde: Disponible
  - Rojo: Ocupada
  - Amarillo: Cuenta solicitada

**Estado**: [ ] Passed / [ ] Failed

---

### Test 3.2: Visualización de Símbolos
**Como**: Cualquier usuario autenticado  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Buscar los 5 símbolos en el layout

**Resultado esperado**:
- ✅ Símbolo PUERTA visible (ícono puerta, color marrón)
- ✅ Símbolo ENTRADA visible (ícono flecha, color verde)
- ✅ Símbolo BARRA visible (ícono vaso, color rojo)
- ✅ Símbolo CAJA visible (ícono dinero, color amarillo)
- ✅ Símbolo COCINA visible (ícono fuego, color naranja)

**Estado**: [ ] Passed / [ ] Failed

---

## 4. Pruebas de "Nuevo Pedido" desde Layout

### Test 4.1: Hover sobre Mesa
**Como**: Cualquier usuario autenticado  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Pasar el cursor sobre cualquier mesa
3. Esperar 0.2 segundos

**Resultado esperado**:
- ✅ Aparece botón "Nuevo Pedido" debajo de la mesa
- ✅ Botón tiene ícono de "plus-circle"
- ✅ Botón tiene fondo verde
- ✅ Botón desaparece al quitar el cursor

**Estado**: [ ] Passed / [ ] Failed

---

### Test 4.2: Clic en "Nuevo Pedido"
**Como**: Mesero  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Hover sobre "Mesa 1"
3. Hacer clic en "Nuevo Pedido"

**Resultado esperado**:
- ✅ Redirige a página de crear pedido
- ✅ Mesa 1 está preseleccionada en el dropdown de mesas
- ✅ URL contiene `?table_id=X`

**Estado**: [ ] Passed / [ ] Failed

---

### Test 4.3: Preselección de Mesa desde URL
**Como**: Cualquier usuario  
**Pasos**:
1. Navegar manualmente a `/orders/create?table_id=2`
2. Observar el campo "Mesa"

**Resultado esperado**:
- ✅ Mesa 2 está seleccionada automáticamente
- ✅ Dropdown muestra "Mesa 2"
- ✅ Puede cambiar a otra mesa si lo desea

**Estado**: [ ] Passed / [ ] Failed

---

## 5. Pruebas de Permisos (Admin)

### Test 5.1: Admin Puede Mover Mesas
**Como**: Administrador  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Intentar arrastrar una mesa a otra posición
3. Hacer clic en "Guardar Layout"

**Resultado esperado**:
- ✅ Mesa se puede arrastrar
- ✅ Mesa mantiene nueva posición al soltar
- ✅ Mensaje "Layout guardado exitosamente"
- ✅ Posición se mantiene al recargar página

**Estado**: [ ] Passed / [ ] Failed

---

### Test 5.2: Admin Puede Mover Símbolos
**Como**: Administrador  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Intentar arrastrar el símbolo "PUERTA" a otra posición
3. Hacer clic en "Guardar Layout"

**Resultado esperado**:
- ✅ Símbolo se puede arrastrar
- ✅ Símbolo mantiene nueva posición al soltar
- ✅ Mensaje "Layout guardado exitosamente"
- ✅ Posición se mantiene al recargar página

**Estado**: [ ] Passed / [ ] Failed

---

### Test 5.3: Admin Puede Cambiar Dimensiones
**Como**: Administrador  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Cambiar "Ancho" a 1500px
3. Cambiar "Alto" a 900px
4. Hacer clic en "Aplicar"

**Resultado esperado**:
- ✅ Área del layout cambia de tamaño inmediatamente
- ✅ Dimensiones se mantienen al guardar layout
- ✅ Dimensiones se mantienen al recargar página

**Estado**: [ ] Passed / [ ] Failed

---

### Test 5.4: Admin Puede Resetear Posiciones
**Como**: Administrador  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Mover algunas mesas a posiciones aleatorias
3. Hacer clic en "Resetear Posiciones"
4. Confirmar la acción

**Resultado esperado**:
- ✅ Todas las mesas se reorganizan en una rejilla
- ✅ Mesas se alinean automáticamente
- ✅ Espaciado uniforme entre mesas

**Estado**: [ ] Passed / [ ] Failed

---

## 6. Pruebas de Permisos (No-Admin)

### Test 6.1: Mesero NO Puede Mover Mesas
**Como**: Mesero  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Intentar arrastrar una mesa

**Resultado esperado**:
- ✅ Mesa NO se puede arrastrar
- ✅ Cursor cambia a "pointer" (no a "move")
- ✅ NO hay botones "Guardar Layout" ni "Resetear"
- ✅ NO hay controles de dimensiones

**Estado**: [ ] Passed / [ ] Failed

---

### Test 6.2: Mesero NO Puede Mover Símbolos
**Como**: Mesero  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Intentar arrastrar un símbolo

**Resultado esperado**:
- ✅ Símbolo NO se puede arrastrar
- ✅ Símbolos son solo visuales

**Estado**: [ ] Passed / [ ] Failed

---

### Test 6.3: Mesero Puede Crear Pedidos desde Layout
**Como**: Mesero  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Hacer clic en una mesa disponible
3. Confirmar crear pedido

**Resultado esperado**:
- ✅ Redirige a crear pedido
- ✅ Mesa preseleccionada
- ✅ Puede completar el pedido normalmente

**Estado**: [ ] Passed / [ ] Failed

---

## 7. Pruebas de Interfaz de Usuario

### Test 7.1: Responsividad - Desktop
**Como**: Cualquier usuario  
**Dispositivo**: Desktop (> 1200px)  
**Pasos**:
1. Abrir layout en pantalla grande
2. Observar diseño

**Resultado esperado**:
- ✅ Layout se ve completo sin scroll
- ✅ Mesas y símbolos tienen tamaño apropiado
- ✅ Controles visibles en la parte superior

**Estado**: [ ] Passed / [ ] Failed

---

### Test 7.2: Responsividad - Tablet
**Como**: Cualquier usuario  
**Dispositivo**: Tablet (768px - 1200px)  
**Pasos**:
1. Abrir layout en tablet o ajustar ventana
2. Observar diseño

**Resultado esperado**:
- ✅ Layout tiene scroll horizontal si es necesario
- ✅ Controles siguen siendo accesibles
- ✅ Hover/touch funciona correctamente

**Estado**: [ ] Passed / [ ] Failed

---

### Test 7.3: Efectos Hover
**Como**: Cualquier usuario  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Pasar cursor sobre varias mesas

**Resultado esperado**:
- ✅ Mesa hace zoom ligero (scale 1.05)
- ✅ Sombra se intensifica
- ✅ Botón "Nuevo Pedido" aparece
- ✅ Transición suave (0.2s)

**Estado**: [ ] Passed / [ ] Failed

---

## 8. Pruebas de Integración

### Test 8.1: Crear Pedido Completo desde Layout
**Como**: Mesero  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Hover sobre "Mesa 3"
3. Clic en "Nuevo Pedido"
4. Agregar platillos
5. Completar pedido

**Resultado esperado**:
- ✅ Mesa preseleccionada correctamente
- ✅ Pedido se crea exitosamente
- ✅ Estado de la mesa cambia a "Ocupada"
- ✅ Al regresar al layout, Mesa 3 está en rojo

**Estado**: [ ] Passed / [ ] Failed

---

### Test 8.2: Persistencia de Posiciones
**Como**: Administrador  
**Pasos**:
1. Mover 3 mesas a posiciones específicas
2. Mover 2 símbolos
3. Guardar layout
4. Cerrar sesión
5. Iniciar sesión de nuevo
6. Ir al layout

**Resultado esperado**:
- ✅ Todas las mesas mantienen sus posiciones
- ✅ Todos los símbolos mantienen sus posiciones
- ✅ Dimensiones del layout se mantienen

**Estado**: [ ] Passed / [ ] Failed

---

### Test 8.3: Layout Visible para Diferentes Roles
**Como**: Varios usuarios  
**Pasos**:
1. Admin configura layout con mesas y símbolos
2. Guarda configuración
3. Mesero accede al layout
4. Cajero accede al layout

**Resultado esperado**:
- ✅ Todos ven el mismo layout
- ✅ Todos ven las mismas posiciones de mesas
- ✅ Todos ven los mismos símbolos
- ✅ Solo admin puede modificar

**Estado**: [ ] Passed / [ ] Failed

---

## 9. Pruebas de Rendimiento

### Test 9.1: Carga con 50 Mesas
**Como**: Cualquier usuario  
**Pre-requisito**: Crear 50 mesas en el sistema  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Medir tiempo de carga

**Resultado esperado**:
- ✅ Página carga en menos de 3 segundos
- ✅ Todas las mesas se renderizan
- ✅ Drag and drop sigue siendo fluido

**Estado**: [ ] Passed / [ ] Failed

---

### Test 9.2: Guardar Layout con Muchas Mesas
**Como**: Administrador  
**Pre-requisito**: 50 mesas en el layout  
**Pasos**:
1. Mover 10 mesas
2. Mover 5 símbolos
3. Guardar layout
4. Medir tiempo de guardado

**Resultado esperado**:
- ✅ Guardado completa en menos de 2 segundos
- ✅ Mensaje de éxito aparece
- ✅ No hay errores en consola

**Estado**: [ ] Passed / [ ] Failed

---

## 10. Pruebas de Errores y Edge Cases

### Test 10.1: Layout sin Mesas
**Como**: Administrador  
**Pre-requisito**: Sistema sin mesas creadas  
**Pasos**:
1. Navegar a "Layout de Mesas"

**Resultado esperado**:
- ✅ Página carga sin errores
- ✅ Solo símbolos son visibles
- ✅ Mensaje informativo si corresponde

**Estado**: [ ] Passed / [ ] Failed

---

### Test 10.2: Guardar sin Cambios
**Como**: Administrador  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. No mover nada
3. Hacer clic en "Guardar Layout"

**Resultado esperado**:
- ✅ Guardado exitoso (o mensaje "Sin cambios")
- ✅ No hay errores

**Estado**: [ ] Passed / [ ] Failed

---

### Test 10.3: Error de Conexión al Guardar
**Como**: Administrador  
**Pre-requisito**: Simular error de red  
**Pasos**:
1. Navegar a "Layout de Mesas"
2. Mover una mesa
3. Desconectar red (o simular)
4. Intentar guardar

**Resultado esperado**:
- ✅ Mensaje de error claro
- ✅ No se pierde el trabajo realizado
- ✅ Puede reintentar al reconectar

**Estado**: [ ] Passed / [ ] Failed

---

## 11. Checklist de Compatibilidad de Navegadores

### Chrome/Edge (Chromium)
- [ ] Layout se renderiza correctamente
- [ ] Drag and drop funciona
- [ ] Hover effects funcionan
- [ ] Enlaces funcionan

### Firefox
- [ ] Layout se renderiza correctamente
- [ ] Drag and drop funciona
- [ ] Hover effects funcionan
- [ ] Enlaces funcionan

### Safari
- [ ] Layout se renderiza correctamente
- [ ] Drag and drop funciona
- [ ] Hover effects funcionan
- [ ] Enlaces funcionan

---

## Resumen de Resultados

### Estadísticas
- Total de pruebas: 28
- Pasadas: ___ / 28
- Falladas: ___ / 28
- Porcentaje de éxito: ___%

### Problemas Encontrados
1. 
2. 
3. 

### Recomendaciones
1. 
2. 
3. 

### Firma
**Probado por**: _________________  
**Fecha**: _________________  
**Ambiente**: Producción / Desarrollo / Staging  
**Versión del navegador**: _________________  
