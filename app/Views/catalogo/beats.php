<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Beats | LubaBeats Beta</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet" />
  
  <!-- WaveSurfer.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/6.6.4/wavesurfer.min.js"></script>
  
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

  <!-- Header con Navegación -->
  <header class="catalog-header">
    <div class="header-content">
      <a href="<?= site_url('catalogo') ?>" class="logo">
        <i class="bi bi-music-note-beamed"></i>
        <div class="logo-text">
          <span class="logo-brand">
            <span class="logo-luba">LUBA</span><span class="logo-beats">Beats</span>
          </span>
          <span class="logo-tagline">PLATAFORMA BETA</span>
        </div>
      </a>
      
      <!-- Tabs de Navegación -->
      <nav class="catalog-tabs">
        <a href="<?= site_url('catalogo') ?>" class="tab-link">
          <i class="bi bi-grid-fill"></i>
          Todo
        </a>
        <a href="<?= site_url('catalogo/beats') ?>" class="tab-link active">
          <i class="bi bi-disc-fill"></i>
          Beats
        </a>
        <a href="<?= site_url('catalogo/musica') ?>" class="tab-link">
          <i class="bi bi-music-note-list"></i>
          Música
        </a>
      </nav>

      <div class="nav-links">
        <?php if(session()->get('logged_in')): ?>
          <a href="<?= site_url('catalogo/mis_favoritos') ?>" class="nav-btn">
            <i class="bi bi-heart-fill"></i>
            Favoritos
          </a>
          <a href="<?= site_url('usuario/playlists') ?>" class="nav-btn">
            <i class="bi bi-music-note-list"></i>
            Playlists
          </a>
          <a href="<?= site_url('usuario/mi-perfil') ?>" class="nav-btn">
            <i class="bi bi-person-circle"></i>
            Perfil
          </a>
        <?php else: ?>
          <a href="<?= site_url('auth/login') ?>" class="nav-btn">
            <i class="bi bi-box-arrow-in-right"></i>
            Iniciar Sesión
          </a>
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="catalog-hero">
    <h1 class="hero-title">
      <i class="bi bi-disc-fill"></i> Beats
    </h1>
    <p class="hero-subtitle">Luba Beats Beta - explora beats y música para tus proyectos</p>
    
    <!-- Barra de Búsqueda -->
    <form method="get" action="<?= site_url('catalogo/beats') ?>" class="search-form">
      <div class="search-bar">
        <i class="bi bi-search"></i>
        <input 
          type="text" 
          name="q" 
          placeholder="Buscar beats por título o género..." 
          value="<?= esc($query ?? '') ?>"
          class="search-input"
        />
        <button type="submit" class="search-btn">
          Buscar
        </button>
      </div>
    </form>
  </section>

  <!-- Main Content -->
  <main class="catalog-main">
    <?php if(session()->getFlashdata('mensaje')): ?>
      <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('mensaje') ?>
      </div>
    <?php endif; ?>

    <?php if(empty($beats)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">
          No se encontraron beats
        </p>
        <p style="margin-top: 0.5rem;">
          <?= isset($query) && $query ? 'Intenta con otra búsqueda' : 'Aún no hay beats disponibles' ?>
        </p>
      </div>
    <?php else: ?>
      <div class="beats-grid">
        <?php foreach($beats as $beat): ?>
        <article class="beat-card" onclick="window.location='<?= site_url('catalogo/detalle/'.$beat['id']) ?>'">
          <!-- Visual -->
          <div class="beat-visual-container">
            <?php if(!empty($beat['archivo_visual'])): ?>
              <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                <img src="<?= asset_url($beat['archivo_visual']) ?>" 
                     alt="<?= esc($beat['titulo']) ?>"
                     class="beat-visual">
              <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
                <video src="<?= asset_url($beat['archivo_visual']) ?>" 
                       class="beat-visual"
                       muted 
                       loop></video>
              <?php endif; ?>
            <?php else: ?>
              <div class="beat-visual placeholder">
                <i class="bi bi-music-note-beamed"></i>
              </div>
            <?php endif; ?>
            
            <!-- Badge de Beat -->
            <div class="beat-type-badge beat">
              <i class="bi bi-disc-fill"></i>
              BEAT
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
          <div class="beat-player" onclick="event.stopPropagation();">
            <div class="waveform-wrapper">
              <div class="waveform" id="waveform-<?= $beat['id'] ?>"></div>
            </div>
            
            <div class="player-controls">
              <button class="play-btn" data-id="<?= $beat['id'] ?>" data-src="<?= asset_url($beat['archivo_preview']) ?>">
                <i class="bi bi-play-fill"></i>
              </button>
              <span class="time-display" id="time-<?= $beat['id'] ?>">0:00</span>
              
              <!-- Precio destacado -->
              <span class="beat-price">
                $<?= number_format($beat['precio'], 2) ?>
              </span>
            </div>
          </div>
          <?php endif; ?>
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
    </div>
    <p class="copyright">&copy; <?= date('Y') ?> LubaBeats Beta - Plataforma gratuita de la familia LUBA</p>
  </footer>

  <!-- Scripts -->
  <script>
    // WaveSurfer Player para Beats
    const players = {};
    
    document.addEventListener('DOMContentLoaded', () => {
      const playButtons = document.querySelectorAll('.play-btn');
      
      playButtons.forEach(btn => {
        const id = btn.dataset.id;
        const src = btn.dataset.src;
        const waveformEl = document.getElementById('waveform-' + id);
        const timeEl = document.getElementById('time-' + id);
        
        // Crear WaveSurfer con tema verde (beats)
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
        
        // Play/Pause
        btn.addEventListener('click', (e) => {
          e.stopPropagation();
          
          // Pausar otros players
          Object.entries(players).forEach(([key, player]) => {
            if (key !== id && player.isPlaying()) {
              player.pause();
              const otherBtn = document.querySelector(`[data-id="${key}"]`);
              otherBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
              otherBtn.classList.remove('playing');
            }
          });
          
          // Toggle actual
          wavesurfer.playPause();
        });
        
        // Eventos
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
