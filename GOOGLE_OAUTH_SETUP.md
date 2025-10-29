# 🔐 Configuración de Google OAuth - LubaBeats Beta

## Paso 1: Crear Proyecto en Google Cloud Console

1. Ve a: https://console.cloud.google.com/
2. Inicia sesión con tu cuenta de Google
3. Click en el menú desplegable del proyecto (arriba a la izquierda)
4. Click en **"Nuevo Proyecto"** (New Project)
5. Nombre del proyecto: `LubaBeats-Beta`
6. Click en **"Crear"**

---

## Paso 2: Habilitar Google+ API

1. En el menú lateral, ve a: **APIs y servicios** → **Biblioteca**
2. Busca: `Google+ API`
3. Click en **Google+ API**
4. Click en **"Habilitar"** (Enable)

---

## Paso 3: Configurar Pantalla de Consentimiento OAuth

1. En el menú lateral: **APIs y servicios** → **Pantalla de consentimiento de OAuth**
2. Selecciona: **Externo** (External)
3. Click en **"Crear"**

### Información de la aplicación:
- **Nombre de la aplicación**: `LubaBeats Beta`
- **Correo electrónico de asistencia**: Tu correo de Gmail
- **Logo de la aplicación** (opcional): Puedes subir el logo de LubaBeats
- **Dominios autorizados**: Deja vacío por ahora

### Información del desarrollador:
- **Correo electrónico del desarrollador**: Tu correo de Gmail

4. Click en **"Guardar y continuar"**

### Alcances (Scopes):
5. Click en **"Agregar o quitar alcances"**
6. Selecciona:
   - `userinfo.email`
   - `userinfo.profile`
7. Click en **"Actualizar"**
8. Click en **"Guardar y continuar"**

### Usuarios de prueba:
9. Click en **"Agregar usuarios"**
10. Agrega tu correo de Gmail
11. Click en **"Guardar y continuar"**
12. Click en **"Volver al panel"**

---

## Paso 4: Crear Credenciales OAuth 2.0

1. En el menú lateral: **APIs y servicios** → **Credenciales**
2. Click en **"Crear credenciales"** → **ID de cliente de OAuth**
3. Tipo de aplicación: **Aplicación web**

### Configuración:
- **Nombre**: `LubaBeats Beta - Web Client`

### Orígenes de JavaScript autorizados:
```
http://localhost
http://localhost/CHOJIN
http://localhost/CHOJIN/public
https://lucio.tknegocios.com
```

### URIs de redireccionamiento autorizadas:
```
http://localhost/CHOJIN/public/auth/google/callback
https://lucio.tknegocios.com/chojin/auth/google/callback
```

4. Click en **"Crear"**

---

## Paso 5: Copiar las Credenciales

Después de crear, verás un popup con:
- **ID de cliente** (Client ID)
- **Secreto del cliente** (Client Secret)

### ⚠️ IMPORTANTE: Copia estas credenciales

---

## Paso 6: Configurar en tu proyecto

### Para LOCAL (desarrollo):

1. Abre el archivo: `c:\xampp\htdocs\CHOJIN\env`
2. Reemplaza las líneas:

```env
google.clientId = TU_CLIENT_ID_AQUI
google.clientSecret = TU_CLIENT_SECRET_AQUI
google.redirectUri = http://localhost/CHOJIN/public/auth/google/callback
```

Por tus credenciales reales:

```env
google.clientId = 123456789-abc123.apps.googleusercontent.com
google.clientSecret = GOCSPX-tu_secret_aqui
google.redirectUri = http://localhost/CHOJIN/public/auth/google/callback
```

### Para PRODUCCIÓN:

1. Crea/edita el archivo `.env` en producción
2. Agrega:

```env
google.clientId = 123456789-abc123.apps.googleusercontent.com
google.clientSecret = GOCSPX-tu_secret_aqui
google.redirectUri = https://lucio.tknegocios.com/chojin/auth/google/callback
```

---

## Paso 7: Probar el Login

### En local:
1. Ve a: http://localhost/CHOJIN/public/auth/login
2. Click en **"Continuar con Google"**
3. Selecciona tu cuenta de Google
4. Autoriza la aplicación
5. Deberías ser redirigido y autenticado

### En producción:
1. Ve a: https://lucio.tknegocios.com/chojin/auth/login
2. Click en **"Continuar con Google"**
3. Autoriza la aplicación
4. Autenticación exitosa

---

## 📋 Checklist de Verificación

- [ ] Proyecto creado en Google Cloud Console
- [ ] Google+ API habilitada
- [ ] Pantalla de consentimiento configurada
- [ ] Usuario de prueba agregado (tu correo)
- [ ] Credenciales OAuth 2.0 creadas
- [ ] Orígenes autorizados configurados (localhost + producción)
- [ ] URIs de redirección configurados
- [ ] Credenciales copiadas al archivo `.env` local
- [ ] Credenciales configuradas en producción
- [ ] Prueba local exitosa
- [ ] Prueba en producción exitosa

---

## 🐛 Solución de Problemas

### Error: "redirect_uri_mismatch"
- Verifica que la URI en Google Cloud Console coincida EXACTAMENTE con la de tu `.env`
- No olvides incluir `http://` o `https://`
- Revisa que no haya espacios al inicio/final

### Error: "Access blocked: This app's request is invalid"
- Asegúrate de haber configurado la pantalla de consentimiento
- Verifica que tu correo esté en "Usuarios de prueba"

### Error: "invalid_client"
- Verifica que el `Client ID` y `Client Secret` sean correctos
- Revisa que no haya espacios al copiar/pegar

### Usuario creado pero no redirige correctamente
- Verifica las rutas en `app/Controllers/Auth.php` línea 150-160
- Revisa los logs en `writable/logs/`

---

## 📚 Referencias

- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Google Cloud Console](https://console.cloud.google.com/)
- [League OAuth2 Client - Google](https://github.com/thephpleague/oauth2-google)

---

## ✅ Estado Actual

### Implementado:
- ✅ Controlador `Auth.php` con métodos OAuth
- ✅ Rutas configuradas en `Routes.php`
- ✅ Vista de login con botón de Google
- ✅ Librería `league/oauth2-google` instalada
- ✅ Configuración `.env` preparada
- ✅ Creación automática de usuarios nuevos
- ✅ Validación de seguridad (state CSRF)

### Pendiente:
- ⏳ Obtener credenciales de Google Cloud Console
- ⏳ Configurar credenciales en `.env`
- ⏳ Probar login en local
- ⏳ Configurar credenciales en producción
- ⏳ Probar login en producción

---

Desarrollado por **Magdiel UCHIHA** 
LubaBeats Beta © 2025
