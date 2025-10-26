<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - CHOJIN</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/variables.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/typography.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/buttons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/forms.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/perfil.css') ?>">
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <a href="<?= base_url('/') ?>">
                    <i class="bi bi-music-note-beamed"></i>
                    <span>CHOJIN</span>
                </a>
            </div>
            <nav class="header-nav">
                <a href="<?= base_url('/catalogo') ?>">
                    <i class="bi bi-grid"></i>
                    <span>Catálogo</span>
                </a>
                <a href="<?= base_url('/usuario/playlists') ?>">
                    <i class="bi bi-music-note-list"></i>
                    <span>Mis Playlists</span>
                </a>
                <a href="<?= base_url('/usuario/mi-perfil') ?>" class="active">
                    <i class="bi bi-person-circle"></i>
                    <span>Mi Perfil</span>
                </a>
            </nav>
            <div class="header-actions">
                <a href="<?= base_url('/auth/logout') ?>" class="btn-secondary">
                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <main class="perfil-container">
        <div class="perfil-header">
            <div class="banner-wrapper">
                <?php if (!empty($usuario['banner'])): ?>
                    <img src="<?= asset_url($usuario['banner']) ?>" 
                         alt="Banner" 
                         class="banner-image"
                         id="bannerPreview">
                <?php else: ?>
                    <div class="banner-image banner-placeholder" id="bannerPreview"></div>
                <?php endif; ?>
                <label for="bannerInput" class="banner-edit-btn">
                    <i class="bi bi-camera"></i>
                    Cambiar Banner
                </label>
            </div>
            
            <div class="perfil-info">
                <div class="avatar-wrapper">
                    <?php if (!empty($usuario['foto_perfil'])): ?>
                        <img src="<?= asset_url($usuario['foto_perfil']) ?>" 
                             alt="<?= esc($usuario['nombre_usuario']) ?>" 
                             class="avatar-image"
                             id="avatarPreview">
                    <?php else: ?>
                        <div class="avatar-image avatar-placeholder" id="avatarPreview">
                            <i class="bi bi-person-circle"></i>
                        </div>
                    <?php endif; ?>
                    <label for="avatarInput" class="avatar-edit-btn">
                        <i class="bi bi-camera"></i>
                    </label>
                </div>
                
                <div class="perfil-details">
                    <h1 class="perfil-nombre"><?= esc($usuario['nombre_usuario']) ?></h1>
                    <p class="perfil-username">@<?= esc($usuario['nombre_usuario']) ?></p>
                    <span class="perfil-badge perfil-badge-<?= esc($usuario['tipo']) ?>">
                        <?php
                        $tipos = [
                            'super_admin' => 'Super Admin',
                            'productor' => 'Productor',
                            'artista' => 'Artista',
                            'comprador' => 'Usuario'
                        ];
                        echo $tipos[$usuario['tipo']] ?? 'Usuario';
                        ?>
                    </span>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('mensaje') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">
                <i class="bi bi-exclamation-circle"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="perfil-content">
            <form action="<?= base_url('/usuario/actualizar-perfil') ?>" method="POST" enctype="multipart/form-data" class="perfil-form">
                <?= csrf_field() ?>
                
                <input type="file" 
                       id="avatarInput" 
                       name="foto_perfil" 
                       accept="image/*" 
                       class="file-input-hidden"
                       onchange="previewImage(this, 'avatarPreview')">
                
                <input type="file" 
                       id="bannerInput" 
                       name="banner" 
                       accept="image/*" 
                       class="file-input-hidden"
                       onchange="previewImage(this, 'bannerPreview')">

                <div class="form-section">
                    <h2 class="section-title">
                        <i class="bi bi-info-circle"></i>
                        Información Personal
                    </h2>
                    
                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre de Usuario</label>
                        <input type="text" 
                               id="nombre" 
                               class="form-input" 
                               value="<?= esc($usuario['nombre_usuario']) ?>" 
                               readonly>
                        <small class="form-help">El nombre de usuario no se puede modificar</small>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" 
                               id="email" 
                               class="form-input" 
                               value="<?= esc($usuario['correo']) ?>" 
                               readonly>
                        <small class="form-help">El email no se puede modificar</small>
                    </div>

                    <div class="form-group">
                        <label for="bio" class="form-label">Biografía</label>
                        <textarea id="bio" 
                                  name="bio" 
                                  class="form-textarea" 
                                  rows="5" 
                                  maxlength="500" 
                                  placeholder="Cuéntanos sobre ti..."><?= esc($usuario['bio'] ?? '') ?></textarea>
                        <small class="form-help">Máximo 500 caracteres</small>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="<?= base_url('/catalogo') ?>" class="btn-secondary">
                        <i class="bi bi-x-circle"></i>
                        Cancelar
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-circle"></i>
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function previewImage(input, previewId) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                const previewElement = document.getElementById(previewId);
                
                reader.onload = function(e) {
                    // Si es un placeholder (div), convertirlo a imagen
                    if (previewElement.tagName === 'DIV') {
                        const img = document.createElement('img');
                        img.id = previewId;
                        img.className = previewElement.className.replace('placeholder', '').trim();
                        img.src = e.target.result;
                        previewElement.parentNode.replaceChild(img, previewElement);
                    } else {
                        previewElement.src = e.target.result;
                    }
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
