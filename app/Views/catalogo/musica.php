<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Música | CHOJIN Beats</title>
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
  
  <style>
    /* Tema púrpura para música */
    .musica-hero {
      background: linear-gradient(180deg, rgba(147, 51, 234, 0.15) 0%, transparent 100%);
    }
    
    .musica-hero .hero-title {
      background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }
    
    .music-card {
      background: linear-gradient(145deg, 
        rgba(40, 40, 44, 0.6) 0%, 
        rgba(30, 30, 34, 0.8) 100%);
      border-radius: 12px;
      overflow: hidden;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
      cursor: pointer;
      border: 1px solid rgba(255, 255, 255, 0.05);
      position: relative;
    }
    
    .music-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(147, 51, 234, 0.3);
      border-color: rgba(147, 51, 234, 0.4);
    }
    
    .music-visual-container {
      position: relative;
      width: 100%;
      aspect-ratio: 1;
      overflow: hidden;
      background: linear-gradient(135deg, #1a1a1e 0%, #2a2a2e 100%);
    }
    
    .music-visual {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    
    .music-card:hover .music-visual {
      transform: scale(1.08);
    }
    
    .music-visual.placeholder {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      color: rgba(147, 51, 234, 0.3);
    }
    
    .music-type-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(147, 51, 234, 0.9);
      backdrop-filter: blur(10px);
      color: #fff;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }
    
    .free-badge {
      position: absolute;
      top: 12px;
      left: 12px;
      background: rgba(34, 197, 94, 0.9);
      backdrop-filter: blur(10px);
      color: #fff;
      padding: 0.5rem 1rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.25rem;
    }
    
    .music-info {
      padding: 1rem;
    }
    
    .music-title {
      font-size: 1.125rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .music-player {
      padding: 0 1rem 1rem;
    }
    
    .music-player .waveform-wrapper {
      background: rgba(147, 51, 234, 0.1);
      border-radius: 8px;
      padding: 0.5rem;
      margin-bottom: 0.75rem;
    }
    
    .listen-free-btn {
      width: 100%;
      background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
      border: none;
      color: #fff;
      padding: 0.875rem;
      border-radius: 8px;
      font-weight: 700;
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 0.75rem;
    }
    
    .listen-free-btn:hover {
      transform: scale(1.02);
      box-shadow: 0 8px 20px rgba(147, 51, 234, 0.4);
    }
  </style>
</head>
<body>

  <!-- Header con Navegación -->
  <header class="catalog-header">
    <div class="header-content">
      <a href="<?= site_url('catalogo') ?>" class="logo">
        <i class="bi bi-music-note-beamed"></i>
        CHOJIN
      </a>
      
      <!-- Tabs de Navegación -->
      <nav class="catalog-tabs">
        <a href="<?= site_url('catalogo') ?>" class="tab-link">
          <i class="bi bi-grid-fill"></i>
          Todo
        </a>
        <a href="<?= site_url('catalogo/beats') ?>" class="tab-link">
          <i class="bi bi-disc-fill"></i>
          Beats
        </a>
        <a href="<?= site_url('catalogo/musica') ?>" class="tab-link active">
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
  <section class="catalog-hero musica-hero">
    <h1 class="hero-title">
      <i class="bi bi-music-note-list"></i> Música Gratuita
    </h1>
    <p class="hero-subtitle">Descubre música original de artistas emergentes - 100% gratis</p>
    
    <!-- Barra de Búsqueda -->
    <form method="get" action="<?= site_url('catalogo/musica') ?>" class="search-form">
      <div class="search-bar">
        <i class="bi bi-search"></i>
        <input 
          type="text" 
          name="q" 
          placeholder="Buscar música por título o género..." 
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

    <?php if(empty($musica)): ?>
      <div class="empty-state">
        <i class="bi bi-music-note"></i>
        <p style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">
          No se encontró música
        </p>
        <p style="margin-top: 0.5rem;">
          <?= isset($query) && $query ? 'Intenta con otra búsqueda' : 'Aún no hay música disponible' ?>
        </p>
      </div>
    <?php else: ?>
      <div class="beats-grid">
        <?php foreach($musica as $track): ?>
        <article class="music-card musica-type" onclick="window.location='<?= site_url('catalogo/detalle/'.$track['id']) ?>'">
          <!-- Visual -->
          <div class="music-visual-container">
            <?php if(!empty($track['archivo_visual'])): ?>
              <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $track['archivo_visual'])): ?>
                <img src="<?= asset_url($track['archivo_visual']) ?>" 
                     alt="<?= esc($track['titulo']) ?>"
                     class="music-visual">
              <?php elseif(preg_match('/\.mp4$/i', $track['archivo_visual'])): ?>
                <video src="<?= asset_url($track['archivo_visual']) ?>" 
                       class="music-visual"
                       muted 
                       loop></video>
              <?php endif; ?>
            <?php else: ?>
              <div class="music-visual placeholder">
                <i class="bi bi-music-note-beamed"></i>
              </div>
            <?php endif; ?>
            
            <!-- Badge de Música -->
            <div class="music-type-badge">
              <i class="bi bi-music-note-list"></i>
              MÚSICA
            </div>
            
            <!-- Badge GRATIS -->
            <div class="free-badge">
              <i class="bi bi-gift-fill"></i>
              GRATIS
            </div>
          </div>

          <!-- Info -->
          <div class="music-info">
            <h2 class="music-title"><?= esc($track['titulo']) ?></h2>
            
            <!-- Información del Creador -->
            <?php if (!empty($track['nombre_usuario'])): ?>
            <a href="<?= site_url('perfil/' . $track['nombre_usuario']) ?>" 
               class="beat-creator" 
               onclick="event.stopPropagation();">
              <div class="creator-avatar">
                <?php if (!empty($track['foto_perfil'])): ?>
                  <img src="<?= asset_url($track['foto_perfil']) ?>" 
                       alt="<?= esc($track['nombre_usuario']) ?>">
                <?php else: ?>
                  <i class="bi bi-person-circle"></i>
                <?php endif; ?>
              </div>
              <span class="creator-name"><?= esc($track['nombre_usuario']) ?></span>
            </a>
            <?php else: ?>
            <!-- Debug: Creador no encontrado -->
            <div style="background: #f59e0b; color: #000; padding: 0.5rem; border-radius: 8px; margin-bottom: 0.75rem; font-size: 0.75rem; font-weight: 700;">
              ⚠️ FALTA AVATAR DEL CREADOR (ID: <?= $track['id_productor'] ?? 'NULL' ?>)
            </div>
            <?php endif; ?>
            
            <div class="beat-meta">
              <span class="beat-genre"><?= esc($track['genero']) ?></span>
            </div>
            
            <div class="beat-stats">
              <?php if($track['bpm']): ?>
              <span class="beat-stat">
                <i class="bi bi-lightning-fill"></i>
                <?= esc($track['bpm']) ?> BPM
              </span>
              <?php endif; ?>
              <span class="beat-stat">
                <i class="bi bi-clock"></i>
                <?= esc($track['duracion']) ?: '--' ?>
              </span>
            </div>
          </div>

          <!-- Player -->
          <?php if($track['archivo_preview']): ?>
          <div class="music-player" onclick="event.stopPropagation();">
            <div class="waveform-wrapper">
              <div class="waveform" id="waveform-<?= $track['id'] ?>"></div>
            </div>
            
            <div class="player-controls">
              <button class="play-btn" data-id="<?= $track['id'] ?>" data-src="<?= asset_url($track['archivo_preview']) ?>">
                <i class="bi bi-play-fill"></i>
              </button>
              <span class="time-display" id="time-<?= $track['id'] ?>">0:00</span>
              
              <span style="margin-left: auto; color: #22c55e; font-weight: 700;">
                GRATIS
              </span>
            </div>
            
            <button class="listen-free-btn" onclick="window.location='<?= site_url('catalogo/detalle/'.$track['id']) ?>'">
              <i class="bi bi-headphones"></i>
              ESCUCHAR GRATIS
            </button>
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
    <p class="copyright">&copy; <?= date('Y') ?> CHOJIN BEATS - Todos los derechos reservados</p>
  </footer>

  <!-- Scripts -->
  <script>
    // WaveSurfer Player para Música (tema púrpura)
    const players = {};
    
    document.addEventListener('DOMContentLoaded', () => {
      const playButtons = document.querySelectorAll('.play-btn');
      
      playButtons.forEach(btn => {
        const id = btn.dataset.id;
        const src = btn.dataset.src;
        const waveformEl = document.getElementById('waveform-' + id);
        const timeEl = document.getElementById('time-' + id);
        
        // Crear WaveSurfer con tema púrpura (música)
        const wavesurfer = WaveSurfer.create({
          container: waveformEl,
          waveColor: 'rgba(147, 51, 234, 0.3)',
          progressColor: '#9333ea',
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
