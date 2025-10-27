# 🔐 Configuración de Google OAuth + Magic Link

## ✅ Implementación Completada

Se ha agregado exitosamente:
1. ✅ Login con Google (OAuth 2.0)
2. ✅ Magic Link (Login sin contraseña por email)
3. ✅ Login tradicional (email + contraseña)

---

## 📋 Configuración Necesaria

### 1️⃣ **Configurar Google OAuth** (15 minutos)

#### Paso 1: Crear Proyecto en Google Cloud Console

1. Ve a [Google Cloud Console](https://console.cloud.google.com/)
2. Crea un nuevo proyecto o selecciona uno existente
3. Nombre sugerido: "CHOJIN Beats Auth"

#### Paso 2: Configurar Pantalla de Consentimiento

1. En el menú lateral: **APIs & Services** → **OAuth consent screen**
2. Tipo de usuario: **Externo**
3. Información de la aplicación:
   - **App name**: CHOJIN Beats
   - **User support email**: tu-email@gmail.com
   - **Developer contact**: tu-email@gmail.com
4. **Ámbitos**: No es necesario agregar ninguno (usa los predeterminados)
5. **Usuarios de prueba**: Agrega tu email y otros emails de prueba
6. Click en **Save and Continue**

#### Paso 3: Crear Credenciales OAuth

1. En el menú lateral: **APIs & Services** → **Credentials**
2. Click en **+ CREATE CREDENTIALS** → **OAuth client ID**
3. Application type: **Web application**
4. Name: "CHOJIN Beats Web Client"
5. **Authorized JavaScript origins**:
   ```
   http://localhost
   ```
6. **Authorized redirect URIs**:
   ```
   http://localhost/CHOJIN/public/auth/google/callback
   ```
   (Para producción, agrega también):
   ```
   https://lucio.tknegocios.com/chojin/public/auth/google/callback
   ```
7. Click en **CREATE**
8. **¡IMPORTANTE!** Copia el **Client ID** y **Client secret**

#### Paso 4: Configurar en `.env`

Abre `c:\xampp\htdocs\CHOJIN\.env` y reemplaza:

```ini
# Desarrollo (localhost)
google.clientId = TU_CLIENT_ID_COPIADO_AQUI
google.clientSecret = TU_CLIENT_SECRET_COPIADO_AQUI
google.redirectUri = http://localhost/CHOJIN/public/auth/google/callback
```

**Para producción** (en `.env` del servidor):
```ini
google.clientId = TU_CLIENT_ID_COPIADO_AQUI
google.clientSecret = TU_CLIENT_SECRET_COPIADO_AQUI
google.redirectUri = https://lucio.tknegocios.com/chojin/public/auth/google/callback
```

---

### 2️⃣ **Configurar Email (Magic Link)** (10 minutos)

#### Opción A: Usar Gmail (Recomendado para pruebas)

1. Ve a [myaccount.google.com/apppasswords](https://myaccount.google.com/apppasswords)
2. **App name**: "CHOJIN Beats"
3. Click en **Generate**
4. **Copia la contraseña de 16 caracteres** (sin espacios)

Abre `.env` y configura:

```ini
email.fromEmail = tu-email@gmail.com
email.fromName = "CHOJIN Beats"
email.SMTPHost = smtp.gmail.com
email.SMTPUser = tu-email@gmail.com
email.SMTPPass = xxxx xxxx xxxx xxxx  # La app password de 16 dígitos
email.SMTPPort = 587
email.SMTPCrypto = tls
```

#### Opción B: Usar otro proveedor SMTP

**SendGrid, Mailgun, o tu hosting:**
```ini
email.fromEmail = noreply@tudominio.com
email.fromName = "CHOJIN Beats"
email.SMTPHost = smtp.sendgrid.net  # O tu servidor SMTP
email.SMTPUser = apikey  # O tu usuario SMTP
email.SMTPPass = SG.xxxxxxxxxxxxx  # Tu API key o contraseña
email.SMTPPort = 587
email.SMTPCrypto = tls
```

---

## 🧪 **Probar la Implementación**

### 1. Iniciar servidor local

```bash
cd C:\xampp\htdocs\CHOJIN\public
php -S localhost:8000
```

O usa XAMPP:
```
http://localhost/CHOJIN/public/auth/login
```

### 2. Probar Login Tradicional

1. Usa un usuario existente:
   - Email: usuario@test.com
   - Contraseña: (tu contraseña)

### 3. Probar Google OAuth

1. Click en **"Continuar con Google"**
2. Selecciona tu cuenta de Google
3. Autoriza la aplicación
4. Deberías ser redirigido y autenticado automáticamente

### 4. Probar Magic Link

1. Click en **"Enviar Link Mágico por Email"**
2. Ingresa tu email (debe existir en la BD)
3. Revisa tu bandeja de entrada
4. Click en el enlace del email
5. Serás autenticado automáticamente

---

## 🎨 **Características Agregadas**

### Vista de Login Mejorada:
- ✅ Botón de Google con logo oficial
- ✅ Formulario Magic Link expandible
- ✅ Diseño responsive y moderno
- ✅ Animaciones suaves
- ✅ Mensajes de error/éxito

### Seguridad:
- ✅ Tokens únicos de 64 caracteres (256 bits)
- ✅ Magic Links expiran en 15 minutos
- ✅ Tokens de un solo uso
- ✅ Verificación de estado CSRF en OAuth
- ✅ Contraseñas hasheadas con BCRYPT (cost 12)
- ✅ Rate limiting en login tradicional

### Base de Datos:
- ✅ Nueva tabla `magic_links` creada
- ✅ Índices optimizados
- ✅ Limpieza automática de tokens expirados

---

## 📝 **Nuevas Rutas Disponibles**

```php
// Google OAuth
GET  /auth/google                    // Inicia login con Google
GET  /auth/google/callback           // Callback de Google

// Magic Link
POST /auth/send-magic-link           // Envía magic link por email
GET  /auth/verify-magic-link/{token} // Verifica y autentica
```

---

## 🚀 **Para Producción**

### 1. Actualizar URLs en Google Cloud Console

Agrega las URIs de producción:
```
https://lucio.tknegocios.com/chojin/public/auth/google/callback
```

### 2. Configurar Email en Servidor

Usa el SMTP de tu hosting o un servicio profesional como:
- **SendGrid** (100 emails/día gratis)
- **Mailgun** (5,000 emails/mes gratis)
- **Amazon SES** (muy económico)

### 3. Actualizar `.env` en Producción

```ini
# Google OAuth
google.clientId = TU_CLIENT_ID
google.clientSecret = TU_CLIENT_SECRET
google.redirectUri = https://lucio.tknegocios.com/chojin/public/auth/google/callback

# Email
email.fromEmail = noreply@lucio.tknegocios.com
email.fromName = "CHOJIN Beats"
# ... resto de configuración SMTP
```

---

## 🔧 **Troubleshooting**

### Error: "redirect_uri_mismatch"
- Verifica que la URI en Google Console coincida EXACTAMENTE con la configurada en `.env`
- No olvides agregar tanto la versión localhost como la de producción

### Error: "Invalid state"
- Asegúrate que las sesiones estén funcionando correctamente
- Verifica que `writable/session/` tenga permisos de escritura

### Magic Link no llega al email
- Verifica credenciales SMTP en `.env`
- Revisa carpeta de SPAM
- Checa los logs en `writable/logs/` para más detalles

### Error al enviar email
- Verifica que las comillas en `email.fromName` estén presentes
- Asegúrate que usas App Password (Gmail) o API key válida

---

## 📚 **Documentación Adicional**

- [Google OAuth Documentation](https://developers.google.com/identity/protocols/oauth2)
- [CodeIgniter Email Library](https://codeigniter.com/user_guide/libraries/email.html)
- [League OAuth2 Client](https://oauth2-client.thephpleague.com/)

---

¿Listo para probar? 🎉
