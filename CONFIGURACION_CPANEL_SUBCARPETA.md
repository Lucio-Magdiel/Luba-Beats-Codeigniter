# ⚙️ Configuración de cPanel - Opción Subcarpeta

## 📋 Resumen
Este documento te guía para configurar tu aplicación en cPanel cuando **NO puedes cambiar el Document Root** y debes usar la estructura `/chojin/public/`.

---

## ✅ **Paso 1: Actualizar archivo `.env` en el servidor**

**Ubicación:** `/public_html/chojin/.env`

**Edita con File Manager y asegúrate que tenga:**

```env
#--------------------------------------------------------------------
# ENVIRONMENT
#--------------------------------------------------------------------

CI_ENVIRONMENT = production

#--------------------------------------------------------------------
# APP
#--------------------------------------------------------------------

app.baseURL = 'https://lucio.tknegocios.com/chojin/public/'
app.indexPage = ''
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

cloudinary.cloudName = dacq9spfd
cloudinary.apiKey = 673773564935556
cloudinary.apiSecret = XTzb0TT_hdpQAsUxXEA8RxWg5lA

#--------------------------------------------------------------------
# GOOGLE OAUTH CONFIGURATION
#--------------------------------------------------------------------

google.clientId = [TU_CLIENT_ID].apps.googleusercontent.com
google.clientSecret = [TU_CLIENT_SECRET]
google.redirectUri = https://lucio.tknegocios.com/chojin/public/auth/google/callback
```

⚠️ **IMPORTANTE:** Reemplaza `[TU_NOMBRE_BD]`, `[TU_USUARIO_BD]` y `[TU_PASSWORD_BD]` con tus credenciales reales de la base de datos.

---

## ✅ **Paso 2: Actualizar `.htaccess` en carpeta public**

**Ubicación:** `/public_html/chojin/public/.htaccess`

**Asegúrate que tenga esta línea DESCOMENTADA:**

```apache
RewriteBase /chojin/public/
```

El archivo completo debe verse así:

```apache
# Disable directory browsing
Options -Indexes

# ----------------------------------------------------------------------
# Rewrite engine
# ----------------------------------------------------------------------

<IfModule mod_rewrite.c>
	Options +FollowSymlinks
	RewriteEngine On

	# Configuración para subcarpeta
	RewriteBase /chojin/public/

	# Redirect Trailing Slashes...
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteCond %{REQUEST_URI} (.+)/$
	RewriteRule ^ %1 [L,R=301]

	# Rewrite "www.example.com -> example.com"
	RewriteCond %{HTTPS} !=on
	RewriteCond %{HTTP_HOST} ^www\.(.+)$ [NC]
	RewriteRule ^ http://%1%{REQUEST_URI} [R=301,L]

	# Enviar todas las peticiones a index.php
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^([\s\S]*)$ index.php/$1 [L,NC,QSA]

	# Ensure Authorization header is passed along
	RewriteCond %{HTTP:Authorization} .
	RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
</IfModule>

<IfModule !mod_rewrite.c>
	ErrorDocument 404 index.php
</IfModule>

ServerSignature Off
```

---

## ✅ **Paso 3: Actualizar Google Cloud Console**

1. Ve a: https://console.cloud.google.com/
2. Selecciona tu proyecto
3. Ve a **APIs y servicios** → **Credenciales**
4. Edita tus credenciales OAuth 2.0

**URIs de redirección autorizadas - Actualiza a:**

```
https://lucio.tknegocios.com/chojin/public/auth/google/callback
```

**Orígenes autorizados de JavaScript:**

```
https://lucio.tknegocios.com
```

---

## ✅ **Paso 4: Actualizar controlador Auth.php**

**Ubicación:** `/public_html/chojin/app/Controllers/Auth.php`

Copia el contenido del archivo desde tu PC local (ya está actualizado con `base_url()`).

O descárgalo desde GitHub:
```
https://github.com/Lucio-Magdiel/Luba-Beats-Codeigniter/blob/main/app/Controllers/Auth.php
```

---

## ✅ **Paso 5: Verificar permisos**

Asegúrate que la carpeta `writable` tenga permisos 755 o 777:

```bash
chmod -R 755 /public_html/chojin/writable
```

O hazlo desde File Manager → Click derecho en carpeta `writable` → Change Permissions → 755

---

## 🧪 **Paso 6: Probar la aplicación**

1. **Página principal:**
   ```
   https://lucio.tknegocios.com/chojin/public/
   ```

2. **Login:**
   ```
   https://lucio.tknegocios.com/chojin/public/auth/login
   ```

3. **Google OAuth:**
   - Click en "Iniciar sesión con Google"
   - Autoriza en Google
   - Deberías ser redirigido de vuelta sin error 404

---

## 🐛 **Solución de problemas**

### Error: "404 Not Found"

**Causa:** El `.htaccess` no está configurado correctamente.

**Solución:**
1. Verifica que `RewriteBase /chojin/public/` esté descomentado
2. Verifica que mod_rewrite esté habilitado en el servidor
3. Verifica que el archivo `.htaccess` esté en `/public_html/chojin/public/`

### Error: "redirect_uri_mismatch"

**Causa:** La URI en Google Console no coincide.

**Solución:**
1. Verifica en Google Console que sea **exactamente:**
   ```
   https://lucio.tknegocios.com/chojin/public/auth/google/callback
   ```
2. Verifica en `.env` que `google.redirectUri` sea idéntico

### Error: "500 Internal Server Error"

**Solución:**
1. Revisa los logs en: `/public_html/chojin/writable/logs/`
2. Verifica permisos de la carpeta `writable` (debe ser 755 o 777)
3. Verifica que las credenciales de base de datos en `.env` sean correctas

---

## 📱 **URLs de tu aplicación en producción**

Con esta configuración, tus URLs serán:

- **Home:** `https://lucio.tknegocios.com/chojin/public/`
- **Catálogo:** `https://lucio.tknegocios.com/chojin/public/catalogo`
- **Login:** `https://lucio.tknegocios.com/chojin/public/auth/login`
- **Admin Dashboard:** `https://lucio.tknegocios.com/chojin/public/admin/dashboard`
- **Panel Productor:** `https://lucio.tknegocios.com/chojin/public/productor/panel`
- **Panel Artista:** `https://lucio.tknegocios.com/chojin/public/artista/panel`

---

## ✅ **Checklist Final**

- [ ] `.env` actualizado con `app.baseURL` correcto
- [ ] `.env` tiene `google.redirectUri` con `/chojin/public/`
- [ ] `.htaccess` tiene `RewriteBase /chojin/public/`
- [ ] Google Cloud Console tiene la URI con `/chojin/public/`
- [ ] `Auth.php` actualizado con `base_url()`
- [ ] Permisos de `writable` configurados
- [ ] Probado login con Google

---

**Desarrollado por:** Magdiel UCHIHA  
**LubaBeats Beta © 2025**
