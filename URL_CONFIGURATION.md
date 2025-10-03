# Configuración URL para Contabot.digital

## 📍 **URL Base Configurada:**
- **Dominio**: `https://contabot.digital`
- **Subdirectorio**: `/administración/`
- **URL completa**: `https://contabot.digital/administración/`

## 🖼️ **Cómo se construyen las URLs de imágenes:**

### **Ejemplo de imagen almacenada:**
```
Base de datos: public/uploads/dishes/dish_67022d8f5a123_1728000000.jpg
```

### **URL final generada:**
```
https://contabot.digital/administración/public/uploads/dishes/dish_67022d8f5a123_1728000000.jpg
```

### **Fórmula:**
```
URL_COMPLETA = https://contabot.digital + BASE_URL + "/" + imagen_desde_BD
URL_COMPLETA = https://contabot.digital + /administración + "/" + public/uploads/dishes/archivo.jpg
```

## 🔧 **Configuración actual:**

### **En index.php:**
```php
define('BASE_URL', '/administración');
```

### **En las vistas:**
```php
<img src="<?= BASE_URL ?>/<?= htmlspecialchars($dish['image']) ?>">
```

### **Resultado final:**
```html
<img src="/administración/public/uploads/dishes/dish_67022d8f5a123_1728000000.jpg">
```

## ✅ **Para verificar:**

1. **Página de prueba**: `https://contabot.digital/administración/test_images.php`
2. **Gestión de platillos**: `https://contabot.digital/administración/dishes`
3. **Crear platillo**: `https://contabot.digital/administración/dishes/create`

## 🚨 **Puntos importantes:**

- El archivo .htaccess permite acceso directo a `/administración/public/uploads/`
- Las imágenes se almacenan físicamente en: `public/uploads/dishes/`
- La URL base `/administración` es relativa al dominio `contabot.digital`
- No necesitas cambiar nada más, la configuración actual es correcta