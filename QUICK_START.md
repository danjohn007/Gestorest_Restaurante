# 🚀 Guía Rápida de Instalación

## Para poner en producción las nuevas funcionalidades

### 1️⃣ Aplicar Migración de Base de Datos (REQUERIDO)

```bash
# Opción 1: Desde línea de comandos
mysql -u usuario -p nombre_base_datos < database/migration_table_layout.sql

# Opción 2: Desde phpMyAdmin
# 1. Abrir phpMyAdmin
# 2. Seleccionar la base de datos
# 3. Ir a la pestaña "SQL"
# 4. Copiar y pegar el contenido de database/migration_table_layout.sql
# 5. Hacer clic en "Ejecutar"
```

### 2️⃣ Verificar Archivos Actualizados

Los siguientes archivos deben estar presentes en el servidor:

```
✅ views/orders/create.php (modificado)
✅ views/tables/index.php (modificado)
✅ views/tables/layout.php (NUEVO)
✅ controllers/TablesController.php (modificado)
✅ models/SystemSettings.php (modificado)
✅ database/migration_table_layout.sql (NUEVO)
```

### 3️⃣ Limpiar Caché

```bash
# En el servidor
# Limpiar caché de PHP (si aplica)
sudo service php-fpm restart

# Limpiar caché de Apache
sudo service apache2 restart

# En el navegador
# Ctrl + Shift + R (Windows/Linux)
# Cmd + Shift + R (Mac)
```

### 4️⃣ Configuración Inicial del Layout (Administrador)

1. Iniciar sesión como **Administrador**
2. Ir a **Gestión de Mesas**
3. Hacer clic en el botón **LAYOUT** (azul, con ícono de diagrama)
4. Ajustar dimensiones del área si es necesario
5. Arrastrar y soltar cada mesa a su posición deseada
6. Hacer clic en **Guardar Layout**
7. Confirmar que se guardó correctamente

### 5️⃣ Verificación Rápida

#### Test 1: Pedidos - Imagen de platillo
- [ ] Ir a **Crear Pedido**
- [ ] Verificar que las imágenes de platillos se ven limpias (sin ícono duplicado)

#### Test 2: Pedidos - Botón flotante
- [ ] En **Crear Pedido**, agregar platillos al carrito
- [ ] Verificar que aparece botón flotante en la parte inferior
- [ ] Verificar que muestra el total correcto
- [ ] Hacer scroll - el botón debe permanecer visible

#### Test 3: Pedidos - Búsqueda por categoría
- [ ] Seleccionar una categoría específica (ej: "Entradas")
- [ ] Buscar un término (ej: "pollo")
- [ ] Verificar que solo muestra resultados de la categoría seleccionada

#### Test 4: Layout - Vista de administrador
- [ ] Como admin, ir a **Layout**
- [ ] Arrastrar una mesa a nueva posición
- [ ] Hacer clic en **Guardar Layout**
- [ ] Refrescar página - verificar que posición se mantuvo

#### Test 5: Layout - Vista de mesero
- [ ] Como mesero, ir a **Ver Layout**
- [ ] Verificar que NO se pueden arrastrar mesas
- [ ] Hacer clic en una mesa
- [ ] Verificar que redirige a crear pedido

---

## 🆘 Solución de Problemas Comunes

### Problema: "Error al guardar layout"
**Solución:**
1. Verificar que la migración se aplicó correctamente
2. Verificar permisos del usuario en la base de datos
3. Revisar log de errores del servidor

### Problema: "Las mesas no se muestran en el layout"
**Solución:**
1. Verificar que existen mesas en la base de datos
2. Verificar que las mesas están activas (active = 1)
3. Revisar consola del navegador para errores JavaScript

### Problema: "El botón flotante no aparece"
**Solución:**
1. Limpiar caché del navegador (Ctrl + Shift + R)
2. Verificar que hay platillos agregados al carrito
3. Verificar que el archivo views/orders/create.php está actualizado

### Problema: "La búsqueda no filtra por categoría"
**Solución:**
1. Limpiar caché del navegador
2. Verificar que el archivo views/orders/create.php está actualizado
3. Verificar consola del navegador para errores JavaScript

---

## 📞 Contacto para Soporte

Si necesitas ayuda adicional:

1. **Revisar documentación completa:** `MEJORAS_UI_SISTEMA.md`
2. **Ver ejemplos visuales:** `VISUAL_SUMMARY.md`
3. **Verificar código:** Revisar commits en GitHub

---

## 📊 Checklist de Despliegue

Antes de considerar el despliegue completo:

- [ ] Migración de BD aplicada exitosamente
- [ ] Todos los archivos actualizados en el servidor
- [ ] Caché limpiado (servidor y navegador)
- [ ] Layout inicial configurado por administrador
- [ ] Test 1 (Imágenes) pasado
- [ ] Test 2 (Botón flotante) pasado
- [ ] Test 3 (Búsqueda) pasado
- [ ] Test 4 (Layout admin) pasado
- [ ] Test 5 (Layout mesero) pasado
- [ ] Usuario final notificado de nuevas funcionalidades

---

## 🎉 ¡Listo!

Una vez completados todos los pasos, las nuevas funcionalidades están disponibles para todos los usuarios del sistema.

### Funcionalidades Activas:
✅ Vista limpia de platillos sin íconos duplicados  
✅ Botón flotante de confirmación de pedidos  
✅ Búsqueda inteligente por categoría  
✅ Layout visual interactivo de mesas  
✅ Drag & Drop para administradores  
✅ Vista de solo lectura para meseros  

---

**Tiempo estimado de instalación:** 10-15 minutos  
**Dificultad:** Fácil ⭐⭐☆☆☆  
**Requiere reinicio del servidor:** Recomendado pero no obligatorio
