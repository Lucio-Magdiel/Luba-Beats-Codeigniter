<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel de Artista - CHOJIN Beats</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

  <div class="container">
    <div class="artista-header">
      <h1>Panel de Artista</h1>
    </div>

    <div class="artista-top-links">
      <a href="<?= site_url() ?>">
        <i class="bi bi-house-door-fill"></i>
        <span>Inicio</span>
      </a>
      <a href="<?= site_url('usuario/playlists') ?>">
        <i class="bi bi-music-note-list"></i>
        <span>Playlists</span>
      </a>
      <a href="<?= site_url('usuario/mi-perfil') ?>">
        <i class="bi bi-person-circle"></i>
        <span>Perfil</span>
      </a>
      <a href="<?= site_url('artista/subir') ?>">
        <i class="bi bi-cloud-upload-fill"></i>
        <span>Subir nueva canción</span>
      </a>
      <a href="<?= site_url('auth/logout') ?>">
        <i class="bi bi-box-arrow-right"></i>
        <span>Cerrar sesión</span>
      </a>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
      <div class="artista-flash-success" role="alert">
        <?= esc(session()->getFlashdata('mensaje')) ?>
      </div>
    <?php endif; ?>

    <h2 style="color: #a3afbb; font-size: 1.75rem; margin-bottom: 1.5rem; font-weight: 700;">Tus Canciones</h2>

    <?php if (empty($beats)): ?>
      <div class="artista-empty-state">
        <i class="bi bi-music-note-list"></i>
        <p>No tienes canciones cargadas aún</p>
        <p class="subtitle">Comienza a subir tu música para promocionarla</p>
      </div>
    <?php else: ?>
      <div class="artista-table-responsive">
        <table class="artista-beats-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Título</th>
              <th>Género</th>
              <th>BPM</th>
              <th>Estado</th>
              <th>Duración</th>
              <th>Nota</th>
              <th>Visual</th>
              <th>Preview</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($beats as $beat): ?>
              <tr>
                <td><?= $beat['id'] ?></td>
                <td><?= esc($beat['titulo']) ?></td>
                <td><?= esc($beat['genero']) ?></td>
                <td><?= $beat['bpm'] ?></td>
                <td>
                  <span class="badge badge-<?= strtolower($beat['estado']) === 'oculto' ? 'secondary' : 'success' ?>">
                    <?= ucfirst(esc($beat['estado'])) ?>
                  </span>
                </td>
                <td><?= esc($beat['duracion']) ?></td>
                <td><?= esc($beat['nota_musical']) ?></td>
                <td>
                  <?php if(!empty($beat['archivo_visual'])): ?>
                    <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                      <img src="<?= asset_url($beat['archivo_visual']) ?>" alt="Visual">
                    <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
                      <video src="<?= asset_url($beat['archivo_visual']) ?>" controls></video>
                    <?php endif; ?>
                  <?php else: ?>
                    <span style="color: #5a6a4d; font-style: italic;">—</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if(!empty($beat['archivo_preview'])): ?>
                    <audio controls preload="none" src="<?= asset_url($beat['archivo_preview']) ?>"></audio>
                  <?php else: ?>
                    <span style="color: #5a6a4d; font-style: italic;">—</span>
                  <?php endif; ?>
                </td>
                <td class="artista-table-actions">
                  <a href="<?= site_url('artista/editar/'.$beat['id']) ?>">Editar</a>
                  <span class="separator">|</span>
                  <a href="<?= site_url('artista/esconder/'.$beat['id']) ?>" onclick="return confirm('¿Estás seguro que quieres esconder esta canción?');">Esconder</a>
                  <span class="separator">|</span>
                  <a href="<?= site_url('artista/eliminar/'.$beat['id']) ?>" onclick="return confirm('¿Estás seguro que quieres eliminar esta canción?');">Eliminar</a>
                  <?php if(strtolower($beat['estado']) == 'oculto'): ?>
                    <span class="separator">|</span>
                    <a href="<?= site_url('artista/publicar/'.$beat['id']) ?>" onclick="return confirm('¿Quieres publicar esta canción nuevamente?');">Publicar</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
