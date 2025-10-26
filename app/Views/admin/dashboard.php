<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | CHOJIN</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/base/reset.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/variables.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/typography.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/header.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/buttons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/cards.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/admin.css') ?>">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <a href="<?= base_url('/') ?>">
                    <i class="bi bi-music-note-beamed"></i>
                    <span>CHOJIN</span>
                </a>
            </div>
            <nav class="header-nav">
                <a href="<?= site_url('admin/dashboard') ?>" class="active">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
                <a href="<?= site_url('admin/usuarios') ?>">
                    <i class="bi bi-people-fill"></i>
                    <span>Usuarios</span>
                </a>
                <a href="<?= site_url('admin/beats') ?>">
                    <i class="bi bi-music-note-list"></i>
                    <span>Beats</span>
                </a>
                <a href="<?= site_url('catalogo') ?>">
                    <i class="bi bi-grid"></i>
                    <span>Catálogo</span>
                </a>
            </nav>
            <div class="header-actions">
                <span class="user-badge">
                    <i class="bi bi-shield-lock-fill"></i>
                    <?= esc(session()->get('nombre_usuario')) ?>
                </span>
                <a href="<?= site_url('auth/logout') ?>" class="btn-secondary">
                    <i class="bi bi-box-arrow-right"></i>
                    Salir
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-container">
        <!-- Hero Section -->
        <section class="admin-hero">
            <div class="hero-content">
                <h1 class="hero-title">
                    <i class="bi bi-shield-lock-fill"></i>
                    Panel de Administración
                </h1>
                <p class="hero-subtitle">
                    Gestiona usuarios, beats y todo el contenido de la plataforma
                </p>
            </div>
        </section>

        <!-- Stats Grid -->
        <section class="stats-section">
            <div class="stats-grid">
                <!-- Total Usuarios -->
                <div class="stat-card">
                    <div class="stat-icon stat-icon-primary">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Usuarios</p>
                        <h3 class="stat-value"><?= $totalUsuarios ?></h3>
                        <p class="stat-change positive">
                            <i class="bi bi-arrow-up"></i>
                            Activos en el sistema
                        </p>
                    </div>
                </div>

                <!-- Total Beats -->
                <div class="stat-card">
                    <div class="stat-icon stat-icon-success">
                        <i class="bi bi-music-note-beamed"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Total Beats</p>
                        <h3 class="stat-value"><?= $totalBeats ?></h3>
                        <p class="stat-change">
                            <i class="bi bi-music-note"></i>
                            En la plataforma
                        </p>
                    </div>
                </div>

                <!-- Productores -->
                <div class="stat-card">
                    <div class="stat-icon stat-icon-warning">
                        <i class="bi bi-disc-fill"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Productores</p>
                        <h3 class="stat-value"><?= $totalProductores ?></h3>
                        <p class="stat-change">
                            <i class="bi bi-person-badge"></i>
                            Creadores de beats
                        </p>
                    </div>
                </div>

                <!-- Artistas -->
                <div class="stat-card">
                    <div class="stat-icon stat-icon-purple">
                        <i class="bi bi-mic-fill"></i>
                    </div>
                    <div class="stat-content">
                        <p class="stat-label">Artistas</p>
                        <h3 class="stat-value"><?= $totalArtistas ?></h3>
                        <p class="stat-change">
                            <i class="bi bi-star-fill"></i>
                            Creadores de música
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Quick Actions -->
        <section class="actions-section">
            <h2 class="section-title">
                <i class="bi bi-lightning-fill"></i>
                Acciones Rápidas
            </h2>
            
            <div class="actions-grid">
                <a href="<?= site_url('admin/usuarios') ?>" class="action-card">
                    <div class="action-icon action-icon-primary">
                        <i class="bi bi-person-plus-fill"></i>
                    </div>
                    <div class="action-content">
                        <h3 class="action-title">Gestionar Usuarios</h3>
                        <p class="action-description">
                            Ver, editar y administrar todos los usuarios de la plataforma
                        </p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>

                <a href="<?= site_url('admin/beats') ?>" class="action-card">
                    <div class="action-icon action-icon-success">
                        <i class="bi bi-music-note-list"></i>
                    </div>
                    <div class="action-content">
                        <h3 class="action-title">Gestionar Beats</h3>
                        <p class="action-description">
                            Moderar, aprobar o eliminar beats y música del catálogo
                        </p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>

                <a href="<?= site_url('catalogo') ?>" class="action-card">
                    <div class="action-icon action-icon-info">
                        <i class="bi bi-eye-fill"></i>
                    </div>
                    <div class="action-content">
                        <h3 class="action-title">Ver Sitio Público</h3>
                        <p class="action-description">
                            Previsualizar el catálogo como lo ven los usuarios
                        </p>
                    </div>
                    <div class="action-arrow">
                        <i class="bi bi-arrow-right"></i>
                    </div>
                </a>
            </div>
        </section>

        <!-- Recent Activity -->
        <section class="activity-section">
            <h2 class="section-title">
                <i class="bi bi-clock-history"></i>
                Resumen del Sistema
            </h2>
            
            <div class="activity-grid">
                <div class="activity-card">
                    <div class="activity-header">
                        <h3>
                            <i class="bi bi-people"></i>
                            Distribución de Usuarios
                        </h3>
                    </div>
                    <div class="activity-body">
                        <div class="distribution-item">
                            <div class="distribution-label">
                                <i class="bi bi-shield-lock-fill" style="color: #e13838;"></i>
                                Super Admins
                            </div>
                            <div class="distribution-value">
                                <?= $totalAdmins ?? 1 ?>
                            </div>
                        </div>
                        <div class="distribution-item">
                            <div class="distribution-label">
                                <i class="bi bi-disc-fill" style="color: #1ed760;"></i>
                                Productores
                            </div>
                            <div class="distribution-value">
                                <?= $totalProductores ?>
                            </div>
                        </div>
                        <div class="distribution-item">
                            <div class="distribution-label">
                                <i class="bi bi-mic-fill" style="color: #9333ea;"></i>
                                Artistas
                            </div>
                            <div class="distribution-value">
                                <?= $totalArtistas ?>
                            </div>
                        </div>
                        <div class="distribution-item">
                            <div class="distribution-label">
                                <i class="bi bi-person" style="color: #3b82f6;"></i>
                                Compradores
                            </div>
                            <div class="distribution-value">
                                <?= $totalCompradores ?? 0 ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="activity-card">
                    <div class="activity-header">
                        <h3>
                            <i class="bi bi-music-note-beamed"></i>
                            Estado del Contenido
                        </h3>
                    </div>
                    <div class="activity-body">
                        <div class="content-status">
                            <div class="status-item">
                                <div class="status-indicator status-success"></div>
                                <span>Beats Activos</span>
                                <strong><?= $totalBeats ?></strong>
                            </div>
                            <div class="status-item">
                                <div class="status-indicator status-primary"></div>
                                <span>Plataforma</span>
                                <strong>Operativa</strong>
                            </div>
                            <div class="status-item">
                                <div class="status-indicator status-warning"></div>
                                <span>Sistema</span>
                                <strong>Estable</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
