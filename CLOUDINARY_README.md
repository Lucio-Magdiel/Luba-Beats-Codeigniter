# 🎵 CHOJIN - Integración con Cloudinary

## 📦 ¿Qué se ha instalado?

Se ha integrado **Cloudinary** como sistema de almacenamiento en la nube para todos los archivos multimedia de la plataforma CHOJIN.

### ✅ Archivos actualizados:

1. **`app/Libraries/CloudinaryService.php`** - Servicio principal para gestionar uploads
2. **`app/Controllers/Usuario.php`** - Actualizado para fotos de perfil y banners
3. **`app/Controllers/Productor.php`** - Actualizado para beats (audio + visuales)
4. **`app/Controllers/Artista.php`** - Actualizado para música (audio + visuales)
5. **`app/Commands/MigrateCloudinary.php`** - Script de migración de archivos existentes
6. **`env`** - Configuración de credenciales
7. **`composer.json`** - SDK de Cloudinary agregado

---

## 🚀 Pasos para Activar Cloudinary

### **PASO 1: Crear cuenta gratuita**

1. Ve a: **https://cloudinary.com/users/register_free**
2. Completa el registro con tu email
3. Verifica tu cuenta

### **PASO 2: Obtener credenciales**

Después de iniciar sesión, en el Dashboard verás:

```
Cloud Name: ejemplo-chojin
API Key: 123456789012345
API Secret: AbCdEfGhIjKlMnOpQrStUvWxYz123
```

### **PASO 3: Configurar archivo .env**

Abre el archivo `.env` (copia de `env` si no existe) y descomenta estas líneas:

```ini
cloudinary.cloudName = tu-cloud-name
cloudinary.apiKey = tu-api-key
cloudinary.apiSecret = tu-api-secret
```

Reemplaza con tus valores reales.

### **PASO 4: ¡Listo!**

Desde ahora, todos los archivos subidos irán directamente a Cloudinary:
- ✅ Fotos de perfil
- ✅ Banners de perfil
- ✅ Portadas de playlists
- ✅ Beats (audio)
- ✅ Música (audio)
- ✅ Visuales (imágenes/videos)

---

## 📁 Organización en Cloudinary

```
cloudinary.com/tu-cuenta/
├── chojin/
│   ├── profiles/       → Fotos de perfil (400x400px optimizadas)
│   ├── banners/        → Banners (1920x400px optimizados)
│   ├── playlists/      → Portadas de playlists (600x600px)
│   ├── beats/          → Audio de beats (productores)
│   ├── musica/         → Audio de música (artistas)
│   ├── visuales/       → Imágenes/videos de beats
│   └── visuales/musica/→ Imágenes/videos de música
```

---

## 🔄 Migrar Archivos Existentes (Opcional)

Si ya tienes archivos en `public/uploads/`, puedes migrarlos a Cloudinary:

```bash
php spark migrate:cloudinary
```

Este comando:
1. Lee todos los beats y usuarios de la base de datos
2. Sube los archivos locales a Cloudinary
3. Actualiza las URLs en la base de datos
4. **NO elimina archivos locales** (hazlo manualmente después de verificar)

---

## 💰 Límites del Plan Gratuito

| Recurso | Límite Mensual |
|---------|----------------|
| Almacenamiento | 25 GB |
| Ancho de banda | 25 GB |
| Transformaciones | Ilimitadas |
| Créditos | 25 créditos |

**Nota**: Con uso normal, el plan gratuito es suficiente para cientos de beats y usuarios.

---

## 🛠️ Funcionalidades Automáticas

### **Optimización de Imágenes:**
- ✅ Conversión automática a WebP/AVIF (navegadores modernos)
- ✅ Compresión inteligente (`quality: auto:good`)
- ✅ Lazy loading compatible
- ✅ Responsive images

### **CDN Global:**
- ✅ Entrega rápida desde el servidor más cercano al usuario
- ✅ Cache automático
- ✅ SSL/HTTPS incluido

### **Seguridad:**
- ✅ Backups automáticos
- ✅ Validación de tipos de archivo
- ✅ URLs firmadas (opcional)

---

## 📊 Ventajas vs Almacenamiento Local

| Característica | Local (cPanel) | Cloudinary |
|----------------|----------------|------------|
| Espacio ocupado en hosting | ❌ Mucho | ✅ Cero |
| Velocidad de carga | ⚠️ Depende del servidor | ✅ CDN ultra-rápido |
| Optimización automática | ❌ Manual | ✅ Automática |
| Escalabilidad | ❌ Limitada | ✅ Ilimitada |
| Backups | ⚠️ Manual | ✅ Automáticos |
| Costo adicional | ❌ Limitado por hosting | ✅ Gratis hasta 25GB |

---

## 🔧 Métodos Disponibles en CloudinaryService

```php
$cloudinary = new CloudinaryService();

// Subir imagen genérica
$cloudinary->uploadImage($filePath, $folder, $options);

// Subir audio
$cloudinary->uploadAudio($filePath, $folder, $options);

// Métodos especializados (optimizados):
$cloudinary->uploadProfilePhoto($filePath, $userId);
$cloudinary->uploadProfileBanner($filePath, $userId);
$cloudinary->uploadPlaylistCover($filePath, $playlistId);
$cloudinary->uploadBeatVisual($filePath, $beatId);
$cloudinary->uploadBeatAudio($filePath, $beatId);

// Eliminar archivo
$cloudinary->delete($publicId, $resourceType);

// Obtener URL optimizada
$cloudinary->getImageUrl($publicId, $transformations);
$cloudinary->getAudioUrl($publicId);
```

---

## ❓ Preguntas Frecuentes

**P: ¿Qué pasa si llego al límite gratuito?**
R: Cloudinary te notificará. Puedes actualizar a un plan de pago (~$99/mes para más recursos) o usar Backblaze B2 (más económico).

**P: ¿Los archivos locales se borran automáticamente?**
R: No. El sistema sube a Cloudinary pero mantiene los locales. Bórralos manualmente después de verificar.

**P: ¿Funciona en localhost (XAMPP)?**
R: Sí, desde el momento que configures las credenciales en `.env`.

**P: ¿Qué pasa con los archivos ya subidos?**
R: Usa `php spark migrate:cloudinary` para migrarlos, o déjalos locales (nuevos archivos usarán Cloudinary).

**P: ¿Puedo volver al almacenamiento local?**
R: Sí, solo comenta las credenciales en `.env` y revierte los cambios en los controladores.

---

## 📞 Soporte

- **Documentación oficial**: https://cloudinary.com/documentation/php_integration
- **Dashboard**: https://cloudinary.com/console
- **Status**: https://status.cloudinary.com/

---

## ✨ Próximos Pasos

1. ✅ Crear cuenta en Cloudinary
2. ✅ Configurar credenciales en `.env`
3. ✅ Probar subiendo un beat o foto de perfil
4. ⚠️ (Opcional) Migrar archivos existentes
5. ✅ Eliminar archivos locales después de verificar

---

**¡Todo listo!** 🎉 Ahora tu plataforma CHOJIN usa almacenamiento en la nube profesional.
