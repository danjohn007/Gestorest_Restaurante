# Implementación de Envío de Correos para Reservaciones

## Descripción
Este documento describe la implementación de la funcionalidad de envío de correos electrónicos para confirmación de reservaciones en el sistema de restaurante.

## Características Implementadas

### 1. Campo de Email en Formularios
- **Formulario Admin** (`/reservations/create`): Se agregó campo de email opcional
- **Formulario Público** (`/public/reservations`): Ya existía, ahora se procesa correctamente
- Validación de formato de email
- Campo opcional pero recomendado

### 2. Base de Datos
**Archivo de migración:** `database/migration_customer_email.sql`

```sql
-- Agregar columna email a tabla customers
ALTER TABLE customers 
ADD COLUMN email VARCHAR(255) NULL AFTER phone;

-- Agregar índice para búsquedas
CREATE INDEX idx_customers_email ON customers(email);
```

**Para aplicar la migración:**
```bash
# Desde línea de comandos MySQL
mysql -u usuario -p nombre_base_datos < database/migration_customer_email.sql

# O desde phpMyAdmin o cliente MySQL, ejecutar:
ALTER TABLE customers ADD COLUMN email VARCHAR(255) NULL AFTER phone;
CREATE INDEX idx_customers_email ON customers(email);
```

### 3. Plantilla de Email HTML
**Archivo:** `core/ReservationEmailTemplate.php`

- Diseño profesional responsive
- Formato HTML con estilos inline
- Compatible con la mayoría de clientes de correo
- Campos incluidos:
  - **Tipo:** "Reservación Restaurante" (como se solicitó)
  - **Cliente:** Nombre del cliente (no "Huésped")
  - **Email:** Email del cliente
  - **Teléfono:** Teléfono del cliente
  - **Recurso:** Mesa(s) asignada(s) o "Por asignar"
  - **Fecha:** Fecha de la reservación
  - **Hora:** Hora de la reservación
  - **Personas:** Número de comensales
  - **Estado:** Estado de la reservación
  - **Notas:** Notas especiales del cliente

### 4. Envío de Correos
**SmtpMailer mejorado** (`core/SmtpMailer.php`):
- Método `sendHtml()` agregado para emails HTML
- Soporte para CC (copia de correo)
- Mantiene compatibilidad con `sendPlainText()` existente

**Características del envío:**
- ✅ Email al cliente con los datos de la reservación
- ✅ Copia (CC) al correo remitente configurado en el sistema
- ✅ Formato HTML profesional
- ✅ Manejo de errores silencioso (no interrumpe el flujo si falla el email)
- ✅ Logs de errores para debugging

### 5. Flujo de Funcionamiento

#### Creación de Reservación (Admin)
1. Usuario completa formulario en `/reservations/create`
2. Se valida el email (opcional pero debe ser válido si se proporciona)
3. Se crea la reservación en la base de datos
4. Se guarda/actualiza el email en la tabla `customers`
5. **Se envía automáticamente el email de confirmación**
6. Redirección a la página de detalle de la reservación

#### Creación de Reservación (Público)
1. Cliente completa formulario en `/public/reservations`
2. Se valida el email (opcional pero debe ser válido si se proporciona)
3. Se crea la reservación en la base de datos
4. Se guarda/actualiza el email en la tabla `customers`
5. **Se envía automáticamente el email de confirmación**
6. Se muestra página de éxito

#### Confirmación de Reservación (Admin)
- Cuando se cambia el estado a "confirmada", también se envía email
- (Comportamiento existente mantenido)

## Archivos Modificados

### Nuevos Archivos
1. `database/migration_customer_email.sql` - Migración de base de datos
2. `core/ReservationEmailTemplate.php` - Plantilla HTML de email

### Archivos Modificados
1. `core/SmtpMailer.php`
   - Agregado método `sendHtml()`
   - Soporte para CC
   - Refactorizado método `send()` privado

2. `controllers/ReservationsController.php`
   - Validación de email en `validateReservationInput()`
   - Email agregado a `customerData` en `processCreate()`
   - Llamada a `sendReservationConfirmationEmail()` tras crear reservación
   - Método `sendReservationConfirmationEmail()` actualizado para usar HTML

3. `controllers/PublicController.php`
   - Email agregado a `customerData` en `processPublicReservation()`
   - Método `sendReservationConfirmationEmail()` duplicado (mismo que ReservationsController)
     - **Nota:** Código duplicado por simplicidad. En futuras mejoras, se recomienda extraer
       a un servicio compartido o clase base
   - Llamada al método tras crear reservación

4. `views/reservations/create.php`
   - Campo de email agregado después del teléfono
   - Mensaje de ayuda sobre confirmación por email

## Configuración Requerida

### SMTP
Para que los correos funcionen, el sistema debe tener configurados los siguientes parámetros en la sección "Configuración de Email" (en Settings):

