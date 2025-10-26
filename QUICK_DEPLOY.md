# 🚀 GUÍA RÁPIDA DE DEPLOYMENT

## Para Deployment Inmediato (Sin Git)

### 1. Exportar Base de Datos
```sql
-- En phpMyAdmin local, exportar 'chojin_bd'
-- Guardar como: chojin_bd_backup.sql
```

### 2. Preparar Archivos

**En tu PC (carpeta CHOJIN):**
1. Crear carpeta `deploy_package`
2. Copiar estas carpetas/archivos:
   - `app/`
   - `public/`
   - `system/`
   - `vendor/` (toda la carpeta)
   - `writable/` (vaciar cache y logs primero)
   - `composer.json`
   - `.env.production` → renombrar a `.env`

3. Editar el `.env` dentro de `deploy_package`:
   ```ini
   CI_ENVIRONMENT = production
   app.baseURL = https://tudominio.com/
   
   database.default.database = tu_bd_produccion
   database.default.username = tu_usuario_bd
   database.default.password = tu_password_bd
   ```

4. Comprimir todo en `chojin_deployment.zip`

### 3. Subir a cPanel

1. **Entrar a cPanel → File Manager**

2. **Crear estructura:**
   ```
   /home/tuusuario/
   ├── public_html/          ← Ya existe
   └── chojin_app/           ← Crear esta carpeta
   ```

3. **Subir y extraer:**
   - Subir `chojin_deployment.zip` a `/chojin_app/`
   - Extraer el archivo
   - Eliminar el .zip

4. **Mover archivos públicos:**
   - Ir a `/chojin_app/public/`
   - Seleccionar TODO el contenido (index.php, .htaccess, assets/, etc.)
   - Mover a `/public_html/`

5. **Editar `/public_html/index.php`:**
   - Buscar la línea con `ROOTPATH`
   - Cambiar a:
   ```php
   define('ROOTPATH', dirname(__DIR__) . '/chojin_app/');
   ```

### 4. Configurar Base de Datos

1. **Crear BD en cPanel:**
   - MySQL Databases → Create New Database
   - Nombre: `tuusuario_chojin`

2. **Crear usuario:**
   - Username: `tuusuario_chojin_user`
   - Password: (generar uno fuerte)
   - Add User to Database (All Privileges)

3. **Importar datos:**
   - phpMyAdmin → Seleccionar BD
   - Import → Subir `chojin_bd_backup.sql`

4. **Actualizar `/chojin_app/.env`:**
   ```ini
   database.default.database = tuusuario_chojin
   database.default.username = tuusuario_chojin_user
   database.default.password = el_password_que_creaste
   ```

### 5. Configurar Permisos

En File Manager, seleccionar `/chojin_app/writable/` → Change Permissions → 755

### 6. Verificar

Abrir: `https://tudominio.com/`

✅ Si todo está bien, deberías ver tu página principal

---

## Para Actualizaciones Futuras (Workflow Simple)

### Opción A: Manual (Sin Git)

1. **En local, hacer cambios**
2. **Subir solo archivos modificados:**
   - Via FTP/cPanel File Manager
   - Reemplazar archivos específicos en `/chojin_app/`
   - Si modificaste archivos en `public/`, actualizar en `/public_html/`

### Opción B: Con Git (Recomendado)

1. **Primera vez - Conectar a Git:**
   ```powershell
   cd C:\xampp\htdocs\CHOJIN
   git init
   git add .
   git commit -m "Initial commit"
   git branch -M main
   git remote add origin https://github.com/tuusuario/chojin.git
   git push -u origin main
   ```

2. **En servidor (Terminal/SSH en cPanel):**
   ```bash
   cd /home/tuusuario/chojin_app
   git init
   git remote add origin https://github.com/tuusuario/chojin.git
   git pull origin main
   ```

3. **Para actualizar después:**
   
   **En tu PC:**
   ```powershell
   git add .
   git commit -m "Cambios realizados"
   git push origin main
   ```
   
   **En servidor:**
   ```bash
   cd /home/tuusuario/chojin_app
   git pull origin main
   ```

---

## 🆘 Si algo sale mal

### Página en blanco
1. Cambiar en `.env`: `CI_ENVIRONMENT = development`
2. Ver qué error muestra
3. Revisar `/chojin_app/writable/logs/`

### Error 500
1. Verificar permisos de `writable/` (debe ser 755)
2. Verificar que `index.php` tenga la ruta correcta a ROOTPATH

### No carga CSS/JS
1. Verificar que `assets/` esté en `/public_html/`
2. Verificar `app.baseURL` en `.env`

### Error de base de datos
1. Verificar credenciales en `.env`
2. Verificar que la base de datos esté importada
3. Verificar que el usuario tenga permisos

---

## 📋 Checklist Pre-Deployment

- [ ] Exportar base de datos
- [ ] Actualizar .env con datos de producción
- [ ] Comprimir archivos
- [ ] Crear base de datos en cPanel
- [ ] Subir archivos
- [ ] Mover public/ a public_html/
- [ ] Editar ROOTPATH en index.php
- [ ] Importar base de datos
- [ ] Configurar permisos writable/
- [ ] Probar en navegador

---

¿Todo listo para deployment? 🚀
