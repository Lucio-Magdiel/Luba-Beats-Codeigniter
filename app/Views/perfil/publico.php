<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/pages/perfil-publico.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="perfil-publico">
        <div class="perfil-hero">
            <div class="hero-banner">
                <?php if (!empty($usuario['banner'])): ?>
                    <img src="<?= asset_url($usuario['banner']) ?>" 
                         alt="Banner de <?= esc($usuario['nombre_usuario']) ?>">
                <?php else: ?>
                    <div class="hero-banner-placeholder"></div>
                <?php endif; ?>
            </div>
            
            <div class="hero-content">
                <div class="hero-avatar">
                    <?php if (!empty($usuario['foto_perfil'])): ?>
                        <img src="<?= asset_url($usuario['foto_perfil']) ?>" 
                             alt="<?= esc($usuario['nombre_usuario']) ?>">
                    <?php else: ?>
                        <div class="hero-avatar-placeholder">
                            <i class="bi bi-person-circle"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <div class="hero-info">
                    <h1 class="perfil-nombre"><?= esc($usuario['nombre_usuario']) ?></h1>
                    <p class="perfil-username">@<?= esc($usuario['nombre_usuario']) ?></p>
                    <span class="perfil-badge perfil-badge-<?= esc($usuario['tipo']) ?>">
                        <?php
                        $tipos = [
                            'productor' => 'Productor',
                            'artista' => 'Artista'
                        ];
                        echo $tipos[$usuario['tipo']] ?? 'Usuario';
                        ?>
                    </span>
                    
                    <?php if (!empty($usuario['bio'])): ?>
                        <p class="perfil-bio"><?= esc($usuario['bio']) ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-value"><?= $stats['total_beats'] ?? 0 ?></span>
                        <span class="stat-label">
                            <i class="bi bi-music-note"></i>
                            Beats
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value"><?= $stats['total_musica'] ?? 0 ?></span>
                        <span class="stat-label">
                            <i class="bi bi-mic"></i>
                            Música
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-value"><?= $stats['total_playlists'] ?? 0 ?></span>
                        <span class="stat-label">
                            <i class="bi bi-music-note-list"></i>
                            Playlists
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($beats)): ?>
            <section class="perfil-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-music-note"></i>
                        Beats
                    </h2>
                    <span class="section-count"><?= count($beats) ?> pistas</span>
                </div>
                
                <div class="beats-grid">
                    <?php foreach (array_slice($beats, 0, 6) as $beat): ?>
                        <div class="beat-card">
                            <a href="<?= base_url('/catalogo/detalle/' . $beat['id']) ?>" class="beat-cover">
                                <?php if (!empty($beat['archivo_visual'])): ?>
                                    <img src="<?= asset_url($beat['archivo_visual']) ?>" alt="<?= esc($beat['titulo']) ?>">
                                <?php else: ?>
                                    <div class="beat-cover-default">
                                        <i class="bi bi-music-note"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="beat-play">
                                    <i class="bi bi-play-fill"></i>
                                </div>
                            </a>
                            
                            <div class="beat-info">
                                <h3 class="beat-title">
                                    <a href="<?= base_url('/catalogo/detalle/' . $beat['id']) ?>">
                                        <?= esc($beat['titulo']) ?>
                                    </a>
                                </h3>
                                <p class="beat-meta">
                                    <?= esc($beat['genero']) ?> • <?= esc($beat['bpm']) ?> BPM
                                </p>
                                <p class="beat-price">$<?= number_format($beat['precio'], 2) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>

        <?php if (!empty($playlists)): ?>
            <section class="perfil-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-music-note-list"></i>
                        Playlists Públicas
                    </h2>
                    <span class="section-count"><?= count($playlists) ?> colecciones</span>
                </div>
                
                <div class="playlists-grid">
                    <?php foreach ($playlists as $playlist): ?>
                        <div class="playlist-card">
                            <a href="<?= base_url('/perfil/' . $usuario['nombre_usuario'] . '/playlist/' . $playlist['id']) ?>" 
                               class="playlist-cover">
                                <?php if (!empty($playlist['imagen_portada'])): ?>
                                    <img src="<?= asset_url($playlist['imagen_portada']) ?>" alt="<?= esc($playlist['nombre']) ?>">
                                <?php else: ?>
                                    <div class="playlist-cover-default">
                                        <i class="bi bi-music-note-list"></i>
                                    </div>
                                <?php endif; ?>
                            </a>
                            
                            <div class="playlist-info">
                                <h3 class="playlist-name">
                                    <a href="<?= base_url('/perfil/' . $usuario['nombre_usuario'] . '/playlist/' . $playlist['id']) ?>">
                                        <?= esc($playlist['nombre']) ?>
                                    </a>
                                </h3>
                                <p class="playlist-description"><?= esc($playlist['descripcion'] ?? 'Sin descripción') ?></p>
                                <p class="playlist-tracks">
                                    <i class="bi bi-music-note"></i>
                                    <?= $playlist['total_beats'] ?? 0 ?> pistas
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
<?= $this->endSection() ?>
