<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Completar Perfil | LubaBeats Beta</title>
    
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
            <h2 class="auth-title">¡Un paso más!</h2>
            <p style="text-align: center; color: var(--text-secondary); margin-bottom: 20px;">
                <?php if ($provider === 'google'): ?>
                    <i class="bi bi-google" style="color: #4285F4;"></i> Iniciaste sesión con Google
                <?php else: ?>
                    <i class="bi bi-magic" style="color: var(--accent-color);"></i> Usaste un link mágico
                <?php endif; ?>
            </p>
            
            <div style="background: rgba(30, 215, 96, 0.08); border: 1px solid rgba(30, 215, 96, 0.2); border-radius: 12px; padding: 12px 16px; margin-bottom: 28px;">
                <p style="text-align: center; color: var(--text-primary); margin: 0; font-size: 14px;">
                    <i class="bi bi-shield-check" style="color: var(--accent-color);"></i>
                    <strong><?= esc($email) ?></strong>
                </p>
            </div>
            
            <!-- Mensaje de Error de Validación -->
            <?php if(isset($validation)): ?>
                <div class="alert alert-danger fade-in">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span><?= $validation->listErrors() ?></span>
                </div>
            <?php endif; ?>
            
            <!-- Formulario -->
            <form method="post" action="<?= site_url('auth/procesar-completar-perfil') ?>" autocomplete="off">
                <?= csrf_field() ?>
                
                <!-- Nombre de Usuario -->
                <div class="form-group">
                    <label for="nombre_usuario" class="form-label">
                        Nombre de Usuario <span style="color: var(--accent-color);">*</span>
                    </label>
                    <div class="input-group">
                        <i class="bi bi-person input-icon"></i>
                        <input type="text" id="nombre_usuario" name="nombre_usuario" class="form-control" 
                               placeholder="Ej: <?= esc($nombre) ?>" 
                               value="<?= old('nombre_usuario', $nombre) ?>" 
                               required autofocus>
                    </div>
                    <small style="color: var(--text-secondary); font-size: 12px; margin-top: 4px; display: block;">
                        <i class="bi bi-info-circle"></i> Mínimo 3 caracteres. Solo letras, números y espacios.
                    </small>
                </div>
                
                <!-- Tipo de Usuario -->
                <div class="form-group">
                    <label for="tipo" class="form-label">
                        ¿Qué tipo de cuenta quieres? <span style="color: var(--accent-color);">*</span>
                    </label>
                    <div class="tipo-usuario-grid">
                        <!-- Productor -->
                        <label class="tipo-card <?= old('tipo') === 'productor' ? 'selected' : '' ?>">
                            <input type="radio" name="tipo" value="productor" 
                                   <?= old('tipo') === 'productor' ? 'checked' : '' ?> required>
                            <div class="tipo-card-content">
                                <div class="tipo-icon">
                                    <i class="bi bi-headphones"></i>
                                </div>
                                <div class="tipo-info">
                                    <h4>Productor</h4>
                                    <p>Sube y vende tus beats</p>
                                </div>
                                <div class="tipo-check">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Artista -->
                        <label class="tipo-card <?= old('tipo') === 'artista' ? 'selected' : '' ?>">
                            <input type="radio" name="tipo" value="artista" 
                                   <?= old('tipo') === 'artista' ? 'checked' : '' ?> required>
                            <div class="tipo-card-content">
                                <div class="tipo-icon">
                                    <i class="bi bi-mic-fill"></i>
                                </div>
                                <div class="tipo-info">
                                    <h4>Artista</h4>
                                    <p>Comparte y sube tu música</p>
                                </div>
                                <div class="tipo-check">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </label>
                        
                        <!-- Usuario -->
                        <label class="tipo-card <?= old('tipo') === 'comprador' || !old('tipo') ? 'selected' : '' ?>">
                            <input type="radio" name="tipo" value="comprador" 
                                   <?= old('tipo') === 'comprador' || !old('tipo') ? 'checked' : '' ?> required>
                            <div class="tipo-card-content">
                                <div class="tipo-icon">
                                    <i class="bi bi-music-note-list"></i>
                                </div>
                                <div class="tipo-info">
                                    <h4>Usuario</h4>
                                    <p>Explora música y crea playlists</p>
                                </div>
                                <div class="tipo-check">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
                
                <!-- Botón Submit -->
                <button type="submit" class="btn btn-primary btn-large" style="width: 100%; margin-top: 24px; padding: 16px; font-size: 16px; font-weight: 600;">
                    <i class="bi bi-rocket-takeoff"></i>
                    Comenzar en LubaBeats Beta
                </button>
            </form>
            
            <!-- Información adicional -->
            <div style="margin-top: 20px; padding: 14px; background: rgba(255, 255, 255, 0.02); border-radius: 10px; border: 1px solid rgba(255, 255, 255, 0.05);">
                <p style="font-size: 12px; color: var(--text-secondary); margin: 0; text-align: center; line-height: 1.5;">
                    <i class="bi bi-info-circle" style="color: var(--accent-color);"></i>
                    Podrás cambiar tu nombre de usuario y tipo de cuenta más tarde en tu perfil
                </p>
            </div>
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
        // Manejar selección visual de las tarjetas de tipo
        document.querySelectorAll('.tipo-card input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                // Remover 'selected' de todas
                document.querySelectorAll('.tipo-card').forEach(card => {
                    card.classList.remove('selected');
                });
                
                // Agregar 'selected' a la seleccionada
                if (this.checked) {
                    this.closest('.tipo-card').classList.add('selected');
                }
            });
        });
    </script>
</body>
</html>
