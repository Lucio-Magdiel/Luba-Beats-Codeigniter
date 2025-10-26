# Estructura CSS - CHOJIN BEATS

Sistema de estilos modular y organizado siguiendo la metodología BEM y arquitectura ITCSS.

## 📁 Estructura de Carpetas

```
public/assets/css/
├── app.css                 # Archivo principal que importa todos los módulos
├── base/                   # Fundamentos y estilos base
│   ├── variables.css       # Variables CSS (colores, espaciado, etc.)
│   ├── reset.css           # Reset de estilos del navegador
│   └── typography.css      # Tipografía y estilos de texto
├── components/             # Componentes reutilizables
│   ├── buttons.css         # Botones (.btn, .btn-primary, etc.)
│   ├── cards.css           # Tarjetas (.card, .glass, etc.)
│   ├── forms.css           # Formularios (.form-control, .form-group, etc.)
│   ├── alerts.css          # Alertas (.alert, .alert-success, etc.)
│   ├── badges.css          # Badges (.badge, .badge-primary, etc.)
│   ├── tables.css          # Tablas (.table, .table-container, etc.)
│   └── navbar.css          # Navegación (.navbar, .nav-link, etc.)
├── utilities/              # Clases utilitarias
│   ├── layout.css          # Layout (grid, flex, containers)
│   ├── spacing.css         # Márgenes y padding (.mt-4, .p-6, etc.)
│   └── misc.css            # Misceláneas (animaciones, sombras, etc.)
└── pages/                  # Estilos específicos de páginas
    ├── auth.css            # Páginas de autenticación
    └── admin.css           # Panel de administración
```

## 🎨 Uso

### En HTML/PHP

```php
<!-- Solo importar el archivo principal -->
<link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
```

### Clases Disponibles

#### Botones
```html
<button class="btn btn-primary">Primario</button>
<button class="btn btn-secondary">Secundario</button>
<button class="btn btn-outline">Outline</button>
<button class="btn btn-ghost">Ghost</button>
<button class="btn btn-sm">Pequeño</button>
<button class="btn btn-lg">Grande</button>
```

#### Cards
```html
<div class="card">
    <div class="card-header">Encabezado</div>
    <div class="card-body">Contenido</div>
    <div class="card-footer">Pie</div>
</div>
```

#### Formularios
```html
<div class="form-group">
    <label class="form-label">Email</label>
    <div class="input-group">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" class="form-control">
    </div>
</div>
```

#### Layout
```html
<div class="container">              <!-- Contenedor centrado -->
    <div class="grid grid-cols-3">   <!-- Grid de 3 columnas -->
        <div class="card">...</div>
    </div>
</div>

<div class="flex justify-between items-center">
    <div>Izquierda</div>
    <div>Derecha</div>
</div>
```

#### Alertas
```html
<div class="alert alert-success">Éxito</div>
<div class="alert alert-danger">Error</div>
<div class="alert alert-warning">Advertencia</div>
<div class="alert alert-info">Información</div>
```

#### Badges
```html
<span class="badge badge-primary">Nuevo</span>
<span class="badge badge-success">Activo</span>
<span class="badge badge-danger">Bloqueado</span>
```

#### Utilidades de Espaciado
```html
<div class="mt-4">   <!-- Margin top 1rem -->
<div class="mb-6">   <!-- Margin bottom 1.5rem -->
<div class="p-4">    <!-- Padding 1rem -->
<div class="py-6">   <!-- Padding vertical 1.5rem -->
```

## 🎯 Variables CSS

Todas las variables están en `base/variables.css`:

```css
--primary: #8b5cf6
--secondary: #ec4899
--success: #10b981
--danger: #ef4444
--warning: #f59e0b
--info: #3b82f6

--radius: 0.5rem
--radius-lg: 1rem
--shadow-lg: ...
--transition: all 0.3s ...
```

## 📝 Buenas Prácticas

1. **NO uses estilos inline** en las vistas
2. **Usa clases CSS** en lugar de `style="..."`
3. **Crea nuevos archivos** en la carpeta correspondiente si necesitas estilos específicos
4. **Documenta** cualquier clase nueva que agregues
5. **Sigue la convención** de nombres existente

## 🔄 Agregar Nuevos Estilos

### Para una nueva página:
1. Crear archivo en `pages/nombre-pagina.css`
2. Importarlo en `app.css`: `@import 'pages/nombre-pagina.css';`

### Para un nuevo componente:
1. Crear archivo en `components/nombre-componente.css`
2. Importarlo en `app.css`: `@import 'components/nombre-componente.css';`

## 📱 Responsive

El sistema es mobile-first con breakpoint en 768px:

```css
@media (max-width: 768px) {
    /* Estilos móviles */
}
```

## 🎨 Tema

Actualmente solo tema oscuro. Para agregar tema claro:
1. Agregar variables en `base/variables.css`
2. Usar `@media (prefers-color-scheme: light)`
