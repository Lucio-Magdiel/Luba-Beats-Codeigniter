<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'CHOJIN Beats - Marketplace de Música' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    
    <!-- Estilos Adicionales -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navbar -->
    <?php if (!isset($hideNavbar) || !$hideNavbar): ?>
    <nav class="navbar-modern">
        <div class="container">
            <div class="navbar-content">
                <!-- Logo Mejorado -->
                <a href="<?= base_url() ?>" class="navbar-brand-modern">
                    <div class="logo-icon">
                        <i class="bi bi-music-note-beamed"></i>
                    </div>
                    <div class="logo-text">
                        <span class="logo-main">CHOJIN</span>
                        <span class="logo-sub">Beats</span>
                    </div>
                </a>
                
                <!-- Barra de Búsqueda -->
                <div class="navbar-search">
                    <div class="search-input-wrapper">
                        <i class="bi bi-search search-icon"></i>
                        <input 
                            type="text" 
                            class="search-input" 
                            placeholder="Buscar beats, productores, géneros..."
                            id="navbarSearch"
                        >
                        <button class="search-clear" id="clearSearch" style="display: none;">
                            <i class="bi bi-x-circle-fill"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Desktop Navigation -->
                <ul class="nav-links-modern" id="navLinks">
                    <?php if (session()->has('usuario_id')): ?>
                        <?php 
                        $tipo = session()->get('tipo');
                        $nombre = session()->get('nombre_usuario');
                        $foto_perfil = session()->get('foto_perfil');
                        ?>
                        
                        <!-- Super Admin Menu -->
                        <?php if ($tipo === 'super_admin'): ?>
                            <li><a href="<?= site_url('admin/dashboard') ?>" class="nav-link-modern <?= (uri_string() == 'admin/dashboard' ? 'active' : '') ?>">
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a></li>
                            <li><a href="<?= site_url('admin/usuarios') ?>" class="nav-link-modern <?= (uri_string() == 'admin/usuarios' ? 'active' : '') ?>">
                                <i class="bi bi-people"></i>
                                <span>Usuarios</span>
                            </a></li>
                            <li><a href="<?= site_url('admin/beats') ?>" class="nav-link-modern <?= (uri_string() == 'admin/beats' ? 'active' : '') ?>">
                                <i class="bi bi-music-note-list"></i>
                                <span>Beats</span>
                            </a></li>
                        
                        <!-- Productor Menu -->
                        <?php elseif ($tipo === 'productor'): ?>
                            <li><a href="<?= site_url('productor/panel') ?>" class="nav-link-modern <?= (uri_string() == 'productor/panel' ? 'active' : '') ?>">
                                <i class="bi bi-grid"></i>
                                <span>Mis Beats</span>
                            </a></li>
                            <li><a href="<?= site_url('productor/subir') ?>" class="nav-link-modern <?= (uri_string() == 'productor/subir' ? 'active' : '') ?>">
                                <i class="bi bi-cloud-upload"></i>
                                <span>Subir</span>
                            </a></li>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link-modern">
                                <i class="bi bi-shop"></i>
                                <span>Catálogo</span>
                            </a></li>
                        
                        <!-- Artista Menu -->
                        <?php elseif ($tipo === 'artista'): ?>
                            <li><a href="<?= site_url('artista/panel') ?>" class="nav-link-modern <?= (uri_string() == 'artista/panel' ? 'active' : '') ?>">
                                <i class="bi bi-vinyl"></i>
                                <span>Mis Playlists</span>
                            </a></li>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link-modern">
                                <i class="bi bi-disc"></i>
                                <span>Catálogo</span>
                            </a></li>
                        
                        <!-- Comprador Menu -->
                        <?php else: ?>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link-modern <?= (uri_string() == 'catalogo' ? 'active' : '') ?>">
                                <i class="bi bi-shop"></i>
                                <span>Catálogo</span>
                            </a></li>
                            <li><a href="<?= site_url('usuario/playlists') ?>" class="nav-link-modern">
                                <i class="bi bi-music-note-list"></i>
                                <span>Mis Playlists</span>
                            </a></li>
                        <?php endif; ?>
                        
                        <!-- Notificaciones -->
                        <li class="nav-item-icon">
                            <button class="icon-btn" onclick="toggleNotifications()">
                                <i class="bi bi-bell"></i>
                                <span class="badge-notification">3</span>
                            </button>
                            <div class="dropdown-menu notifications-dropdown" id="notificationsDropdown">
                                <div class="dropdown-header">
                                    <h6>Notificaciones</h6>
                                    <button class="btn-text-sm">Marcar todas como leídas</button>
                                </div>
                                <div class="notifications-list">
                                    <a href="#" class="notification-item unread">
                                        <i class="bi bi-heart-fill text-danger"></i>
                                        <div class="notification-content">
                                            <p><strong>Juan</strong> marcó tu beat como favorito</p>
                                            <small>Hace 5 minutos</small>
                                        </div>
                                    </a>
                                    <a href="#" class="notification-item unread">
                                        <i class="bi bi-cart-check-fill text-success"></i>
                                        <div class="notification-content">
                                            <p>Nueva compra de "Summer Vibes"</p>
                                            <small>Hace 1 hora</small>
                                        </div>
                                    </a>
                                    <a href="#" class="notification-item">
                                        <i class="bi bi-chat-dots-fill text-primary"></i>
                                        <div class="notification-content">
                                            <p>Nuevo comentario en tu beat</p>
                                            <small>Hace 2 horas</small>
                                        </div>
                                    </a>
                                </div>
                                <a href="<?= site_url('notificaciones') ?>" class="dropdown-footer">
                                    Ver todas las notificaciones
                                </a>
                            </div>
                        </li>
                        
                        <!-- User Dropdown Mejorado -->
                        <li class="nav-item-dropdown">
                            <button class="user-btn" onclick="toggleUserDropdown()">
                                <div class="user-avatar">
                                    <?php if (!empty($foto_perfil)): ?>
                                        <img src="<?= asset_url($foto_perfil) ?>" alt="<?= esc($nombre) ?>">
                                    <?php else: ?>
                                        <i class="bi bi-person-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="user-name"><?= esc($nombre) ?></span>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu user-dropdown" id="userDropdown">
                                <div class="dropdown-header">
                                    <div class="user-info">
                                        <div class="user-avatar-large">
                                            <?php if (!empty($foto_perfil)): ?>
                                                <img src="<?= asset_url($foto_perfil) ?>" alt="<?= esc($nombre) ?>">
                                            <?php else: ?>
                                                <i class="bi bi-person-circle"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h6><?= esc($nombre) ?></h6>
                                            <small><?= ucfirst($tipo) ?></small>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= site_url('perfil/' . $nombre) ?>" class="dropdown-item">
                                    <i class="bi bi-person"></i> Ver Perfil Público
                                </a>
                                <a href="<?= site_url('usuario/perfil') ?>" class="dropdown-item">
                                    <i class="bi bi-pencil"></i> Editar Perfil
                                </a>
                                <a href="<?= site_url('usuario/configuracion') ?>" class="dropdown-item">
                                    <i class="bi bi-gear"></i> Configuración
                                </a>
                                <?php if ($tipo === 'productor' || $tipo === 'artista'): ?>
                                <a href="<?= site_url('usuario/estadisticas') ?>" class="dropdown-item">
                                    <i class="bi bi-graph-up"></i> Estadísticas
                                </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="<?= site_url('auth/logout') ?>" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </a>
                            </div>
                        </li>
                        
                    <?php else: ?>
                        <li><a href="<?= site_url('catalogo') ?>" class="nav-link-modern">
                            <i class="bi bi-shop"></i>
                            <span>Catálogo</span>
                        </a></li>
                        <li><a href="<?= site_url('auth/login') ?>" class="btn btn-outline btn-sm">
                            Iniciar Sesión
                        </a></li>
                        <li><a href="<?= site_url('auth/registro') ?>" class="btn btn-primary btn-sm">
                            Registrarse
                        </a></li>
                    <?php endif; ?>
                </ul>
                
                <!-- Mobile Menu Button -->
                <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="main-content">
        <?= $this->renderSection('content') ?>
    </main>
    
    <!-- Footer -->
    <?php if (!isset($hideFooter) || !$hideFooter): ?>
    <footer class="footer">
        <div class="container">
            <div class="grid grid-cols-4 gap-6" style="padding: 3rem 0;">
                <div>
                    <h5 class="text-gradient mb-4">CHOJIN BEATS</h5>
                    <p class="text-sm" style="color: var(--dark-text-secondary);">
                        Marketplace líder de beats y música para productores y artistas.
                    </p>
                </div>
                
                <div>
                    <h6 class="mb-4">Enlaces Rápidos</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('catalogo') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Catálogo</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('productores') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Productores</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('generos') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Géneros</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="mb-4">Soporte</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('ayuda') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Centro de Ayuda</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('terminos') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Términos de Uso</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('privacidad') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Privacidad</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="mb-4">Síguenos</h6>
                    <div class="flex gap-4">
                        <a href="#" class="social-link">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="bi bi-youtube"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding: 2rem 0; text-align: center;">
                <p style="color: var(--dark-text-secondary); margin: 0;">
                    &copy; <?= date('Y') ?> CHOJIN BEATS. Todos los derechos reservados.
                </p>
            </div>
        </div>
    </footer>
    <?php endif; ?>
    
    <!-- Scripts -->
    <script>
        // Variable global para base URL
        const baseUrl = '<?= base_url() ?>';
    </script>
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    
    <!-- Scripts Adicionales -->
    <?= $this->renderSection('scripts') ?>
    
    <style>
        /* ===== NAVBAR MODERNO ===== */
        .navbar-modern {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.75rem 0;
        }
        
        .navbar-content {
            display: flex;
            align-items: center;
            gap: 2rem;
        }
        
        /* Logo Mejorado */
        .navbar-brand-modern {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            transition: transform 0.3s ease;
        }
        
        .navbar-brand-modern:hover {
            transform: translateY(-2px);
        }
        
        .logo-icon {
            width: 42px;
            height: 42px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4);
        }
        
        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .logo-main {
            font-size: 1.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--primary-light), var(--secondary-light));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .logo-sub {
            font-size: 0.7rem;
            color: var(--dark-text-secondary);
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        /* Barra de Búsqueda */
        .navbar-search {
            flex: 1;
            max-width: 500px;
        }
        
        .search-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .search-icon {
            position: absolute;
            left: 1rem;
            color: var(--dark-text-secondary);
            font-size: 1.1rem;
        }
        
        .search-input {
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 3rem;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            color: var(--dark-text);
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            background: rgba(30, 41, 59, 0.8);
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        }
        
        .search-input::placeholder {
            color: var(--dark-text-secondary);
        }
        
        .search-clear {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            color: var(--dark-text-secondary);
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        
        .search-clear:hover {
            color: var(--dark-text);
        }
        
        /* Navigation Links Modernos */
        .nav-links-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-link-modern {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1rem;
            color: var(--dark-text-secondary);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        .nav-link-modern:hover {
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-light);
        }
        
        .nav-link-modern.active {
            background: rgba(139, 92, 246, 0.15);
            color: var(--primary-light);
        }
        
        .nav-link-modern i {
            font-size: 1.1rem;
        }
        
        /* Iconos del Navbar */
        .nav-item-icon {
            position: relative;
        }
        
        .icon-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--dark-text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .icon-btn:hover {
            background: rgba(139, 92, 246, 0.2);
            border-color: var(--primary);
            color: var(--primary-light);
        }
        
        .badge-notification {
            position: absolute;
            top: -4px;
            right: -4px;
            background: var(--danger);
            color: white;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 0.125rem 0.375rem;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
        }
        
        /* User Button */
        .user-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.375rem 0.75rem 0.375rem 0.375rem;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            color: var(--dark-text);
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .user-btn:hover {
            background: rgba(139, 92, 246, 0.2);
            border-color: var(--primary);
        }
        
        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            overflow: hidden;
        }
        
        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-name {
            font-size: 0.95rem;
            font-weight: 500;
        }
        
        /* Dropdowns Mejorados */
        .dropdown-menu {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            min-width: 280px;
            background: rgba(30, 41, 59, 0.98);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-lg);
            padding: 0.5rem;
            display: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            z-index: 1000;
        }
        
        .dropdown-menu.show {
            display: block;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-header {
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 0.5rem;
        }
        
        .dropdown-header h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--dark-text);
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .user-avatar-large {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.75rem;
            overflow: hidden;
        }
        
        .user-avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--dark-text);
            text-decoration: none;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }
        
        .dropdown-item:hover {
            background: rgba(139, 92, 246, 0.15);
            color: var(--primary-light);
        }
        
        .dropdown-item i {
            width: 20px;
            text-align: center;
        }
        
        .dropdown-item.text-danger {
            color: var(--danger);
        }
        
        .dropdown-item.text-danger:hover {
            background: rgba(239, 68, 68, 0.15);
        }
        
        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }
        
        .dropdown-footer {
            display: block;
            padding: 0.75rem;
            text-align: center;
            color: var(--primary-light);
            text-decoration: none;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 0.5rem;
            font-size: 0.9rem;
            transition: background 0.2s;
        }
        
        .dropdown-footer:hover {
            background: rgba(139, 92, 246, 0.1);
        }
        
        /* Notificaciones */
        .notifications-dropdown {
            width: 360px;
        }
        
        .dropdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .btn-text-sm {
            background: none;
            border: none;
            color: var(--primary-light);
            font-size: 0.85rem;
            cursor: pointer;
            padding: 0;
        }
        
        .btn-text-sm:hover {
            text-decoration: underline;
        }
        
        .notifications-list {
            max-height: 400px;
            overflow-y: auto;
        }
        
        .notification-item {
            display: flex;
            gap: 0.75rem;
            padding: 0.75rem;
            text-decoration: none;
            color: var(--dark-text);
            border-radius: var(--radius);
            transition: background 0.2s;
        }
        
        .notification-item:hover {
            background: rgba(255, 255, 255, 0.05);
        }
        
        .notification-item.unread {
            background: rgba(139, 92, 246, 0.05);
        }
        
        .notification-item i {
            font-size: 1.5rem;
            margin-top: 0.25rem;
        }
        
        .notification-content p {
            margin: 0 0 0.25rem 0;
            font-size: 0.9rem;
        }
        
        .notification-content small {
            color: var(--dark-text-secondary);
            font-size: 0.8rem;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
        }
        
        .mobile-menu-btn span {
            width: 24px;
            height: 2px;
            background: var(--dark-text);
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        
        .mobile-menu-btn.active span:nth-child(1) {
            transform: rotate(45deg) translateY(7px);
        }
        
        .mobile-menu-btn.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-menu-btn.active span:nth-child(3) {
            transform: rotate(-45deg) translateY(-7px);
        }
        
        /* Responsive */
        @media (max-width: 1024px) {
            .navbar-search {
                max-width: 300px;
            }
            
            .nav-link-modern span {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-content {
                gap: 1rem;
            }
            
            .navbar-search {
                display: none;
            }
            
            .nav-links-modern {
                display: none;
                position: fixed;
                top: 64px;
                left: 0;
                right: 0;
                background: rgba(15, 23, 42, 0.98);
                backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
                max-height: calc(100vh - 64px);
                overflow-y: auto;
            }
            
            .nav-links-modern.show {
                display: flex;
            }
            
            .nav-link-modern {
                width: 100%;
                justify-content: flex-start;
            }
            
            .nav-link-modern span {
                display: inline;
            }
            
            .mobile-menu-btn {
                display: flex;
            }
            
            .logo-text {
                display: none;
            }
            
            .user-name {
                display: none;
            }
        }
        
        /* Estilos adicionales para el layout */
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 2rem 0;
        }
        
        .footer {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(10px);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 4rem;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: rgba(139, 92, 246, 0.1);
            color: var(--primary-light);
            text-decoration: none;
            transition: var(--transition);
        }
        
        .social-link:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }
        
        .nav-item-dropdown {
            position: relative;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 0.5rem;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            padding: 0.5rem;
            min-width: 200px;
            display: none;
            box-shadow: var(--shadow-xl);
            z-index: 1000;
        }
        
        .dropdown-menu.show {
            display: block;
            animation: fadeIn 0.2s ease-out;
        }
        
        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--dark-text);
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: var(--transition-fast);
        }
        
        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .dropdown-item.text-danger {
            color: var(--danger);
        }
        
        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.1);
            margin: 0.5rem 0;
        }
        
        .mobile-menu-btn {
            display: none;
        }
        
        @media (max-width: 768px) {
            .nav-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: rgba(15, 23, 42, 0.98);
                backdrop-filter: blur(10px);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
                padding: 1rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .nav-links.show {
                display: flex;
            }
            
            .mobile-menu-btn {
                display: inline-flex;
            }
            
            .footer .grid-cols-4 {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
    </style>
</body>
</html>
