# 🚀 Guía Rápida - Visualización de Zonas en Layout

## ⚡ Inicio Rápido (5 Minutos)

### Paso 1: Aplicar Migración (1 minuto)

```bash
cd /ruta/al/proyecto
php apply_zone_areas_migration.php
```

Salida esperada:
```
=== Aplicando migración de áreas de zona ===

Ejecutando: ALTER TABLE table_zones...
✓ Migración aplicada exitosamente
✓ Las zonas ahora tienen campos de posición y tamaño para el layout

=== Verificando zonas configuradas ===
- Salón: posición (100, 100), tamaño 450x300, color #007bff
- Terraza: posición (600, 100), tamaño 450x300, color #28a745
- Alberca: posición (100, 450), tamaño 450x250, color #17a2b8
- Spa: posición (600, 450), tamaño 450x250, color #6f42c1
- Room Service: posición (300, 300), tamaño 400x200, color #fd7e14
```

### Paso 2: Acceder al Layout (30 segundos)

1. Iniciar sesión como **Administrador**
2. Navegar a: **Gestión de Mesas** → **LAYOUT** (o menú principal → **Layout de Mesas**)
3. ✅ Las zonas ahora aparecen con colores transparentes

### Paso 3: Probar la Funcionalidad (3 minutos)

#### A. Mover una Zona
1. Hacer clic en una zona (área con color)
2. Arrastrar a nueva posición
3. Soltar
4. ✅ La zona se mueve

#### B. Redimensionar una Zona
1. Pasar cursor sobre esquina inferior derecha de zona
2. Aparece control de redimensionamiento (◢)
3. Arrastrar para ajustar tamaño
4. ✅ La zona cambia de tamaño

#### C. Guardar Cambios
1. Hacer clic en botón **"Guardar Layout"**
2. ✅ Mensaje de confirmación

## 📋 Verificación Rápida

### ¿Funcionó Correctamente?

✅ **Sí, si ves:**
- Áreas rectangulares con colores transparentes
- Nombres de zonas en esquina superior izquierda
- Control de redimensionamiento (◢) en esquina inferior derecha
- Puedes arrastrar y soltar zonas (solo admin)
- Puedes redimensionar zonas (solo admin)
- Cambios se guardan correctamente

❌ **No, si experimentas:**
- No se muestran las zonas
- Colores no son transparentes
- No puedes mover las zonas
- Errores al guardar

## 🔧 Solución de Problemas Comunes

### Problema 1: No se muestran las zonas
```bash
# Verificar que la migración se aplicó
mysql -u usuario -p nombre_bd -e "DESCRIBE table_zones;"

# Debe mostrar los campos: position_x, position_y, width, height
```

### Problema 2: Error al ejecutar migración
```bash
# Verificar conexión a base de datos
php -r "require 'config/database.php'; echo 'Conexión OK';"

# Si falla, revisar config/database.php
```

### Problema 3: No puedo mover zonas
- **Causa:** Usuario no es administrador
- **Solución:** Iniciar sesión con cuenta de administrador (ROLE_ADMIN)

### Problema 4: Cambios no se guardan
```bash
# Verificar permisos de escritura en base de datos
# Revisar logs del navegador (F12 → Console)
```

## 🎨 Personalización Rápida

### Cambiar Color de una Zona

1. Ir a: **Gestión de Mesas** → **Zonas**
2. Hacer clic en **"Editar"** de la zona deseada
3. Seleccionar nuevo color (selector de color)
4. Guardar
5. Refrescar layout (F5)
6. ✅ La zona ahora muestra el nuevo color

### Crear Nueva Zona

1. Ir a: **Gestión de Mesas** → **Zonas**
2. Hacer clic en **"Nueva Zona"**
3. Ingresar:
   - Nombre: ej. "VIP"
   - Color: ej. #FFD700 (dorado)
   - Descripción: ej. "Área VIP"
4. Guardar
5. Ir al Layout
6. ✅ Nueva zona aparece con posición por defecto (100, 100)
7. Mover y redimensionar según necesidad
8. Guardar layout

## 📊 Ejemplo Práctico: Configuración de Restaurant

### Escenario: Restaurant con 3 áreas principales

#### Paso 1: Crear/Verificar Zonas
```
Zona 1: Salón Principal - Azul (#007bff)
Zona 2: Terraza - Verde (#28a745)
Zona 3: Bar - Rojo (#dc3545)
```

