<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <title>Panel Productor - CHOJIN Beats</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
  
  <!-- Estilos Personalizados -->
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

  <div class="container py-6">

    <div class="productor-header">
      <h1>Panel de Productor</h1>
    </div>

    <div class="top-links">
      <a href="<?= site_url() ?>" aria-label="Ir al inicio">
        <i class="bi bi-house-door-fill"></i> Inicio
      </a>
      <a href="<?= site_url('usuario/playlists') ?>" aria-label="Mis playlists">
        <i class="bi bi-music-note-list"></i> Playlists
      </a>
      <a href="<?= site_url('usuario/mi-perfil') ?>" aria-label="Mi perfil">
        <i class="bi bi-person-circle"></i> Perfil
      </a>
      <a href="<?= site_url('productor/subir') ?>" aria-label="Subir nuevo beat">
        <i class="bi bi-cloud-upload-fill"></i> Subir nuevo beat
      </a>
      <a href="<?= site_url('auth/logout') ?>" aria-label="Cerrar sesión">
        <i class="bi bi-box-arrow-right"></i> Cerrar sesión
      </a>
    </div>

    <?php if(session()->getFlashdata('mensaje')): ?>
      <div class="flash-msg-productor" role="alert" aria-live="polite">
        <?= esc(session()->getFlashdata('mensaje')) ?>
      </div>
    <?php endif; ?>

    <h2 class="mb-6">Tus Beats</h2>

    <?php if (empty($beats)): ?>
      <p class="empty-state">No tienes beats cargados aún.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="beats-table" role="table" aria-label="Lista de beats del productor">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Título</th>
              <th scope="col">Género</th>
              <th scope="col">BPM</th>
              <th scope="col">Estado</th>
              <th scope="col">Precio</th>
              <th scope="col">Duración</th>
              <th scope="col">Nota</th>
              <th scope="col">Visual</th>
              <th scope="col">Preview</th>
              <th scope="col">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($beats as $beat): ?>
              <tr>
                <td><?= $beat['id'] ?></td>
                <td><?= esc($beat['titulo']) ?></td>
                <td><?= esc($beat['genero']) ?></td>
                <td><?= $beat['bpm'] ?></td>
                <td><?= ucfirst(esc($beat['estado'])) ?></td>
                <td>$<?= number_format($beat['precio'], 2) ?></td>
                <td><?= esc($beat['duracion']) ?></td>
                <td><?= esc($beat['nota_musical']) ?></td>
                <td>
                  <?php if(!empty($beat['archivo_visual'])): ?>
                    <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
                      <img src="<?= base_url($beat['archivo_visual']) ?>" alt="Visual del beat <?= esc($beat['titulo']) ?>">
                    <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
                      <video src="<?= base_url($beat['archivo_visual']) ?>" controls aria-label="Video preview del beat <?= esc($beat['titulo']) ?>"></video>
                    <?php endif; ?>
                  <?php else: ?>
                    <span style="color:#5a6a4d;font-style: italic;">No disponible</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php if(!empty($beat['archivo_preview'])): ?>
                    <audio controls preload="none" src="<?= base_url($beat['archivo_preview']) ?>" aria-label="Audio preview del beat <?= esc($beat['titulo']) ?>"></audio>
                  <?php else: ?>
                    <span style="color:#5a6a4d;font-style: italic;">No disponible</span>
                  <?php endif; ?>
                </td>
                <td class="actions">
                  <a href="<?= site_url('productor/editar/'.$beat['id']) ?>" aria-label="Editar beat <?= esc($beat['titulo']) ?>">Editar</a> |
                  <a href="<?= site_url('productor/esconder/'.$beat['id']) ?>" onclick="return confirm('¿Estás seguro que quieres esconder este beat?');" aria-label="Esconder beat <?= esc($beat['titulo']) ?>">Esconder</a> |
                  <a href="<?= site_url('productor/eliminar/'.$beat['id']) ?>" onclick="return confirm('¿Estás seguro que quieres eliminar este beat?');" aria-label="Eliminar beat <?= esc($beat['titulo']) ?>">Eliminar</a>
                  <?php if(strtolower($beat['estado']) == 'oculto'): ?>
                    | <a href="<?= site_url('productor/publicar/'.$beat['id']) ?>" onclick="return confirm('¿Quieres publicar este beat nuevamente?');" aria-label="Publicar beat <?= esc($beat['titulo']) ?>">Publicar</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>

  <!-- Scripts -->
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>