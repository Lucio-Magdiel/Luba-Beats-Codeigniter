# 🚀 Guía de Despliegue en Producción - LubaBeats Beta

## 📋 Pre-requisitos

- Acceso a cPanel
- Credenciales de Google OAuth configuradas
- Credenciales de Cloudinary configuradas
- Base de datos MySQL creada

---

## 🔧 Paso 1: Configurar Google OAuth

### 1.1 En Google Cloud Console

Ve a: https://console.cloud.google.com/

1. **Orígenes autorizados de JavaScript:**
   ```
   https://lucio.tknegocios.com
   ```

2. **URIs de redirección autorizadas:**
   ```
   https://lucio.tknegocios.com/chojin/auth/google/callback
   ```

⚠️ **IMPORTANTE:** 
- La URI debe ser **exactamente** como está escrita
- Sin `/public/` en la ruta
- Todo en minúsculas (`/chojin/` no `/CHOJIN/`)
- Sin barra final

---

## 📁 Paso 2: Subir archivos a cPanel

### Opción A: Via FileManager de cPanel

1. Comprime tu proyecto localmente (excluyendo: `vendor/`, `writable/`, `.env`)
2. Sube el ZIP a `/public_html/chojin/`
3. Extrae los archivos

### Opción B: Via FTP

1. Conecta con FileZilla o similar
2. Sube todos los archivos EXCEPTO:
   - `/vendor/` (lo instalaremos después)
   - `/writable/` (se crea automáticamente)
   - `.env` (lo crearemos en el servidor)

---

## ⚙️ Paso 3: Configurar el archivo `.env`

En cPanel, ve a **File Manager** → `/public_html/chojin/`

1. **Crea un nuevo archivo llamado `.env`** (sin extensión .txt)
2. Copia el contenido de `.env.example`
3. **Configura los valores reales:**

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = 'https://lucio.tknegocios.com/chojin/'
app.forceGlobalSecureRequests = true

#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = [TU_NOMBRE_BD]
database.default.username = [TU_USUARIO_BD]
database.default.password = [TU_PASSWORD_BD]
database.default.DBDriver = MySQLi
database.default.port = 3306

#--------------------------------------------------------------------
# CLOUDINARY CONFIGURATION
#--------------------------------------------------------------------

cloudinary.cloudName = [TU_CLOUD_NAME]
cloudinary.apiKey = [TU_API_KEY]
cloudinary.apiSecret = [TU_API_SECRET]

#--------------------------------------------------------------------
# GOOGLE OAUTH CONFIGURATION
#--------------------------------------------------------------------

google.clientId = [TU_CLIENT_ID].apps.googleusercontent.com
google.clientSecret = [TU_CLIENT_SECRET]
google.redirectUri = https://lucio.tknegocios.com/chojin/auth/google/callback
```

⚠️ **Reemplaza los valores entre corchetes con tus credenciales reales**

---

## 📦 Paso 4: Instalar dependencias (Composer)

### En Terminal SSH de cPanel:

```bash
cd /home/tuusuario/public_html/chojin
composer install --no-dev --optimize-autoloader
```

Si no tienes acceso SSH, contacta a tu proveedor de hosting.

---

## 🗄️ Paso 5: Configurar Base de Datos

1. **Importa el schema** usando phpMyAdmin en cPanel
2. **Ejecuta las migraciones** (si las hay):
   ```bash
   php spark migrate
   ```

---

## 🔒 Paso 6: Configurar permisos

```bash
chmod -R 755 /home/tuusuario/public_html/chojin
chmod -R 777 /home/tuusuario/public_html/chojin/writable
```

---

## 🌐 Paso 7: Configurar .htaccess

Verifica que `/public_html/chojin/public/.htaccess` tenga:

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /chojin/public/
    
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php/$1 [L]
</IfModule>
```

---

## ✅ Paso 8: Verificar funcionamiento

1. **Página principal:**
   ```
   https://lucio.tknegocios.com/chojin/public/
   ```

2. **Login:**
   ```
   https://lucio.tknegocios.com/chojin/public/auth/login
   ```

3. **Test Google OAuth:**
   - Click en "Iniciar sesión con Google"
   - Debe redirigir a Google
   - Después del login, debe volver a tu sitio

---

## 🐛 Solución de problemas comunes

### Error: "redirect_uri_mismatch"

**Causa:** La URI configurada en Google Console no coincide con la que envía tu aplicación.

**Solución:**
1. Verifica en Google Cloud Console que la URI sea **exactamente:**
   ```
   https://lucio.tknegocios.com/chojin/auth/google/callback
   ```
2. Verifica en tu `.env` que `google.redirectUri` sea igual
3. Limpia la caché: `php spark cache:clear`

### Error: "500 Internal Server Error"

**Solución:**
1. Revisa los logs: `/writable/logs/`
2. Verifica permisos de carpeta `writable/`
3. Verifica que `.env` tenga los valores correctos

### Error: "Base de datos no conecta"

**Solución:**
1. Verifica credenciales en `.env`
2. En cPanel, verifica que el usuario tenga permisos en la BD
3. Verifica que `hostname` sea `localhost` (no una IP)

---

## 📱 Contacto y Soporte

Desarrollado por: **Magdiel UCHIHA**  
LubaBeats Beta © 2025

---

## 🔐 Seguridad

- ✅ Archivo `.env` está en `.gitignore`
- ✅ NUNCA compartas tus credenciales
- ✅ Usa HTTPS en producción
- ✅ Mantén Composer y dependencias actualizadas
