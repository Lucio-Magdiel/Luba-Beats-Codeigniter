# 📸 Sistema de Upload de Avatar y Banner - LubaBeats Beta

## 🎯 Funcionalidad Implementada

Sistema completo de upload de imágenes de perfil (avatar y banner) con integración a Cloudinary.

---

## ✨ Características

### 🔒 **Validación en Cliente (JavaScript)**
- ✅ Validación de tipo de archivo (JPG, PNG, GIF)
- ✅ Validación de tamaño:
  - **Avatar:** Máximo 2MB
  - **Banner:** Máximo 5MB
- ✅ Vista previa en tiempo real antes de subir
- ✅ Indicador visual de archivo seleccionado
- ✅ Feedback inmediato si hay errores

### 🛡️ **Validación en Servidor (PHP)**
- ✅ Validación de extensiones permitidas
- ✅ Validación de tamaño máximo
- ✅ Mensajes de error personalizados
- ✅ Logs de errores para debugging

### ☁️ **Integración con Cloudinary**
- ✅ Upload automático a carpetas organizadas:
  - `chojin/profiles/` → Avatares
  - `chojin/banners/` → Banners
- ✅ Transformaciones automáticas:
  - **Avatar:** 400x400px, crop facial, optimizado
  - **Banner:** 1920x400px, crop centrado, optimizado
- ✅ Optimización de calidad automática
- ✅ Formato automático (WebP si es soportado)
- ✅ URLs seguras (HTTPS)

### 🎨 **Experiencia de Usuario**
- ✅ Preview instantáneo al seleccionar imagen
- ✅ Animación de pulso en botón cuando hay archivo seleccionado
- ✅ Indicador de "Subiendo imágenes..." al enviar
- ✅ Botón de submit deshabilitado durante upload
- ✅ Mensajes de éxito/error claros

---

## 📋 Cómo Usar

### 1️⃣ **Acceder a Mi Perfil**
```
https://lucio.tknegocios.com/chojin/usuario/mi-perfil
```

### 2️⃣ **Subir Avatar**
1. Haz clic en el botón de cámara sobre tu foto de perfil
2. Selecciona una imagen (JPG, PNG o GIF, máx 2MB)
3. Verás un preview instantáneo
4. El botón mostrará "✓ Imagen Seleccionada" con animación
5. Haz clic en "Guardar Cambios"

### 3️⃣ **Subir Banner**
1. Haz clic en "Cambiar Banner" (esquina superior derecha del banner)
2. Selecciona una imagen (JPG, PNG o GIF, máx 5MB)
3. Verás un preview instantáneo
4. El botón mostrará "✓ Imagen Seleccionada" con animación
5. Haz clic en "Guardar Cambios"

### 4️⃣ **Actualizar Biografía**
1. Escribe en el campo de texto (máx 500 caracteres)
2. Haz clic en "Guardar Cambios"

> 💡 **TIP:** Puedes subir avatar, banner y actualizar biografía todo al mismo tiempo

---

## 🔧 Archivos Modificados

### **Backend (PHP)**

#### `app/Controllers/Usuario.php`
```php
public function actualizarPerfil()
```
- Validación de archivos
- Upload a Cloudinary
- Mensajes de feedback mejorados
- Manejo de errores detallado

#### `app/Libraries/CloudinaryService.php`
```php
public function uploadProfilePhoto($filePath, $userId)
public function uploadProfileBanner($filePath, $userId)
```
- Transformaciones optimizadas
- Carpetas organizadas
- Compresión automática

### **Frontend (Views)**

#### `app/Views/usuario/mi_perfil.php`
```javascript
function previewImage(input, previewId)
```
- Validación de tipo de archivo
- Validación de tamaño
- Preview instantáneo
- Indicador visual de selección

### **Estilos (CSS)**

#### `public/assets/css/pages/perfil.css`
```css
.avatar-edit-btn.file-selected
.banner-edit-btn.file-selected
```
- Animación de pulso
- Cambio de color a verde
- Feedback visual

---

## 📦 Estructura de Almacenamiento en Cloudinary

```
chojin/
├── profiles/
│   ├── profile_8.jpg         (Avatar de magdiel)
│   ├── profile_9.jpg
│   └── ...
├── banners/
│   ├── banner_8.jpg          (Banner de magdiel)
│   ├── banner_9.jpg
│   └── ...
├── beats/
│   └── (archivos de audio)
├── visuales/
│   └── (portadas de beats)
└── playlists/
    └── (portadas de playlists)
```

---

## 🎨 Transformaciones Aplicadas

### **Avatar (400x400px)**
```php
[
    'width' => 400,
    'height' => 400,
    'crop' => 'fill',
    'gravity' => 'face',       // Detecta rostros y los centra
    'quality' => 'auto:good',  // Optimización automática
    'fetch_format' => 'auto'   // WebP si es soportado
]
```

### **Banner (1920x400px)**
```php
[
    'width' => 1920,
    'height' => 400,
    'crop' => 'fill',
    'quality' => 'auto:good',
    'fetch_format' => 'auto'
]
```

---

## 🐛 Debugging

### **Ver Logs de Errores**
```bash
tail -f writable/logs/log-2025-10-28.php
```

### **Errores Comunes**

#### 1. "Error al subir foto de perfil"
- Verifica credenciales de Cloudinary en `.env`
- Revisa logs del servidor

#### 2. "La imagen es muy grande"
- Avatar: Máximo 2MB
- Banner: Máximo 5MB
- Comprime la imagen antes de subirla

#### 3. "Tipo de archivo no válido"
- Solo se permiten: JPG, JPEG, PNG, GIF
- Verifica la extensión del archivo

---

## 🔐 Seguridad

### **Validaciones Implementadas**
- ✅ Tipo de archivo (MIME type y extensión)
- ✅ Tamaño de archivo
- ✅ Solo usuarios autenticados
- ✅ Solo el dueño del perfil puede editar
- ✅ CSRF protection (CodeIgniter)
- ✅ Sanitización de inputs
- ✅ URLs seguras (HTTPS)

---

## 🚀 Próximas Mejoras (Opcional)

- [ ] Crop/recorte de imagen antes de subir
- [ ] Filtros de imagen (blanco y negro, sepia, etc)
- [ ] Drag & drop para subir archivos
- [ ] Barra de progreso durante upload
- [ ] Soporte para GIFs animados
- [ ] Eliminar imagen actual (revertir a placeholder)

---

## 📸 Capturas de Pantalla

### **Antes de seleccionar imagen**
- Avatar con placeholder verde
- Banner con gradiente verde
- Botones de cámara normales

### **Después de seleccionar imagen**
- Preview instantáneo de la imagen
- Botón verde con "✓ Imagen Seleccionada"
- Animación de pulso

### **Durante upload**
- Botón de submit deshabilitado
- Texto "Subiendo imágenes..."

### **Después de upload exitoso**
- Mensaje verde de éxito
- Imágenes actualizadas en el perfil
- URLs de Cloudinary en base de datos

---

## 📞 Contacto

**Desarrollador:** Magdiel UCHIHA  
**Plataforma:** LubaBeats Beta  
**Versión:** 1.0.0  
**Fecha:** Octubre 2025

---

✨ **¡Sistema de Upload Completado!** ✨
