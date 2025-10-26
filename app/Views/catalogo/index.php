<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Catálogo profesional de beats musicales - CHOJIN BEATS">
  <title>Catálogo de Beats | CHOJIN BEATS</title>
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  
  <!-- WaveSurfer.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/wavesurfer.js/6.6.4/wavesurfer.min.js"></script>
  
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>
  
  <!-- Header con Tabs de Navegación -->
  <header class="catalog-header">
    <div class="header-content">
      <a href="<?= site_url('catalogo') ?>" class="logo">
        <i class="bi bi-music-note-beamed"></i>
        CHOJIN
      </a>
      
      <!-- Tabs de Navegación -->
      <nav class="catalog-tabs">
        <a href="<?= site_url('catalogo') ?>" class="tab-link active">
          <i class="bi bi-grid-fill"></i>
          Todo
        </a>
        <a href="<?= site_url('catalogo/beats') ?>" class="tab-link">
          <i class="bi bi-disc-fill"></i>
          Beats
        </a>
        <a href="<?= site_url('catalogo/musica') ?>" class="tab-link">
          <i class="bi bi-music-note-list"></i>
          Música
        </a>
      </nav>

      <div class="nav-links">
        <?php if(session()->get('logueado')): ?>
          <?php if(session()->get('tipo')=='productor'): ?>
            <a href="<?= site_url('productor/panel') ?>" class="nav-btn">
              <i class="bi bi-speedometer2"></i>
              Panel
            </a>
          <?php elseif(session()->get('tipo')=='artista'): ?>
            <a href="<?= site_url('artista/panel') ?>" class="nav-btn">
              <i class="bi bi-speedometer2"></i>
              Panel
            </a>
          <?php endif; ?>
          
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
          
          <a href="<?= site_url('auth/logout') ?>" class="nav-btn">
            <i class="bi bi-box-arrow-right"></i>
            Salir
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
      <i class="bi bi-music-note-beamed"></i> Explora Nuestra Colección
    </h1>
    <p class="hero-subtitle">
      Beats profesionales y música gratuita para tus proyectos
    </p>
    
    <!-- Barra de Búsqueda -->
    <form method="get" action="<?= site_url('catalogo') ?>" class="search-form">
      <div class="search-bar">
        <i class="bi bi-search"></i>
        <input 
          type="text" 
          name="q" 
          placeholder="Buscar por título o género..." 
          class="search-input"
        />
        <button type="submit" class="search-btn">
          Buscar
        </button>
      </div>
    </form>
  </section>

  <!-- Main Content con Secciones en Columnas -->
  <main class="catalog-main">
    <?php if(session()->getFlashdata('mensaje')): ?>
      <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('mensaje') ?>
      </div>
    <?php endif; ?>

    <?php if(empty($todos)): ?>
      <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <p style="font-size: 1.25rem; font-weight: 600; margin-top: 1rem;">
          No hay contenido disponible
        </p>
      </div>
    <?php else: ?>
      
      <!-- Container de 2 Columnas -->
      <div class="sections-container">
        
        <!-- COLUMNA IZQUIERDA: BEATS -->
        <?php if(!empty($beats)): ?>
        <div class="section-column">
          <div class="section-header">
            <h2 class="section-title">
              <i class="bi bi-disc-fill" style="color: #1ed760;"></i>
              Beats Profesionales
            </h2>
            <a href="<?= site_url('catalogo/beats') ?>" class="section-link">
              Ver todos
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
          
          <div class="beats-grid">
            <?php foreach(array_slice($beats, 0, 6) as $beat): ?>
          <article class="beat-card" onclick="window.location='<?= site_url('catalogo/detalle/'.$beat['id']) ?>'">
            <!-- Visual -->
            <div class="beat-visual-container">
              <?php if(!empty($beat['archivo_visual'])): ?>
                <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                  <img src="<?= base_url($beat['archivo_visual']) ?>" 
                       alt="<?= esc($beat['titulo']) ?>"
                       class="beat-visual">
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
              
              <!-- Badge de Beat -->
              <div class="beat-type-badge beat">
                <i class="bi bi-disc-fill"></i>
                BEAT
              </div>
            </div>

            <!-- Info -->
            <div class="beat-info">
              <h3 class="beat-title"><?= esc($beat['titulo']) ?></h3>
              
              <!-- Información del creador -->
              <a href="<?= site_url('perfil/' . $beat['nombre_usuario']) ?>" 
                 class="beat-creator" 
                 onclick="event.stopPropagation();"
                 title="Ver perfil de <?= esc($beat['nombre_usuario']) ?>">
                <div class="creator-avatar">
                  <?php if (!empty($beat['foto_perfil'])): ?>
                    <img src="<?= asset_url($beat['foto_perfil']) ?>" alt="<?= esc($beat['nombre_usuario']) ?>">
                  <?php else: ?>
                    <i class="bi bi-person-circle"></i>
                  <?php endif; ?>
                </div>
                <span class="creator-name"><?= esc($beat['nombre_usuario']) ?></span>
              </a>
              
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
                <button class="play-btn" data-id="<?= $beat['id'] ?>" data-src="<?= base_url($beat['archivo_preview']) ?>">
                  <i class="bi bi-play-fill"></i>
                </button>
                <span class="time-display" id="time-<?= $beat['id'] ?>">0:00</span>
                
                <?php if(session()->get('logueado')): ?>
                <button class="add-to-playlist-btn" 
                        onclick="event.stopPropagation(); openAddToPlaylistModal(<?= $beat['id'] ?>, '<?= esc($beat['titulo']) ?>');"
                        title="Agregar a playlist">
                  <i class="bi bi-plus-circle"></i>
                </button>
                <?php endif; ?>
                
                <!-- Precio destacado -->
                <span class="beat-price" style="margin-left: auto;">
                  $<?= number_format($beat['precio'], 2) ?>
                </span>
              </div>
            </div>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>

        <!-- COLUMNA DERECHA: MÚSICA -->
        <?php if(!empty($musica)): ?>
        <div class="section-column">
          <div class="section-header">
            <h2 class="section-title">
              <i class="bi bi-music-note-list" style="color: #9333ea;"></i>
              Música Gratuita
            </h2>
            <a href="<?= site_url('catalogo/musica') ?>" class="section-link">
              Ver todas
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
          
          <div class="beats-grid">
            <?php foreach(array_slice($musica, 0, 6) as $track): ?>
          <article class="beat-card musica-type" onclick="window.location='<?= site_url('catalogo/detalle/'.$track['id']) ?>'" style="border-color: rgba(147, 51, 234, 0.2);">
            <!-- Visual -->
            <div class="beat-visual-container">
              <?php if(!empty($track['archivo_visual'])): ?>
                <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $track['archivo_visual'])): ?>
                  <img src="<?= base_url($track['archivo_visual']) ?>" 
                       alt="<?= esc($track['titulo']) ?>"
                       class="beat-visual">
                <?php elseif(preg_match('/\.mp4$/i', $track['archivo_visual'])): ?>
                  <video src="<?= base_url($track['archivo_visual']) ?>" 
                         class="beat-visual"
                         muted 
                         loop></video>
                <?php endif; ?>
              <?php else: ?>
                <div class="beat-visual placeholder">
                  <i class="bi bi-music-note-beamed"></i>
                </div>
              <?php endif; ?>
              
              <!-- Badge de Música -->
              <div class="beat-type-badge musica">
                <i class="bi bi-music-note-list"></i>
                MÚSICA
              </div>
            </div>

            <!-- Info -->
            <div class="beat-info">
              <h3 class="beat-title"><?= esc($track['titulo']) ?></h3>
              
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
                <span class="beat-genre" style="background: rgba(147, 51, 234, 0.15); color: #9333ea;"><?= esc($track['genero']) ?></span>
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
            <div class="beat-player" onclick="event.stopPropagation();">
              <div class="waveform-wrapper" style="background: rgba(147, 51, 234, 0.05);">
                <div class="waveform" id="waveform-<?= $track['id'] ?>"></div>
              </div>
              
              <div class="player-controls">
                <button class="play-btn musica-btn" data-id="<?= $track['id'] ?>" data-src="<?= base_url($track['archivo_preview']) ?>" style="background: #9333ea;">
                  <i class="bi bi-play-fill"></i>
                </button>
                <span class="time-display" id="time-<?= $track['id'] ?>">0:00</span>
                
                <?php if(session()->get('logueado')): ?>
                <button class="add-to-playlist-btn" 
                        onclick="event.stopPropagation(); openAddToPlaylistModal(<?= $track['id'] ?>, '<?= esc($track['titulo']) ?>');"
                        title="Agregar a playlist"
                        style="background: rgba(147, 51, 234, 0.2); color: #9333ea;">
                  <i class="bi bi-plus-circle"></i>
                </button>
                <?php endif; ?>
                
                <span style="margin-left: auto; color: #22c55e; font-weight: 700; font-size: 0.875rem;">
                  GRATIS
                </span>
              </div>
            </div>
            <?php endif; ?>
          </article>
          <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
        
      </div>
      <!-- Fin del sections-container -->
      
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
    // WaveSurfer Player para Beats y Música
    const players = {};
    
    document.addEventListener('DOMContentLoaded', () => {
      const playButtons = document.querySelectorAll('.play-btn');
      
      playButtons.forEach(btn => {
        const id = btn.dataset.id;
        const src = btn.dataset.src;
        const waveformEl = document.getElementById('waveform-' + id);
        const timeEl = document.getElementById('time-' + id);
        const isMusica = btn.classList.contains('musica-btn');
        
        // Crear WaveSurfer con color según el tipo
        const wavesurfer = WaveSurfer.create({
          container: waveformEl,
          waveColor: isMusica ? 'rgba(147, 51, 234, 0.3)' : 'rgba(30, 215, 96, 0.3)',
          progressColor: isMusica ? '#9333ea' : '#1ed760',
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

  <!-- Modal Agregar a Playlist -->
  <?php if(session()->get('logueado')): ?>
    <?= view('components/add_to_playlist_modal') ?>
  <?php endif; ?>

</body>
</html>
