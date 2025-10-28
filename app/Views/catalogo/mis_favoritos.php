<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Mis Favoritos | CHOJIN Beats</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  
  <!-- WaveSurfer.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/6.6.4/wavesurfer.min.js"></script>
  
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
  
  <style>
    /* Estilos específicos para favoritos */
    .favorites-hero {
      background: linear-gradient(180deg, rgba(225, 56, 56, 0.15) 0%, transparent 100%);
      padding: 3rem 2rem 2rem;
      text-align: center;
    }
    
    .favorites-hero h1 {
      font-size: 3rem;
      font-weight: 900;
      background: linear-gradient(135deg, #e13838 0%, #c62828 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: 0.5rem;
      letter-spacing: -0.02em;
    }
    
    .favorites-hero p {
      color: var(--gray-400);
      font-size: 1.125rem;
    }
    
    .favorites-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
      gap: 1.5rem;
      padding: 2rem 1rem;
      max-width: 1400px;
      margin: 0 auto;
    }
    
    .favorite-card {
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
    
    .favorite-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.5);
      border-color: rgba(225, 56, 56, 0.3);
    }
    
    .favorite-visual-container {
      position: relative;
      width: 100%;
      aspect-ratio: 1;
      overflow: hidden;
      background: linear-gradient(135deg, #1a1a1e 0%, #2a2a2e 100%);
    }
    
    .favorite-visual {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    
    .favorite-card:hover .favorite-visual {
      transform: scale(1.08);
    }
    
    .favorite-visual.placeholder {
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 4rem;
      color: rgba(225, 56, 56, 0.3);
    }
    
    .favorite-badge {
      position: absolute;
      top: 12px;
      right: 12px;
      background: rgba(225, 56, 56, 0.9);
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
    
    .favorite-info {
      padding: 1rem;
    }
    
    .favorite-title {
      font-size: 1.125rem;
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: 0.5rem;
      display: -webkit-box;
      -webkit-line-clamp: 1;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    
    .favorite-player {
      padding: 0 1rem 1rem;
    }
    
    .remove-fav-btn {
      width: 100%;
      background: rgba(225, 56, 56, 0.1);
      border: 1px solid rgba(225, 56, 56, 0.3);
      color: #e13838;
      padding: 0.75rem;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.875rem;
      cursor: pointer;
      transition: all 0.2s;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 1rem;
    }
    
    .remove-fav-btn:hover {
      background: rgba(225, 56, 56, 0.2);
      border-color: rgba(225, 56, 56, 0.5);
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="catalog-header">
    <div class="header-content">
      <a href="<?= site_url('catalogo') ?>" class="nav-btn">
        <i class="bi bi-arrow-left"></i>
        Volver al catálogo
      </a>
      <div class="nav-links">
        <a href="<?= site_url('catalogo/mis_favoritos') ?>" class="nav-btn active">
          <i class="bi bi-heart-fill" style="color: #e13838;"></i>
          Mis Favoritos
        </a>
        <a href="<?= site_url('usuario/playlists') ?>" class="nav-btn">
          <i class="bi bi-music-note-list"></i>
          Playlists
        </a>
        <a href="<?= site_url('usuario/mi-perfil') ?>" class="nav-btn">
          <i class="bi bi-person-circle"></i>
          Perfil
        </a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="favorites-hero">
    <h1>
      <i class="bi bi-heart-fill"></i> Mis Favoritos
    </h1>
    <p>Tus beats favoritos en un solo lugar</p>
  </section>

  <!-- Main Content -->
  <main>
    <?php if(empty($beats)): ?>
      <div class="empty-state">
        <i class="bi bi-heart"></i>
        <p style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">
          No tienes beats favoritos aún
        </p>
        <p style="margin-top: 0.5rem;">
          Explora el catálogo y guarda tus beats preferidos
        </p>
        <a href="<?= site_url('catalogo') ?>" class="btn-primary-detail" style="margin-top: 2rem; display: inline-flex;">
          <i class="bi bi-grid-fill"></i>
          Explorar Catálogo
        </a>
      </div>
    <?php else: ?>
      <div class="favorites-grid">
        <?php foreach($beats as $beat): ?>
        <article class="favorite-card <?= $beat['tipo'] === 'musica' ? 'musica-type' : '' ?>" onclick="window.location='<?= site_url('catalogo/detalle/'.$beat['id']) ?>'">
          <!-- Visual -->
          <div class="favorite-visual-container">
            <?php if(!empty($beat['archivo_visual'])): ?>
              <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                <img src="<?= asset_url($beat['archivo_visual']) ?>" 
                     alt="<?= esc($beat['titulo']) ?>"
                     class="favorite-visual">
              <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
                <video src="<?= asset_url($beat['archivo_visual']) ?>" 
                       class="favorite-visual"
                       muted></video>
              <?php endif; ?>
            <?php else: ?>
              <div class="favorite-visual placeholder">
                <i class="bi bi-music-note-beamed"></i>
              </div>
            <?php endif; ?>
            
            <div class="favorite-badge">
              <i class="bi bi-heart-fill"></i>
              Favorito
            </div>
          </div>

          <!-- Info -->
          <div class="favorite-info">
            <h2 class="favorite-title"><?= esc($beat['titulo']) ?></h2>
            
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
            
            <div class="beat-stats" style="margin-top: 0.75rem;">
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
          <div class="favorite-player" onclick="event.stopPropagation();">
            <div class="waveform-wrapper">
              <div class="waveform" id="waveform-<?= $beat['id'] ?>"></div>
            </div>
            
            <div class="player-controls">
              <button class="play-btn" data-id="<?= $beat['id'] ?>" data-src="<?= asset_url($beat['archivo_preview']) ?>">
                <i class="bi bi-play-fill"></i>
              </button>
              <span class="time-display" id="time-<?= $beat['id'] ?>">0:00</span>
              
              <span class="beat-price" style="margin-left: auto; font-size: 1.25rem;">
                $<?= number_format($beat['precio'], 2) ?>
              </span>
            </div>
            
            <!-- Remove from favorites -->
            <form method="post" action="<?= site_url('catalogo/quitar_favorito/'.$beat['id']) ?>">
              <?= csrf_field() ?>
              <button type="submit" class="remove-fav-btn">
                <i class="bi bi-heart-slash-fill"></i>
                Quitar de favoritos
              </button>
            </form>
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
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
  <script>
    // WaveSurfer Player para Favoritos
    const players = {};
    
    document.addEventListener('DOMContentLoaded', () => {
      const playButtons = document.querySelectorAll('.play-btn');
      
      playButtons.forEach(btn => {
        const id = btn.dataset.id;
        const src = btn.dataset.src;
        const waveformEl = document.getElementById('waveform-' + id);
        const timeEl = document.getElementById('time-' + id);
        
        // Crear WaveSurfer
        const wavesurfer = WaveSurfer.create({
          container: waveformEl,
          waveColor: 'rgba(225, 56, 56, 0.3)',
          progressColor: '#e13838',
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
