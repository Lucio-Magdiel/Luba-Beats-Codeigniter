<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | CHOJIN Beats</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <div class="container container-sm auth-container">
        <div class="card auth-card">
            <!-- Logo -->
            <div class="auth-logo">
                <h1 class="text-gradient">
                    <i class="bi bi-music-note-beamed"></i> CHOJIN BEATS
                </h1>
                <p>Marketplace de Beats Premium</p>
            </div>
            
            <!-- Título -->
            <h2 class="auth-title">Iniciar Sesión</h2>
            
            <!-- Mensaje de Error -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger fade-in">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Mensaje de Éxito -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success fade-in">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= esc(session()->getFlashdata('success')) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Formulario -->
            <form method="post" action="<?= site_url('auth/procesar_login') ?>" autocomplete="off">
                <?= csrf_field() ?>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="correo" name="correo" class="form-control" 
                               placeholder="tu@email.com" required autofocus>
                    </div>
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" 
                               placeholder="••••••••" required>
                    </div>
                </div>
                
                <!-- Botón Submit -->
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Iniciar Sesión
                </button>
            </form>
            
            <!-- Separador -->
            <div class="auth-separator">
                <span>¿No tienes cuenta?</span>
            </div>
            
            <!-- Registro -->
            <a href="<?= site_url('auth/registro') ?>" class="btn btn-outline" style="width: 100%;">
                <i class="bi bi-person-plus"></i>
                Crear Cuenta Nueva
            </a>
        </div>
        
        <!-- Footer -->
        <div class="auth-footer mt-6">
            <p>&copy; <?= date('Y') ?> CHOJIN BEATS · Todos los derechos reservados</p>
            <p class="mt-2">Desarrollado por <a href="<?= site_url('magdiel') ?>">LUBA</a></p>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
