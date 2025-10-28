<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'LubaBeats Beta - Plataforma de Beats y Música' ?></title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Estilos Personalizados -->
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css?v=' . time()) ?>">
    
    <!-- Estilos Adicionales -->
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Navbar Premium -->
    <?php if (!isset($hideNavbar) || !$hideNavbar): ?>
    <nav class="navbar-premium">
        <div class="container">
            <div class="navbar-wrapper">
                <!-- Logo Premium -->
                <a href="<?= base_url() ?>" class="brand-premium">
                    <div class="brand-text">
                        <span class="brand-name">
                            <span style="color: #1ed760;">LUBA</span><span style="color: #fff;">Beats</span>
                        </span>
                        <span class="brand-tagline">PLATAFORMA BETA</span>
                    </div>
                </a>
                
                <!-- Navigation Links -->
                <div class="nav-center">
                    <ul class="nav-menu" id="navLinks">
                        <?php if (session()->has('usuario_id')): ?>
                            <?php 
                            $tipo = session()->get('tipo');
                            $nombre = session()->get('nombre_usuario');
                            $foto_perfil = session()->get('foto_perfil');
                            ?>
                            
                            <!-- Super Admin Menu -->
                            <?php if ($tipo === 'super_admin'): ?>
                                <li><a href="<?= site_url('admin/dashboard') ?>" class="nav-item <?= (uri_string() == 'admin/dashboard' ? 'active' : '') ?>">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard</span>
                                </a></li>
                                <li><a href="<?= site_url('admin/usuarios') ?>" class="nav-item <?= (uri_string() == 'admin/usuarios' ? 'active' : '') ?>">
                                    <i class="bi bi-people"></i>
                                    <span>Usuarios</span>
                                </a></li>
                                <li><a href="<?= site_url('admin/beats') ?>" class="nav-item <?= (uri_string() == 'admin/beats' ? 'active' : '') ?>">
                                    <i class="bi bi-music-note-list"></i>
                                    <span>Beats</span>
                                </a></li>
                            
                            <!-- Productor Menu -->
                            <?php elseif ($tipo === 'productor'): ?>
                                <li><a href="<?= site_url('productor/panel') ?>" class="nav-item <?= (uri_string() == 'productor/panel' ? 'active' : '') ?>">
                                    <i class="bi bi-grid"></i>
                                    <span>Mis Beats</span>
                                </a></li>
                                <li><a href="<?= site_url('productor/subir') ?>" class="nav-item <?= (uri_string() == 'productor/subir' ? 'active' : '') ?>">
                                    <i class="bi bi-cloud-upload"></i>
                                    <span>Subir</span>
                                </a></li>
                                <li><a href="<?= site_url('catalogo') ?>" class="nav-item">
                                    <i class="bi bi-shop"></i>
                                    <span>Explorar</span>
                                </a></li>
                            
                            <!-- Artista Menu -->
                            <?php elseif ($tipo === 'artista'): ?>
                                <li><a href="<?= site_url('artista/panel') ?>" class="nav-item <?= (uri_string() == 'artista/panel' ? 'active' : '') ?>">
                                    <i class="bi bi-vinyl"></i>
                                    <span>Mis Playlists</span>
                                </a></li>
                                <li><a href="<?= site_url('catalogo') ?>" class="nav-item">
                                    <i class="bi bi-disc"></i>
                                    <span>Explorar</span>
                                </a></li>
                            
                            <!-- Comprador Menu -->
                            <?php else: ?>
                                <li><a href="<?= site_url('catalogo') ?>" class="nav-item <?= (uri_string() == 'catalogo' ? 'active' : '') ?>">
                                    <i class="bi bi-shop"></i>
                                    <span>Explorar</span>
                                </a></li>
                                <li><a href="<?= site_url('usuario/playlists') ?>" class="nav-item">
                                    <i class="bi bi-music-note-list"></i>
                                    <span>Playlists</span>
                                </a></li>
                            <?php endif; ?>
                            
                        <?php else: ?>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-item">
                                <i class="bi bi-shop"></i>
                                <span>Explorar</span>
                            </a></li>
                            <li><a href="<?= site_url('productores') ?>" class="nav-item">
                                <i class="bi bi-people"></i>
                                <span>Productores</span>
                            </a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Right Actions -->
                <div class="nav-actions">
                    <?php if (session()->has('usuario_id')): ?>
                        <!-- Notifications -->
                        <div class="action-item">
                            <button class="action-btn" onclick="toggleNotifications()" title="Notificaciones">
                                <i class="bi bi-bell"></i>
                                <span class="notification-dot"></span>
                            </button>
                            <div class="dropdown notifications-dropdown" id="notificationsDropdown">
                                <div class="dropdown-head">
                                    <h6>Notificaciones</h6>
                                    <button class="link-btn">Marcar leídas</button>
                                </div>
                                <div class="notifications-list">
                                    <a href="#" class="notification unread">
                                        <div class="notification-icon bg-danger">
                                            <i class="bi bi-heart-fill"></i>
                                        </div>
                                        <div class="notification-body">
                                            <p><strong>Juan</strong> marcó tu beat como favorito</p>
                                            <small>Hace 5 min</small>
                                        </div>
                                    </a>
                                    <a href="#" class="notification unread">
                                        <div class="notification-icon bg-success">
                                            <i class="bi bi-cart-check-fill"></i>
                                        </div>
                                        <div class="notification-body">
                                            <p>Nueva compra de "Summer Vibes"</p>
                                            <small>Hace 1 hora</small>
                                        </div>
                                    </a>
                                    <a href="#" class="notification">
                                        <div class="notification-icon bg-primary">
                                            <i class="bi bi-chat-dots-fill"></i>
                                        </div>
                                        <div class="notification-body">
                                            <p>Nuevo comentario en tu beat</p>
                                            <small>Hace 2 horas</small>
                                        </div>
                                    </a>
                                </div>
                                <a href="<?= site_url('notificaciones') ?>" class="dropdown-foot">
                                    Ver todas
                                </a>
                            </div>
                        </div>
                        
                        <!-- User Menu -->
                        <div class="action-item">
                            <button class="user-menu-btn" onclick="toggleUserDropdown()">
                                <div class="user-photo">
                                    <?php if (!empty($foto_perfil)): ?>
                                        <img src="<?= asset_url($foto_perfil) ?>" alt="<?= esc($nombre) ?>">
                                    <?php else: ?>
                                        <i class="bi bi-person-circle"></i>
                                    <?php endif; ?>
                                </div>
                                <span class="user-name-text"><?= esc($nombre) ?></span>
                                <i class="bi bi-chevron-down chevron"></i>
                            </button>
                            <div class="dropdown user-dropdown" id="userDropdown">
                                <div class="dropdown-head user-info">
                                    <div class="user-photo-large">
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
                                <div class="dropdown-divider"></div>
                                <a href="<?= site_url('perfil/' . $nombre) ?>" class="dropdown-link">
                                    <i class="bi bi-person"></i> Perfil Público
                                </a>
                                <a href="<?= site_url('usuario/perfil') ?>" class="dropdown-link">
                                    <i class="bi bi-pencil"></i> Editar Perfil
                                </a>
                                <a href="<?= site_url('usuario/configuracion') ?>" class="dropdown-link">
                                    <i class="bi bi-gear"></i> Configuración
                                </a>
                                <?php if ($tipo === 'productor' || $tipo === 'artista'): ?>
                                <a href="<?= site_url('usuario/estadisticas') ?>" class="dropdown-link">
                                    <i class="bi bi-graph-up"></i> Estadísticas
                                </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="<?= site_url('auth/logout') ?>" class="dropdown-link danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </a>
                            </div>
                        </div>
                        
                    <?php else: ?>
                        <a href="<?= site_url('auth/login') ?>" class="btn-ghost">
                            Iniciar Sesión
                        </a>
                        <a href="<?= site_url('auth/registro') ?>" class="btn-gradient">
                            Comenzar
                        </a>
                    <?php endif; ?>
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-toggle" onclick="toggleMobileMenu()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
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
                    <h5 class="text-gradient mb-4">LUBABEATS BETA</h5>
                    <p class="text-sm" style="color: var(--dark-text-secondary);">
                        Plataforma beta gratuita de beats y música para productores y artistas. 
                        Creada por la familia LUBA.
                    </p>
                </div>
                
                <div>
                    <h6 class="mb-4">Enlaces Rápidos</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('catalogo') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Explorar Beats</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('productores') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Productores</a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('about') ?>" style="color: var(--dark-text-secondary); text-decoration: none;">Acerca de</a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="mb-4">Desarrollador</h6>
                    <ul style="list-style: none; padding: 0;">
                        <li style="margin-bottom: 0.5rem;">
                            <a href="<?= site_url('magdiel') ?>" style="color: var(--dark-text-secondary); text-decoration: none; display: flex; align-items: center; gap: 0.5rem;">
                                <i class="bi bi-code-slash"></i> Magdiel UCHIHA
                            </a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="#" style="color: var(--dark-text-secondary); text-decoration: none;">
                                <i class="bi bi-github"></i> GitHub
                            </a>
                        </li>
                        <li style="margin-bottom: 0.5rem;">
                            <a href="#" style="color: var(--dark-text-secondary); text-decoration: none;">
                                <i class="bi bi-linkedin"></i> LinkedIn
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div>
                    <h6 class="mb-4">Síguenos</h6>
                    <div class="flex gap-4">
                        <a href="#" class="social-link" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="#" class="social-link" title="TikTok">
                            <i class="bi bi-tiktok"></i>
                        </a>
                        <a href="#" class="social-link" title="YouTube">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="#" class="social-link" title="Twitter/X">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <div style="border-top: 1px solid rgba(255,255,255,0.1); padding: 2rem 0; text-align: center;">
                <p style="color: var(--dark-text-secondary); margin: 0;">
                    &copy; <?= date('Y') ?> LubaBeats Beta - Plataforma gratuita de la familia LUBA
                </p>
                <p style="color: var(--dark-text-secondary); margin: 0.5rem 0 0 0; font-size: 0.875rem;">
                    Desarrollado con 💜 por <a href="<?= site_url('magdiel') ?>" style="color: var(--primary-light); text-decoration: none; font-weight: 600;">Magdiel UCHIHA</a>
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
        /* ===== NAVBAR PREMIUM STYLE (Inspirado en Nightwatch Laravel) ===== */
        .navbar-premium {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(10, 10, 20, 0.8);
            backdrop-filter: saturate(180%) blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding: 0;
        }
        
        .navbar-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
            gap: 2rem;
        }
        
        /* Brand Premium */
        .brand-premium {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: opacity 0.2s;
        }
        
        .brand-premium:hover {
            opacity: 0.8;
        }
        
        .brand-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        
        .brand-name {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        
        .brand-tagline {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.35);
            font-weight: 600;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-top: 2px;
        }
        
        /* Navigation Center */
        .nav-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }
        
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 4px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            color: rgba(255, 255, 255, 0.65);
            text-decoration: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            position: relative;
        }
        
        .nav-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.9);
        }
        
        .nav-item.active {
            color: #fff;
            background: rgba(139, 92, 246, 0.15);
        }
        
        .nav-item.active::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 2px;
            background: linear-gradient(90deg, #8b5cf6, #ec4899);
            border-radius: 2px 2px 0 0;
        }
        
        .nav-item i {
            font-size: 16px;
        }
        
        /* Right Actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .action-item {
            position: relative;
        }
        
        .action-btn {
            position: relative;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .action-btn:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }
        
        .notification-dot {
            position: absolute;
            top: 8px;
            right: 8px;
            width: 8px;
            height: 8px;
            background: #ef4444;
            border-radius: 50%;
            border: 2px solid rgba(10, 10, 20, 0.8);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        /* User Menu Button */
        .user-menu-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 12px 6px 6px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: #fff;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .user-menu-btn:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
        }
        
        .user-photo {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 18px;
            overflow: hidden;
        }
        
        .user-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .user-name-text {
            font-size: 14px;
            font-weight: 500;
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .chevron {
            font-size: 12px;
            opacity: 0.5;
            transition: transform 0.2s;
        }
        
        .user-menu-btn:hover .chevron {
            transform: translateY(2px);
        }
        
        /* Dropdowns Premium */
        .dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 280px;
            background: rgba(20, 20, 30, 0.98);
            backdrop-filter: saturate(180%) blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 8px;
            display: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            z-index: 1001;
        }
        
        .dropdown.show {
            display: block;
            animation: dropdownSlide 0.2s ease-out;
        }
        
        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-head {
            padding: 12px 16px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            margin-bottom: 4px;
        }
        
        .dropdown-head h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
            color: #fff;
        }
        
        .dropdown-head.user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .user-photo-large {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 24px;
            overflow: hidden;
        }
        
        .user-photo-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .dropdown-head.user-info small {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
        }
        
        .dropdown-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.15s;
            font-size: 14px;
        }
        
        .dropdown-link:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
        }
        
        .dropdown-link.danger {
            color: #f87171;
        }
        
        .dropdown-link.danger:hover {
            background: rgba(248, 113, 113, 0.1);
        }
        
        .dropdown-link i {
            width: 18px;
            text-align: center;
            opacity: 0.7;
        }
        
        .dropdown-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.06);
            margin: 8px 0;
        }
        
        .dropdown-foot {
            display: block;
            padding: 10px 16px;
            text-align: center;
            color: #8b5cf6;
            text-decoration: none;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            margin-top: 4px;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.15s;
        }
        
        .dropdown-foot:hover {
            background: rgba(139, 92, 246, 0.1);
        }
        
        /* Notifications List */
        .notifications-list {
            max-height: 320px;
            overflow-y: auto;
        }
        
        .notification {
            display: flex;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            border-radius: 10px;
            transition: background 0.15s;
        }
        
        .notification:hover {
            background: rgba(255, 255, 255, 0.03);
        }
        
        .notification.unread {
            background: rgba(139, 92, 246, 0.05);
        }
        
        .notification-icon {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .notification-icon.bg-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #ef4444;
        }
        
        .notification-icon.bg-success {
            background: rgba(34, 197, 94, 0.15);
            color: #22c55e;
        }
        
        .notification-icon.bg-primary {
            background: rgba(139, 92, 246, 0.15);
            color: #8b5cf6;
        }
        
        .notification-body p {
            margin: 0 0 4px 0;
            font-size: 13px;
            line-height: 1.4;
        }
        
        .notification-body small {
            color: rgba(255, 255, 255, 0.4);
            font-size: 11px;
        }
        
        .link-btn {
            background: none;
            border: none;
            color: #8b5cf6;
            font-size: 12px;
            cursor: pointer;
            padding: 0;
        }
        
        .link-btn:hover {
            text-decoration: underline;
        }
        
        /* Buttons */
        .btn-ghost {
            padding: 8px 20px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
        }
        
        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.25);
        }
        
        .btn-gradient {
            padding: 8px 24px;
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            border: none;
            border-radius: 10px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
        }
        
        .btn-gradient:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 24px rgba(139, 92, 246, 0.4);
        }
        
        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 5px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }
        
        .mobile-toggle span {
            width: 22px;
            height: 2px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 2px;
            transition: all 0.3s;
        }
        
        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translateY(7px);
        }
        
        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }
        
        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translateY(-7px);
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 80px; /* Espacio para navbar fixed */
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
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 200px);
            padding-top: 80px; /* Espacio para navbar fixed */
        }
        
        /* Footer */
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
        
        /* Responsive */
        @media (max-width: 1024px) {
            .user-name-text {
                display: none;
            }
            
            .nav-item span {
                display: none;
            }
            
            .nav-center {
                flex: 0;
            }
        }
        
        @media (max-width: 768px) {
            .navbar-wrapper {
                height: 56px;
            }
            
            .brand-tagline {
                display: none;
            }
            
            .nav-center {
                display: none;
                position: fixed;
                top: 56px;
                left: 0;
                right: 0;
                background: rgba(10, 10, 20, 0.98);
                backdrop-filter: saturate(180%) blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding: 16px;
                max-height: calc(100vh - 56px);
                overflow-y: auto;
            }
            
            .nav-center.show {
                display: block;
            }
            
            .nav-menu {
                flex-direction: column;
                align-items: stretch;
                gap: 8px;
            }
            
            .nav-item {
                width: 100%;
                justify-content: flex-start;
            }
            
            .nav-item span {
                display: inline;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            .main-content {
                padding-top: 64px;
            }
            
            .footer .grid-cols-4 {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }
    </style>
</body>
</html>
