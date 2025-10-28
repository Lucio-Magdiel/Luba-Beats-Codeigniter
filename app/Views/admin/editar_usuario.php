<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario | Admin</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
    <div class="container py-4" style="max-width: 600px;">
        <h1 class="text-gradient mb-6">
            <i class="bi bi-pencil-square"></i> Editar Usuario
        </h1>

        <form method="post" class="card">
            <?= csrf_field() ?>

            <div class="form-group">
                <label class="form-label">Nombre de Usuario</label>
                <input type="text" 
                       name="nombre_usuario" 
                       value="<?= esc($usuario['nombre_usuario']) ?>" 
                       class="form-control" 
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" 
                       name="correo" 
                       value="<?= esc($usuario['correo']) ?>" 
                       class="form-control" 
                       required>
            </div>

            <div class="form-group">
                <label class="form-label">Tipo de Usuario</label>
                <select name="tipo" class="form-control" required>
                    <option value="super_admin" <?= $usuario['tipo'] == 'super_admin' ? 'selected' : '' ?>>Super Admin</option>
                    <option value="productor" <?= $usuario['tipo'] == 'productor' ? 'selected' : '' ?>>Productor</option>
                    <option value="artista" <?= $usuario['tipo'] == 'artista' ? 'selected' : '' ?>>Artista</option>
                    <option value="comprador" <?= $usuario['tipo'] == 'comprador' ? 'selected' : '' ?>>Comprador</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Nueva Contraseña (opcional)</label>
                <input type="password" 
                       name="nueva_contrasena" 
                       class="form-control" 
                       placeholder="Dejar vacío para mantener la actual">
                <small style="color: var(--gray-400); font-size: 0.875rem; display: block; margin-top: 0.5rem;">
                    Solo completa si deseas cambiar la contraseña
                </small>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="btn btn-primary flex-1">
                    <i class="bi bi-save-fill"></i> Guardar Cambios
                </button>
                <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-ghost">
                    <i class="bi bi-x-circle"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
    
    <!-- Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
