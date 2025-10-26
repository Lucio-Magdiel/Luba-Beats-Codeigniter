# CHOJIN BEATS - Guía de Deployment a Producción

## 📋 Requisitos Previos

- Hosting con cPanel (ya lo tienes ✓)
- Soporte para PHP 7.4+ y MySQL 5.7+
- Acceso SSH (recomendado) o FTP
- Dominio configurado apuntando a tu hosting

---

## 🚀 OPCIÓN 1: Deployment Manual con cPanel

### Paso 1: Preparar Archivos en Local

1. **Crear archivo .htaccess para producción**
   - Ya está incluido en `public/.htaccess`
   - Asegúrate de que existe

2. **Actualizar .env para producción**
   - Renombra `.env.production` a `.env` en el servidor
   - O edita el `.env` existente con los valores de producción

### Paso 2: Subir Archivos vía cPanel File Manager

1. **Comprimir el proyecto localmente**
   ```powershell
   # En tu carpeta CHOJIN, excluir archivos innecesarios
   # No incluir: .git, writable/cache/*, writable/logs/*, vendor/ (si es muy grande)
   ```

2. **Subir a cPanel**
   - Entra a cPanel → File Manager
   - Ve a `public_html/` (o la carpeta de tu dominio)
   - Sube el archivo .zip
   - Extrae el contenido

3. **Estructura recomendada en el servidor:**
   ```
   /home/usuario/
   ├── public_html/              ← Aquí apunta tu dominio
   │   ├── index.php             ← Copiar desde CHOJIN/public/
   │   ├── .htaccess             ← Copiar desde CHOJIN/public/
   │   ├── assets/               ← Copiar carpeta completa
   │   └── uploads/              ← Crear vacía (Cloudinary maneja esto)
   └── chojin_app/               ← Resto de la aplicación (FUERA de public_html)
       ├── app/
       ├── system/
       ├── writable/
       ├── vendor/
       ├── .env
       └── composer.json
   ```

### Paso 3: Configurar Rutas en el Servidor

1. **Editar `public_html/index.php`**
   - Cambiar la ruta de ROOTPATH para que apunte a `chojin_app/`:
   ```php
   define('ROOTPATH', dirname(__DIR__) . '/chojin_app/');
   ```

