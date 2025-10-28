<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta | LubaBeats Beta</title>
    
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
    <div class="container container-md auth-container">
        <div class="card auth-card" style="max-width: 520px;">
            <!-- Logo -->
            <div class="auth-logo">
                <h1 class="text-gradient">
                    <i class="bi bi-music-note-beamed"></i> LUBABEATS BETA
                </h1>
                <p>Únete a nuestra comunidad de música</p>
            </div>
            
            <!-- Título -->
            <h2 class="auth-title">Crear Cuenta</h2>
            
            <!-- Mensaje de Error -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger fade-in">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= esc(session()->getFlashdata('error')) ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Formulario -->
            <form method="post" action="<?= site_url('auth/procesar_registro') ?>" autocomplete="off">
                <?= csrf_field() ?>
                
                <!-- Nombre de usuario -->
                <div class="form-group">
                    <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                    <div class="input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" 
                               placeholder="Tu nombre de usuario" required autofocus>
                    </div>
                </div>
                
                <!-- Email -->
                <div class="form-group">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" id="correo" name="correo" class="form-control" 
                               placeholder="tu@email.com" required>
                    </div>
                </div>
                
                <!-- Password -->
                <div class="form-group">
                    <label for="contrasena" class="form-label">Contraseña</label>
                    <div class="input-group">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" id="contrasena" name="contrasena" class="form-control" 
                               placeholder="Mínimo 8 caracteres" required>
                    </div>
                </div>
                
                <!-- Tipo de usuario -->
                <div class="form-group">
                    <label for="tipo" class="form-label">¿Qué tipo de cuenta quieres?</label>
                    <select id="tipo" name="tipo" class="form-control" required>
                        <option value="">Selecciona una opción</option>
                        <option value="productor">🎹 Productor - Vende tus beats</option>
                        <option value="artista">🎤 Artista - Comparte tu música gratis</option>
                        <option value="comprador">👤 Comprador/Fan - Descubre música nueva</option>
                    </select>
                </div>
                
                <!-- Botón Submit -->
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="bi bi-person-plus"></i>
                    Crear Mi Cuenta
                </button>
            </form>
            
            <!-- Separador -->
            <div class="auth-separator">
                <span>¿Ya tienes cuenta?</span>
            </div>
            
            <!-- Login -->
            <a href="<?= site_url('auth/login') ?>" class="btn btn-outline" style="width: 100%;">
                <i class="bi bi-box-arrow-in-right"></i>
                Iniciar Sesión
            </a>
        </div>
        
        <!-- Footer -->
        <div class="auth-footer mt-6">
            <p>&copy; <?= date('Y') ?> LubaBeats Beta - Plataforma gratuita de la familia LUBA</p>
            <p class="mt-2">Desarrollado por <a href="<?= site_url('magdiel') ?>">LUBA</a></p>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