#### Paso 2: Posicionar Zonas en Layout

```
Layout de 1200x800 px:

Salón Principal (Izquierda):
- Posición: (50, 50)
- Tamaño: 500x700

Terraza (Centro-Derecha):
- Posición: (600, 50)
- Tamaño: 550x350

Bar (Esquina Inferior Derecha):
- Posición: (600, 450)
- Tamaño: 550x300
```

#### Paso 3: Organizar Mesas en Cada Zona

1. Arrastrar mesas al área correspondiente
2. Las mesas se ven sobre el fondo transparente de la zona
3. Guardar layout

#### Resultado Visual:
```
┏━━━━━━━━━━━━┓  ┏━━━━━━━━━━━━━━━━━┓
┃ Salón      ┃  ┃ Terraza          ┃
┃ (Azul)     ┃  ┃ (Verde)          ┃
┃            ┃  ┗━━━━━━━━━━━━━━━━━┛
┃  Mesas     ┃  ┏━━━━━━━━━━━━━━━━━┓
┃  1-10      ┃  ┃ Bar              ┃
┃            ┃  ┃ (Rojo)           ┃
┗━━━━━━━━━━━━┛  ┗━━━━━━━━━━━━━━━━━┛
```

## 🎯 Casos de Uso Rápidos

### Uso 1: Identificar Área de Mesa
```
Mesero: "¿Dónde está la mesa 15?"
Layout: Mesa 15 está en zona VERDE (Terraza)
→ Mesero va directamente a la terraza
```

### Uso 2: Reorganizar para Evento
```
Administrador: Evento especial esta noche
1. Ajustar tamaño de zona VIP
2. Mover mesas dentro de zona VIP
3. Guardar layout temporal
4. Después del evento, revertir cambios
```

### Uso 3: Entrenamiento de Personal Nuevo
```
Trainer: "Las zonas de color ayudan a ubicarte"
- Azul = Salón principal (silencioso)
- Verde = Terraza (exterior)
- Rojo = Bar (animado)
→ Nuevo empleado aprende rápido
```

## 📈 Mejores Prácticas

### ✅ Hacer
- Usar colores contrastantes para zonas adyacentes
- Mantener nombres de zona cortos y descriptivos
- Guardar layout después de cada cambio importante
- Redimensionar zonas para que contengan todas las mesas del área

### ❌ Evitar
- Solapar zonas (hace confuso el layout)
- Usar colores muy similares
- Hacer zonas muy pequeñas (difícil de ver)
- Olvidar guardar cambios

## 🔄 Flujo de Trabajo Diario

### Administrador (Mañana)
1. Abrir layout
2. Verificar distribución
3. Ajustar si hay cambios
4. Guardar

### Mesero/Cajero (Durante Servicio)
1. Abrir layout
2. Identificar zona por color
3. Ubicar mesa
4. Crear/verificar pedido

## 📞 Soporte Rápido

### Si algo no funciona:

1. **Verificar Instalación**
   ```bash
   php apply_zone_areas_migration.php
   ```

2. **Revisar Logs**
   - Navegador: F12 → Console
   - Servidor: error_log

3. **Documentación Completa**
   - Ver: `ZONE_VISUALIZATION_GUIDE.md`
   - Ver: `ZONE_VISUALIZATION_DEMO.md`

## ⚡ Comandos Útiles

```bash
# Ver zonas configuradas
mysql -u usuario -p nombre_bd -e "SELECT name, color, position_x, position_y, width, height FROM table_zones WHERE active = 1;"

# Resetear posiciones de zonas (si es necesario)
mysql -u usuario -p nombre_bd -e "UPDATE table_zones SET position_x = 100, position_y = 100, width = 400, height = 300 WHERE active = 1;"

# Verificar sintaxis PHP
php -l views/tables/layout.php
```

## 🎉 ¡Listo!

Ahora tienes zonas visuales en tu layout de mesas. Las zonas ayudan a:
- ✅ Orientación espacial
- ✅ Identificación rápida de áreas
- ✅ Mejor comunicación de equipo
- ✅ Capacitación más efectiva

---

**Tiempo total de configuración:** ~5 minutos  
**Beneficio:** Mejora inmediata en organización visual del restaurante
