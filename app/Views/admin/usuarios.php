<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios | Admin CHOJIN</title>
    
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
    <div class="container py-4">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-gradient">
                <i class="bi bi-people-fill"></i> Gestión de Usuarios
            </h1>
            <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-ghost">
                <i class="bi bi-arrow-left"></i> Volver al Dashboard
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success mb-4">
                <?= esc(session()->getFlashdata('mensaje')) ?>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger mb-4">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <!-- Search Form -->
        <form method="get" class="mb-6">
            <div class="flex gap-4">
                <input type="text" 
                       name="buscar" 
                       placeholder="Buscar por nombre o correo..." 
                       value="<?= esc($this->request->getGet('buscar')) ?>"
                       class="form-control flex-1">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Buscar
                </button>
                <?php if($this->request->getGet('buscar')): ?>
                    <a href="<?= site_url('admin/usuarios') ?>" class="btn btn-ghost">
                        <i class="bi bi-x-circle"></i> Limpiar
                    </a>
                <?php endif; ?>
            </div>
        </form>

        <!-- Users Table -->
        <div class="card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuario</th>
                            <th>Correo</th>
                            <th>Tipo</th>
                            <th>Registro</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($usuarios as $usuario): ?>
                            <tr>
                                <td><?= $usuario['id'] ?></td>
                                <td style="font-weight: 600;"><?= esc($usuario['nombre_usuario']) ?></td>
                                <td style="color: var(--gray-300);"><?= esc($usuario['correo']) ?></td>
                                <td>
                                    <?php
                                    $badges = [
                                        'super_admin' => '<span class="badge badge-danger"><i class="bi bi-shield-fill"></i> Super Admin</span>',
                                        'productor' => '<span class="badge badge-primary"><i class="bi bi-mic-fill"></i> Productor</span>',
                                        'artista' => '<span class="badge badge-warning"><i class="bi bi-star-fill"></i> Artista</span>',
                                        'comprador' => '<span class="badge badge-success"><i class="bi bi-person-fill"></i> Comprador</span>',
                                    ];
                                    echo $badges[$usuario['tipo']] ?? '<span class="badge">Usuario</span>';
                                    ?>
                                </td>
                                <td style="color: var(--gray-400); font-size: 0.875rem;">
                                    <?= date('d/m/Y', strtotime($usuario['fecha_registro'] ?? 'now')) ?>
                                </td>
                                <td>
                                    <div class="flex gap-2 justify-center">
                                        <a href="<?= site_url('admin/editar-usuario/'.$usuario['id']) ?>" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil-fill"></i> Editar
                                        </a>
                                        <?php if($usuario['tipo'] !== 'super_admin' && $usuario['id'] != session()->get('id')): ?>
                                            <a href="<?= site_url('admin/eliminar-usuario/'.$usuario['id']) ?>" 
                                               onclick="return confirm('¿Estás seguro de eliminar este usuario?')"
                                               class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash-fill"></i> Eliminar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary -->
        <div class="mt-6 text-center" style="color: var(--gray-400);">
            Total de usuarios: <span style="color: var(--primary); font-weight: 700;"><?= count($usuarios) ?></span>
        </div>
    </div>
    
    <!-- Scripts -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>