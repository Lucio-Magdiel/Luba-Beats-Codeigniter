<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Subir Nueva Canción | CHOJIN Beats</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

  <div class="artista-upload-container">
    <div class="artista-upload-form">
      <h1>Subir Nueva Canción</h1>

      <?php if(session()->getFlashdata('mensaje')): ?>
        <div class="artista-flash-success" role="alert">
          <?= esc(session()->getFlashdata('mensaje')) ?>
        </div>
      <?php endif; ?>
      <?php if(session()->getFlashdata('error')): ?>
        <div class="artista-flash-error" role="alert">
          <?= esc(session()->getFlashdata('error')) ?>
        </div>
      <?php endif; ?>

      <form method="post" action="<?= site_url('artista/guardar') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <label class="artista-form-label" for="titulo">Título de la canción</label>
        <input type="text" name="titulo" id="titulo" class="artista-form-input" required maxlength="100" placeholder="Ej: Moonlight Dreams">

        <label class="artista-form-label" for="genero">Género</label>
        <input type="text" name="genero" id="genero" class="artista-form-input" required maxlength="40" placeholder="Ej: Hip-Hop, R&B, Pop...">

        <label class="artista-form-label" for="mood">Mood <span class="optional">(opcional)</span></label>
        <input type="text" name="mood" id="mood" class="artista-form-input" maxlength="30" placeholder="Ej: Melancólico, Épico, Romántico...">

        <label class="artista-form-label" for="bpm">BPM</label>
        <input type="number" name="bpm" id="bpm" class="artista-form-input" min="60" max="220" required placeholder="140">

        <label class="artista-form-label" for="duracion">Duración</label>
        <input type="text" name="duracion" id="duracion" class="artista-form-input" maxlength="10" placeholder="3:20">

        <label class="artista-form-label" for="nota_musical">Nota musical <span class="optional">(opcional)</span></label>
        <input type="text" name="nota_musical" id="nota_musical" class="artista-form-input" maxlength="10" placeholder="Ej: Am, G#m, C...">

        <div class="artista-promo-notice">
          <p>
            <i class="bi bi-info-circle-fill"></i>
            <span><strong>Nota:</strong> Como artista, tu música se comparte de forma gratuita para promoción y difusión de tu trabajo.</span>
          </p>
        </div>

        <label class="artista-form-label" for="archivo_visual">Visual <span class="optional">(imagen o video, opcional)</span></label>
        <input type="file" name="archivo_visual" id="archivo_visual" class="artista-form-input" accept="image/*,video/mp4">

        <label class="artista-form-label" for="archivo_preview">Archivo de audio <span class="optional">(mp3, obligatorio)</span></label>
        <input type="file" name="archivo_preview" id="archivo_preview" class="artista-form-input" accept="audio/mp3,audio/mpeg" required>

        <button type="submit" class="artista-btn-submit">
          <i class="bi bi-cloud-upload-fill"></i>
          <span>Subir Canción</span>
        </button>
      </form>

      <div class="artista-back-link">
        <a href="<?= site_url('artista/panel') ?>">
          <i class="bi bi-arrow-left"></i>
          <span>Regresar al Panel</span>
        </a>
      </div>
    </div>
  </div>

</body>
</html>