2. **Crear/verificar .htaccess en public_html/**
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteBase /
       
       RewriteCond %{REQUEST_FILENAME} !-f
       RewriteCond %{REQUEST_FILENAME} !-d
       RewriteRule ^(.*)$ index.php/$1 [L]
   </IfModule>
   ```

### Paso 4: Configurar Base de Datos

1. **Crear base de datos en cPanel**
   - cPanel → MySQL Databases
   - Crear nueva base de datos: `usuario_chojin`
   - Crear usuario con contraseña segura
   - Asignar todos los privilegios

2. **Importar estructura**
   - cPanel → phpMyAdmin
   - Seleccionar la nueva base de datos
   - Importar tu archivo SQL de local

3. **Actualizar .env en el servidor**
   ```ini
   database.default.hostname = localhost
   database.default.database = usuario_chojin
   database.default.username = usuario_chojin_user
   database.default.password = tu_password_seguro
   ```

### Paso 5: Instalar Dependencias

1. **Si tienes SSH:**
   ```bash
   cd /home/usuario/chojin_app
   composer install --no-dev --optimize-autoloader
   ```

2. **Si NO tienes SSH:**
   - Sube la carpeta `vendor/` completa desde tu local
   - Asegúrate de que esté actualizada: `composer install` en local primero

### Paso 6: Configurar Permisos

```bash
# En SSH o File Manager
chmod -R 755 /home/usuario/chojin_app/writable
chmod -R 755 /home/usuario/public_html/assets
```

### Paso 7: Verificar Configuración

1. **Editar .env en servidor:**
   ```ini
   CI_ENVIRONMENT = production
   app.baseURL = https://tudominio.com/
   app.forceGlobalSecureRequests = true
   ```

2. **Generar encryption key (en SSH):**
   ```bash
   php spark key:generate
   ```
   O añade manualmente una key de 32 caracteres en `.env`

---

## 🔄 OPCIÓN 2: Deployment Automático con Git + GitHub

### Configuración Inicial

1. **Crear repositorio en GitHub**
   ```powershell
   cd C:\xampp\htdocs\CHOJIN
   git init
   git add .
   git commit -m "Initial commit - CHOJIN Beats Platform"
   git branch -M main
   git remote add origin https://github.com/tuusuario/chojin-beats.git
   git push -u origin main
   ```

2. **Crear .gitignore**
   ```gitignore
   .env
   vendor/
   writable/cache/*
   writable/logs/*
   writable/session/*
   writable/uploads/*
   !writable/cache/index.html
   !writable/logs/index.html
   !writable/session/index.html
   !writable/uploads/index.html
   .DS_Store
   Thumbs.db
   ```

3. **Conectar servidor con Git (SSH requerido)**
   ```bash
   # En tu servidor
   cd /home/usuario/
   git clone https://github.com/tuusuario/chojin-beats.git chojin_app
   cd chojin_app
   composer install --no-dev
   cp .env.production .env
   # Editar .env con datos reales
   ```

### Para Actualizar (Workflow de Desarrollo)

**En local:**
```powershell
# Hacer cambios
git add .
git commit -m "Descripción de cambios"
git push origin main
```

**En servidor (SSH o cPanel Terminal):**
```bash
cd /home/usuario/chojin_app
git pull origin main
composer install --no-dev --optimize-autoloader
# Si hay cambios en la BD:
php spark migrate
```

---

## 🛡️ OPCIÓN 3: Deployment Profesional con GitHub Actions (CI/CD)

### Crear archivo de deployment automático

1. **Crear `.github/workflows/deploy.yml`** (ver archivo incluido)
2. **Configurar secretos en GitHub:**
   - Settings → Secrets and variables → Actions
   - Añadir: FTP_SERVER, FTP_USERNAME, FTP_PASSWORD

3. **Workflow automático:**
   - Push a `main` → Deploy automático
   - Push a `develop` → Solo testing (opcional)

---

## 📝 Checklist Post-Deployment

- [ ] Base de datos creada e importada
- [ ] .env configurado correctamente
- [ ] Cloudinary funcionando (verificar URLs)
- [ ] Permisos de carpetas correctos (writable/ = 755)
- [ ] HTTPS configurado (SSL activo)
- [ ] index.php apuntando a rutas correctas
- [ ] Composer dependencies instaladas
- [ ] Probar login/registro
- [ ] Probar subida de beats
- [ ] Probar subida de música
- [ ] Probar player de audio
- [ ] Verificar perfiles públicos

---

## 🔧 Troubleshooting Común

### Error 500 - Internal Server Error
- Verificar permisos de `writable/`
- Revisar logs en `writable/logs/`
- Verificar PHP version (mínimo 7.4)

### Página en blanco
- Activar display_errors temporalmente en `.env`:
  ```ini
  CI_ENVIRONMENT = development
  ```
- Ver errores PHP en cPanel → Error Log

### Assets no cargan (CSS/JS)
- Verificar `app.baseURL` en `.env`
- Verificar que `assets/` esté en `public_html/`

### Database connection failed
- Verificar credenciales en `.env`
- Verificar que el usuario tenga permisos
- Verificar que el host sea `localhost` (no IP)

### Cloudinary no funciona
- Verificar que las credenciales estén en `.env`
- Verificar que el helper esté cargado en controladores

---

## 🔐 Seguridad en Producción

1. **NUNCA subir .env al repositorio** (usar .env.production como plantilla)
2. **Cambiar encryption.key** a una única y segura
3. **Usar contraseñas fuertes** para base de datos
4. **Activar HTTPS** (SSL gratuito con Let's Encrypt en cPanel)
5. **Configurar backups automáticos** en cPanel
6. **Monitorear logs** regularmente

---

## 📞 Siguientes Pasos

1. Elige tu método de deployment (Manual, Git, o CI/CD)
2. Sigue los pasos correspondientes
3. Prueba todo en producción
4. Configura backups automáticos
5. ¡Disfruta tu plataforma en línea! 🎵

---

## 🚀 Mantener Desarrollo Local + Producción

**Workflow recomendado:**

1. **Desarrollo local:**
   - Trabajar en `http://localhost/CHOJIN/public/`
   - Usar `.env` con `CI_ENVIRONMENT = development`

2. **Hacer cambios:**
   ```powershell
   git add .
   git commit -m "Nueva feature X"
   git push origin main
   ```

3. **Actualizar producción:**
   ```bash
   # En servidor SSH
   git pull origin main
   ```

O si usas GitHub Actions, se despliega automáticamente al hacer push.

---

¿Prefieres que te ayude con algún método específico?
