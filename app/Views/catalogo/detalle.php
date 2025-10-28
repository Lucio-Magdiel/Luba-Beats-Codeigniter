<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title><?= esc($beat['titulo']) ?> | LubaBeats Beta</title>
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
    /* Estilos específicos para detalle */
    .detail-hero {
      background: linear-gradient(180deg, rgba(30, 215, 96, 0.15) 0%, transparent 100%);
      padding: 2rem;
    }
    
    .detail-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }
    
    .detail-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 3rem;
      margin-bottom: 3rem;
    }
    
    @media (max-width: 768px) {
      .detail-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
      }
    }
    
    .detail-visual {
      width: 100%;
      aspect-ratio: 1;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
    }
    
    .detail-visual img,
    .detail-visual video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    
    .detail-visual.placeholder {
      background: linear-gradient(135deg, #1a1a1e 0%, #2a2a2e 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 6rem;
      color: rgba(30, 215, 96, 0.2);
    }
    
    .detail-info h1 {
      font-size: 3rem;
      font-weight: 900;
      margin-bottom: 1rem;
      line-height: 1.1;
    }
    
    .detail-stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 1rem;
      margin: 2rem 0;
    }
    
    .stat-box {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 1.25rem;
      transition: all 0.2s;
    }
    
    .stat-box:hover {
      background: rgba(255, 255, 255, 0.08);
      border-color: rgba(30, 215, 96, 0.3);
    }
    
    .stat-label {
      display: block;
      font-size: 0.875rem;
      color: var(--gray-400);
      margin-bottom: 0.5rem;
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }
    
    .stat-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--text-primary);
    }
    
    .detail-price {
      font-size: 3rem;
      font-weight: 900;
      background: linear-gradient(135deg, #1ed760 0%, #1db954 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin: 2rem 0;
    }
    
    .player-section {
      background: rgba(255, 255, 255, 0.03);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 2rem;
      margin-bottom: 2rem;
    }
    
    .player-header {
      display: flex;
      align-items: center;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }
    
    .player-main-btn {
      width: 64px;
      height: 64px;
      background: #1ed760;
      border: none;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
      flex-shrink: 0;
    }
    
    .player-main-btn:hover {
      transform: scale(1.06);
      background: #1fdf64;
      box-shadow: 0 8px 24px rgba(30, 215, 96, 0.4);
    }
    
    .player-main-btn i {
      font-size: 2rem;
      color: #000;
      margin-left: 3px;
    }
    
    .player-main-btn.playing i {
      margin-left: 0;
    }
    
    .waveform-detail {
      height: 80px;
      border-radius: 8px;
      margin-bottom: 1rem;
    }
    
    .player-time {
      display: flex;
      justify-content: space-between;
      color: var(--gray-400);
      font-size: 0.875rem;
      font-variant-numeric: tabular-nums;
    }
    
    .action-buttons {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }
    
    .btn-primary-detail {
      flex: 1;
      background: #1ed760;
      color: #000;
      border: none;
      border-radius: 500px;
      padding: 1rem 2rem;
      font-weight: 700;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    
    .btn-primary-detail:hover {
      background: #1fdf64;
      transform: scale(1.02);
    }
    
    .btn-secondary-detail {
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: var(--text-primary);
      border-radius: 500px;
      padding: 1rem 2rem;
      font-weight: 600;
      font-size: 1rem;
      cursor: pointer;
      transition: all 0.2s;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }
    
    .btn-secondary-detail:hover {
      background: rgba(255, 255, 255, 0.1);
      border-color: rgba(30, 215, 96, 0.5);
    }
    
    .fav-btn-detail {
      width: 64px;
      height: 64px;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: all 0.2s;
      color: var(--gray-400);
    }
    
    .fav-btn-detail:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: scale(1.06);
    }
    
    .fav-btn-detail.active {
      color: #1ed760;
      border-color: rgba(30, 215, 96, 0.5);
    }
    
    .fav-btn-detail i {
      font-size: 1.75rem;
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
        <?php if(session()->get('logueado')): ?>
          <a href="<?= site_url('catalogo/mis_favoritos') ?>" class="nav-btn">
            <i class="bi bi-heart-fill" style="color: #e13838;"></i>
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
        <?php endif; ?>
      </div>
    </div>
  </header>

  <!-- Hero -->
  <div class="detail-hero"></div>

  <!-- Main Content -->
  <main class="detail-container">
    <div class="detail-grid">
      <!-- Visual -->
      <div>
        <div class="detail-visual <?php if(empty($beat['archivo_visual'])) echo 'placeholder'; ?>">
          <?php if(!empty($beat['archivo_visual'])): ?>
            <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
              <img src="<?= asset_url($beat['archivo_visual']) ?>" alt="<?= esc($beat['titulo']) ?>">
            <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
              <video src="<?= asset_url($beat['archivo_visual']) ?>" controls></video>
            <?php endif; ?>
          <?php else: ?>
            <i class="bi bi-music-note-beamed"></i>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- Info -->
      <div class="detail-info">
        <h1><?= esc($beat['titulo']) ?></h1>
        
        <!-- Información del Creador -->
        <?php if (!empty($beat['nombre_usuario'])): ?>
        <div style="margin-bottom: 1.5rem;">
          <a href="<?= site_url('perfil/' . $beat['nombre_usuario']) ?>" 
             class="beat-creator" 
             style="font-size: 1rem; gap: 0.75rem;">
            <div class="creator-avatar" style="width: 40px; height: 40px;">
              <?php if (!empty($beat['foto_perfil'])): ?>
                <img src="<?= asset_url($beat['foto_perfil']) ?>" 
                     alt="<?= esc($beat['nombre_usuario']) ?>">
              <?php else: ?>
                <i class="bi bi-person-circle"></i>
              <?php endif; ?>
            </div>
            <div>
              <div style="font-size: 0.75rem; color: var(--text-secondary); text-transform: uppercase; letter-spacing: 0.05em;">
                <?= $beat['tipo'] === 'beat' ? 'Productor' : 'Artista' ?>
              </div>
              <span class="creator-name" style="font-size: 1.125rem;"><?= esc($beat['nombre_usuario']) ?></span>
            </div>
          </a>
        </div>
        <?php endif; ?>
        
        <div class="beat-meta">
          <span class="beat-genre"><?= esc($beat['genero']) ?></span>
          <?php if($beat['mood']): ?>
            <span class="beat-genre" style="background: rgba(139, 92, 246, 0.15); color: #a78bfa;">
              <?= esc($beat['mood']) ?>
            </span>
          <?php endif; ?>
        </div>
        
        <div class="detail-stats-grid">
          <div class="stat-box">
            <span class="stat-label">BPM</span>
            <div class="stat-value"><?= esc($beat['bpm']) ?></div>
          </div>
          <div class="stat-box">
            <span class="stat-label">Duración</span>
            <div class="stat-value"><?= esc($beat['duracion']) ?: '--' ?></div>
          </div>
          <div class="stat-box">
            <span class="stat-label">Tonalidad</span>
            <div class="stat-value"><?= esc($beat['nota_musical']) ?: '--' ?></div>
          </div>
          <div class="stat-box">
            <span class="stat-label">Estado</span>
            <div class="stat-value" style="color: #1ed760;">
              <?= ucfirst(esc($beat['estado'])) ?>
            </div>
          </div>
        </div>
        
        <div class="detail-price">
          $<?= number_format($beat['precio'], 2) ?>
        </div>
        
        <div class="action-buttons">
          <a href="#" class="btn-primary-detail">
            <i class="bi bi-cart-check-fill"></i>
            Comprar Beat
          </a>
          
          <?php if(session()->get('logueado')): 
            $favModel = new \App\Models\FavoritoModel();
            $esFavorito = $favModel->where('id_usuario', session()->get('id'))->where('id_beat', $beat['id'])->first();
          ?>
            <form method="post" action="<?= site_url($esFavorito ? 'catalogo/quitar_favorito/'.$beat['id'] : 'catalogo/agregar_favorito/'.$beat['id']) ?>">
              <?= csrf_field() ?>
              <button type="submit" class="fav-btn-detail <?= $esFavorito ? 'active' : '' ?>">
                <i class="bi <?= $esFavorito ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
              </button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Player Section -->
    <div class="player-section">
      <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1.5rem;">
        <i class="bi bi-play-circle"></i> Preview del Beat
      </h2>
      
      <div class="player-header">
        <button class="player-main-btn" id="play-btn">
          <i class="bi bi-play-fill"></i>
        </button>
        <div style="flex: 1;">
          <div id="waveform" class="waveform-detail"></div>
          <div class="player-time">
            <span id="current-time">0:00</span>
            <span id="duration">0:00</span>
          </div>
        </div>
      </div>
    </div>
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
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const playBtn = document.getElementById('play-btn');
      const currentTimeEl = document.getElementById('current-time');
      const durationEl = document.getElementById('duration');
      
      // Crear WaveSurfer
      const wavesurfer = WaveSurfer.create({
        container: '#waveform',
        waveColor: 'rgba(30, 215, 96, 0.3)',
        progressColor: '#1ed760',
        height: 80,
        barWidth: 3,
        barGap: 1,
        barRadius: 3,
        cursorWidth: 2,
        cursorColor: '#1ed760',
        responsive: true,
        normalize: true,
      });

      // Cargar el audio
      wavesurfer.load('<?= asset_url($beat['archivo_preview']) ?>');

      // Deshabilitar botón hasta que esté listo
      playBtn.disabled = true;

      // Cuando esté listo
      wavesurfer.on('ready', () => {
        playBtn.disabled = false;
        const duration = wavesurfer.getDuration();
        durationEl.textContent = formatTime(duration);
      });

      // Play/Pause
      playBtn.addEventListener('click', () => {
        wavesurfer.playPause();
      });

      // Eventos
      wavesurfer.on('play', () => {
        playBtn.innerHTML = '<i class="bi bi-pause-fill"></i>';
        playBtn.classList.add('playing');
      });

      wavesurfer.on('pause', () => {
        playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
        playBtn.classList.remove('playing');
      });

      wavesurfer.on('audioprocess', () => {
        const time = wavesurfer.getCurrentTime();
        currentTimeEl.textContent = formatTime(time);
      });

      wavesurfer.on('finish', () => {
        playBtn.innerHTML = '<i class="bi bi-play-fill"></i>';
        playBtn.classList.remove('playing');
        currentTimeEl.textContent = '0:00';
      });

      // Formato de tiempo
      function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs.toString().padStart(2, '0')}`;
      }
    });
  </script>
</body>
</html>
