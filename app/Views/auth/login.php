<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | LubaBeats Beta</title>
    
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
                    <i class="bi bi-music-note-beamed"></i> LUBABEATS BETA
                </h1>
                <p>Plataforma Gratuita de Beats</p>
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
                <span>O continúa con</span>
            </div>
            
            <!-- Login con Google -->
            <a href="<?= site_url('auth/google') ?>" class="btn btn-social btn-google" style="width: 100%; margin-bottom: 12px;">
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    <path fill="none" d="M0 0h48v48H0z"/>
                </svg>
                Continuar con Google
            </a>
            
            <!-- Magic Link -->
            <button type="button" class="btn btn-outline" style="width: 100%; margin-bottom: 20px;" onclick="toggleMagicLink()">
                <i class="bi bi-magic"></i>
                Enviar Link Mágico por Email
            </button>
            
            <!-- Formulario Magic Link (oculto inicialmente) -->
            <div id="magic-link-form" style="display: none; margin-bottom: 20px;">
                <form method="post" action="<?= site_url('auth/send-magic-link') ?>">
                    <?= csrf_field() ?>
                    <div class="form-group">
                        <label for="magic-email" class="form-label">Ingresa tu correo</label>
                        <div class="input-group">
                            <i class="bi bi-envelope input-icon"></i>
                            <input type="email" id="magic-email" name="correo" class="form-control" 
                                   placeholder="tu@email.com" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="bi bi-send-fill"></i>
                        Enviar Link
                    </button>
                    <button type="button" class="btn btn-outline mt-2" style="width: 100%;" onclick="toggleMagicLink()">
                        Cancelar
                    </button>
                </form>
            </div>
            
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
            <p>&copy; <?= date('Y') ?> LubaBeats Beta - Plataforma gratuita de la familia LUBA</p>
            <p class="mt-2">Desarrollado por <a href="<?= site_url('magdiel') ?>">LUBA</a></p>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    <script>
        function toggleMagicLink() {
            const form = document.getElementById('magic-link-form');
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }
    </script>
</body>
</html>