- **smtp_host**: Servidor SMTP (ej: smtp.gmail.com)
- **smtp_port**: Puerto SMTP (ej: 587)
- **smtp_user**: Usuario SMTP
- **smtp_pass**: Contraseña SMTP
- **smtp_security**: Seguridad (TLS/SSL)
- **from_email**: Correo remitente (recibirá copia de cada reservación)
- **from_name**: Nombre del remitente (ej: "Rancho Paraíso Real")

### Opcional
- **Configuración de Contacto** (Settings > Contacto):
  - `email`: Email de contacto a mostrar en el correo
  - `website`: Sitio web a mostrar en el correo

## Pruebas

### Probar Email de Reservación

1. **Aplicar migración SQL:**
   ```sql
   ALTER TABLE customers ADD COLUMN email VARCHAR(255) NULL AFTER phone;
   CREATE INDEX idx_customers_email ON customers(email);
   ```

2. **Configurar SMTP** (Settings > Email)
   - Completar todos los campos SMTP
   - Usar "Enviar Correo de Prueba" para verificar configuración

3. **Crear Reservación con Email:**
   - Ir a `/reservations/create` o `/public/reservations`
   - Llenar formulario incluyendo un email válido
   - Crear reservación
   - Verificar:
     - ✅ Email recibido en la dirección del cliente
     - ✅ Copia recibida en el correo remitente configurado
     - ✅ Formato HTML correcto
     - ✅ Todos los datos de la reservación presentes
     - ✅ Tipo: "Reservación Restaurante"
     - ✅ Etiqueta: "Cliente" (no "Huésped")

4. **Verificar Logs** (si hay problemas):
   - Revisar logs de PHP en el servidor
   - Buscar mensajes que empiecen con:
     - `No se pudo enviar el correo de confirmación de reservación #`
     - `Error al enviar confirmación de reservación #`

## Notas Importantes

### Comportamiento Opcional
- El email es **opcional** - las reservaciones se pueden crear sin email
- Si no se proporciona email, simplemente no se envía correo (sin error)
- Si el email es inválido, se muestra error de validación

### Seguridad
- Todos los datos se escapan con `htmlspecialchars()` en la plantilla
- Validación estricta de formato de email con `filter_var()`
- Contraseñas SMTP almacenadas en base de datos (considerar encriptar en producción)

### Compatibilidad
- Compatible con MySQL 5.7+
- Requiere PHP con soporte para `stream_socket_client`
- Funciona con SMTP de Gmail, Outlook, SendGrid, etc.

### Mantenimiento
- Los emails fallidos no interrumpen el flujo normal
- Errores se registran en logs de PHP para debugging
- Si cambia el formato del email, editar `core/ReservationEmailTemplate.php`

## Solución de Problemas

### Email no se envía
1. Verificar configuración SMTP en Settings
2. Usar "Enviar Correo de Prueba" para validar conexión
3. Revisar logs de PHP
4. Verificar que el cliente tenga email en la base de datos

### Email va a spam
1. Configurar SPF/DKIM del dominio remitente
2. Usar servidor SMTP reputado (Gmail, SendGrid, etc.)
3. Evitar palabras spam en el asunto/cuerpo

### Formato HTML no se ve bien
- Revisar cliente de correo del destinatario
- La plantilla usa estilos inline para máxima compatibilidad
- Probar en Gmail, Outlook, y cliente móvil

## Ejemplo de Email

El email enviado tiene el siguiente formato:

```
De: Rancho Paraíso Real <reservaciones@ranchoparaisoreal.com>
Para: cliente@ejemplo.com
CC: reservaciones@ranchoparaisoreal.com
Asunto: Confirmación de Reservación - Rancho Paraíso Real

[HTML con diseño verde, logo, y tabla de detalles]

Estimado/a Roberto Silva,

¡Gracias por elegir Rancho Paraíso Real! Nos complace confirmar...

Detalles de su Reservación:
- Tipo: 🍽️ Reservación Restaurante
- Cliente: Roberto Silva
- Email: cliente@ejemplo.com
- Teléfono: 5555780012
- Recurso: Mesa(s) 5
- Fecha: 25/11/2025
- Hora: 14:00
- Personas: 8
- Estado: PENDIENTE
- Notas: Reservación de alberca para fiesta familiar

Información de Contacto:
Email: reservaciones@ranchoparaisoreal.com
Sitio Web: www.ranchoparaisoreal.com

Si necesita modificar o cancelar su reservación...
```

## Próximos Pasos (Opcional)

Para mejorar en el futuro:
- [ ] Recordatorios automáticos 24h antes de la reservación
- [ ] Email de cancelación
- [ ] Email personalizado al confirmar reservación
- [ ] Soporte para adjuntos (menú, mapa, etc.)
- [ ] Plantillas configurables desde admin
- [ ] Pruebas automatizadas de envío de email

---

**Implementado por:** GitHub Copilot Agent
**Fecha:** 2026-06-03
**Versión:** 1.0
