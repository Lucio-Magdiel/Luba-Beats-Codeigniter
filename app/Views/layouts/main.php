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
    <nav class="navbar">
        <div class="container">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <i class="bi bi-music-note-beamed"></i> CHOJIN BEATS
                </a>
                
                <!-- Desktop Navigation -->
                <ul class="nav-links" id="navLinks">
                    <?php if (session()->has('usuario_id')): ?>
                        <?php 
                        $tipo = session()->get('tipo');
                        $nombre = session()->get('nombre_usuario');
                        ?>
                        
                        <!-- Super Admin Menu -->
                        <?php if ($tipo === 'super_admin'): ?>
                            <li><a href="<?= site_url('admin/dashboard') ?>" class="nav-link <?= (uri_string() == 'admin/dashboard' ? 'active' : '') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a></li>
                            <li><a href="<?= site_url('admin/usuarios') ?>" class="nav-link <?= (uri_string() == 'admin/usuarios' ? 'active' : '') ?>">
                                <i class="bi bi-people"></i> Usuarios
                            </a></li>
                            <li><a href="<?= site_url('admin/beats') ?>" class="nav-link <?= (uri_string() == 'admin/beats' ? 'active' : '') ?>">
                                <i class="bi bi-music-note-list"></i> Beats
                            </a></li>
                        
                        <!-- Productor Menu -->
                        <?php elseif ($tipo === 'productor'): ?>
                            <li><a href="<?= site_url('productor/panel') ?>" class="nav-link <?= (uri_string() == 'productor/panel' ? 'active' : '') ?>">
                                <i class="bi bi-grid"></i> Mis Beats
                            </a></li>
                            <li><a href="<?= site_url('productor/subir') ?>" class="nav-link <?= (uri_string() == 'productor/subir' ? 'active' : '') ?>">
                                <i class="bi bi-cloud-upload"></i> Subir Beat
                            </a></li>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link">
                                <i class="bi bi-shop"></i> Catálogo
                            </a></li>
                        
                        <!-- Artista Menu -->
                        <?php elseif ($tipo === 'artista'): ?>
                            <li><a href="<?= site_url('artista/panel') ?>" class="nav-link <?= (uri_string() == 'artista/panel' ? 'active' : '') ?>">
                                <i class="bi bi-vinyl"></i> Mis Canciones
                            </a></li>
                            <li><a href="<?= site_url('artista/subir') ?>" class="nav-link <?= (uri_string() == 'artista/subir' ? 'active' : '') ?>">
                                <i class="bi bi-cloud-upload"></i> Subir Canción
                            </a></li>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link">
                                <i class="bi bi-disc"></i> Catálogo
                            </a></li>
                        
                        <!-- Comprador Menu -->
                        <?php else: ?>
                            <li><a href="<?= site_url('catalogo') ?>" class="nav-link <?= (uri_string() == 'catalogo' ? 'active' : '') ?>">
                                <i class="bi bi-shop"></i> Catálogo
                            </a></li>
                            <li><a href="<?= site_url('usuario/favoritos') ?>" class="nav-link">
                                <i class="bi bi-heart"></i> Favoritos
                            </a></li>
                            <li><a href="<?= site_url('usuario/compras') ?>" class="nav-link">
                                <i class="bi bi-bag-check"></i> Mis Compras
                            </a></li>
                        <?php endif; ?>
                        
                        <!-- User Dropdown -->
                        <li class="nav-item-dropdown">
                            <button class="btn btn-ghost btn-sm" onclick="toggleDropdown()">
                                <i class="bi bi-person-circle"></i>
                                <?= esc($nombre) ?>
                                <i class="bi bi-chevron-down"></i>
                            </button>
                            <div class="dropdown-menu" id="userDropdown">
                                <a href="<?= site_url('usuario/perfil') ?>" class="dropdown-item">
                                    <i class="bi bi-person"></i> Mi Perfil
                                </a>
                                <a href="<?= site_url('usuario/configuracion') ?>" class="dropdown-item">
                                    <i class="bi bi-gear"></i> Configuración
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?= site_url('auth/logout') ?>" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </a>
                            </div>
                        </li>
                        
                    <?php else: ?>
                        <li><a href="<?= site_url('catalogo') ?>" class="nav-link">
                            <i class="bi bi-shop"></i> Catálogo
                        </a></li>
                        <li><a href="<?= site_url('auth/login') ?>" class="btn btn-outline btn-sm">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a></li>
                        <li><a href="<?= site_url('auth/registro') ?>" class="btn btn-primary btn-sm">
                            <i class="bi bi-person-plus"></i> Registrarse
                        </a></li>
                    <?php endif; ?>
                </ul>
                
                <!-- Mobile Menu Button -->
                <button class="btn btn-ghost btn-icon mobile-menu-btn" onclick="toggleMobileMenu()">
                    <i class="bi bi-list"></i>
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
    <script src="<?= base_url('assets/js/app.js') ?>"></script>
    
    <!-- Scripts Adicionales -->
    <?= $this->renderSection('scripts') ?>
    
    <style>
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
