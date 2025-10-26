<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mi Catálogo - Beats Comprados | CHOJIN BEATS</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/6.6.4/wavesurfer.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
  
  <!-- Header -->
  <header class="catalog-header">
    <div class="header-content">
      <a href="<?= site_url() ?>" class="logo">
        <i class="bi bi-music-note-beamed" style="font-size: 1.75rem; color: #1ed760;"></i>
        <span class="logo-text">CHOJIN</span>
      </a>
      
      <nav class="nav-links">
        <a href="<?= site_url('catalogo') ?>" class="nav-btn">
          <i class="bi bi-grid-fill"></i> Catálogo Público
        </a>
        
        <?php if(session()->get('logueado') && session()->get('tipo')=='comprador'): ?>
          <a href="<?= site_url('usuario/catalogo') ?>" class="nav-btn active">
            <i class="bi bi-person-circle"></i> Mi Catálogo
          </a>
        <?php endif; ?>
        
        <?php if(session()->get('logueado') && session()->get('tipo')=='productor'): ?>
          <a href="<?= site_url('productor/panel') ?>" class="nav-btn">
            <i class="bi bi-headphones"></i> Panel Productor
          </a>
          <a href="<?= site_url('productor/subir') ?>" class="nav-btn" style="background: #1ed760; color: #000;">
            <i class="bi bi-cloud-upload"></i> Subir Beat
          </a>
        <?php endif; ?>

        <?php if(session()->get('logueado')): ?>
          <a href="<?= site_url('catalogo/mis_favoritos') ?>" class="nav-btn">
            <i class="bi bi-heart-fill" style="color: #e13838;"></i> Favoritos
          </a>
          <a href="<?= site_url('usuario/playlists') ?>" class="nav-btn">
            <i class="bi bi-music-note-list"></i> Playlists
          </a>
          <a href="<?= site_url('usuario/mi-perfil') ?>" class="nav-btn">
            <i class="bi bi-person-circle"></i> Perfil
          </a>
          <span style="color: #1ed760; margin: 0 0.5rem;"><?= esc(session()->get('nombre_usuario')) ?></span>
          <a href="<?= site_url('auth/logout') ?>" class="nav-btn">
            <i class="bi bi-box-arrow-right"></i> Salir
          </a>
        <?php endif; ?>
      </nav>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="catalog-hero">
    <h1>Mi Catálogo Personal</h1>
    <p class="catalog-subtitle">
      Beats que he adquirido - Listos para usar en mis proyectos
    </p>
  </section>

  <!-- Main Content -->
  <main>
    <?php if(empty($beats)): ?>
      <div class="empty-state">
        <i class="bi bi-music-note-list"></i>
        <p>Aún no has comprado ningún beat</p>
        <p style="margin-top: 0.5rem; font-size: 0.95rem; color: var(--gray-400);">
          Explora el <a href="<?= site_url('catalogo') ?>" style="color: #1ed760; font-weight: 700;">catálogo público</a> para encontrar el beat perfecto
        </p>
      </div>
    <?php else: ?>
      <div class="beats-grid">
        <?php foreach($beats as $beat): ?>
        <article class="beat-card <?= $beat['tipo'] === 'musica' ? 'musica-type' : '' ?>">
          <!-- Visual -->
          <div class="beat-visual-container">
            <?php if($beat['archivo_visual']): ?>
              <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                <img src="<?= base_url($beat['archivo_visual']) ?>" 
                     alt="<?= esc($beat['titulo']) ?>"
                     class="beat-visual"
                     loading="lazy">
              <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
                <video src="<?= base_url($beat['archivo_visual']) ?>" 
                       class="beat-visual"
                       muted
                       loop></video>
              <?php endif; ?>
            <?php else: ?>
              <div class="beat-visual placeholder">
                <i class="bi bi-music-note-beamed"></i>
              </div>
            <?php endif; ?>
            
            <div class="play-overlay">
              <i class="bi bi-play-fill"></i>
            </div>
            
            <!-- Badge "Comprado" -->
            <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: linear-gradient(135deg, #1ed760, #1db954); color: #000; padding: 0.35rem 0.75rem; border-radius: 20px; font-weight: 800; font-size: 0.75rem; box-shadow: 0 2px 8px rgba(30, 215, 96, 0.4);">
              <i class="bi bi-check-circle-fill"></i> COMPRADO
            </div>
          </div>

          <!-- Info -->
          <div class="beat-info">
            <h2 class="beat-title"><?= esc($beat['titulo']) ?></h2>
            
            <!-- Información del Creador -->
            <?php if (!empty($beat['nombre_usuario'])): ?>
            <a href="<?= site_url('perfil/' . $beat['nombre_usuario']) ?>" 
               class="beat-creator" 
               onclick="event.stopPropagation();">
              <div class="creator-avatar">
                <?php if (!empty($beat['foto_perfil'])): ?>
                  <img src="<?= asset_url($beat['foto_perfil']) ?>" 
                       alt="<?= esc($beat['nombre_usuario']) ?>">
                <?php else: ?>
                  <i class="bi bi-person-circle"></i>
                <?php endif; ?>
              </div>
              <span class="creator-name"><?= esc($beat['nombre_usuario']) ?></span>
            </a>
            <?php endif; ?>
            
            <div class="beat-meta">
              <span class="beat-genre"><?= esc($beat['genero']) ?></span>
            </div>
            
            <div class="beat-stats">
              <span class="beat-stat">
                <i class="bi bi-lightning-fill"></i>
                <?= esc($beat['bpm']) ?> BPM
              </span>
              <span class="beat-stat">
                <i class="bi bi-clock"></i>
                <?= esc($beat['duracion']) ?: '--' ?>
              </span>
            </div>
          </div>

          <!-- Player -->
          <?php if($beat['archivo_preview']): ?>
          <div class="beat-player">
            <div class="waveform-wrapper">
              <div class="waveform" id="waveform-<?= $beat['id'] ?>"></div>
            </div>
            
            <div class="player-controls">
              <button class="play-btn" data-id="<?= $beat['id'] ?>" data-src="<?= base_url($beat['archivo_preview']) ?>">
                <i class="bi bi-play-fill"></i>
              </button>
              <span class="time-display" id="time-<?= $beat['id'] ?>">0:00</span>
            </div>
          </div>
          <?php endif; ?>
          
          <!-- Actions - Botón de descarga -->
          <div class="beat-actions">
            <span style="color: #1ed760; font-weight: 700; font-size: 0.9rem;">
              <i class="bi bi-check-circle-fill"></i> En mi biblioteca
            </span>
            <a href="<?= site_url('catalogo/detalle/'.$beat['id']) ?>" class="detail-btn">
              Ver detalles
            </a>
          </div>
        </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <!-- Footer -->
  <footer class="catalog-footer">
    <div class="footer-links">
      <a href="<?= site_url('magdiel') ?>" class="footer-link">Magdiel UCHIHA</a>
      <a href="<?= site_url('contacto') ?>" class="footer-link">Contacto</a>
      <a href="#" class="footer-link">Términos</a>
      <a href="#" class="footer-link">Privacidad</a>
    </div>
    <p class="copyright">&copy; <?= date('Y') ?> CHOJIN BEATS - Todos los derechos reservados</p>
  </footer>

  <!-- Scripts -->
  <script>
    // WaveSurfer Players
    const players = {};
    
    document.addEventListener('DOMContentLoaded', () => {
      const playButtons = document.querySelectorAll('.play-btn');
      
      playButtons.forEach(btn => {
        const id = btn.dataset.id;
        const src = btn.dataset.src;
        const waveformEl = document.getElementById('waveform-' + id);
        const timeEl = document.getElementById('time-' + id);
        
        const wavesurfer = WaveSurfer.create({
          container: waveformEl,
          waveColor: 'rgba(30, 215, 96, 0.3)',
          progressColor: '#1ed760',
          height: 60,
          barWidth: 2,
          barGap: 1,
          barRadius: 2,
          cursorWidth: 0,
          responsive: true,
          normalize: true,
        });
        
        wavesurfer.load(src);
        players[id] = wavesurfer;
        
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          
          Object.entries(players).forEach(([key, player]) => {
            if (key !== id && player.isPlaying()) {
              player.pause();
              const otherBtn = document.querySelector(`[data-id="${key}"]`);
              otherBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
              otherBtn.classList.remove('playing');
            }
          });
          
          wavesurfer.playPause();
        });
        
        wavesurfer.on('play', () => {
          btn.innerHTML = '<i class="bi bi-pause-fill"></i>';
          btn.classList.add('playing');
        });
        
        wavesurfer.on('pause', () => {
          btn.innerHTML = '<i class="bi bi-play-fill"></i>';
          btn.classList.remove('playing');
        });
        
        wavesurfer.on('audioprocess', () => {
          const time = wavesurfer.getCurrentTime();
          timeEl.textContent = formatTime(time);
        });
        
        wavesurfer.on('finish', () => {
          btn.innerHTML = '<i class="bi bi-play-fill"></i>';
          btn.classList.remove('playing');
          timeEl.textContent = '0:00';
        });
      });
    });
    
    function formatTime(seconds) {
      const mins = Math.floor(seconds / 60);
      const secs = Math.floor(seconds % 60);
      return `${mins}:${secs.toString().padStart(2, '0')}`;
    }
  </script>
</body>
</html>
