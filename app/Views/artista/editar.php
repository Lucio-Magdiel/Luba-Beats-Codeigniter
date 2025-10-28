<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar Canción | CHOJIN Beats</title>
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
</head>
<body>

  <div class="artista-edit-container">
    <div class="artista-edit-form">
      <h1>Editar Canción</h1>

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

      <form method="post" action="<?= site_url('artista/editar/'.$beat['id']) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <label class="artista-form-label" for="titulo">Título de la canción</label>
        <input type="text" name="titulo" id="titulo" class="artista-form-input" required maxlength="100" value="<?= esc($beat['titulo']) ?>">

        <label class="artista-form-label" for="genero">Género</label>
        <input type="text" name="genero" id="genero" class="artista-form-input" required maxlength="40" value="<?= esc($beat['genero']) ?>">

        <label class="artista-form-label" for="mood">Mood <span class="optional">(opcional)</span></label>
        <input type="text" name="mood" id="mood" class="artista-form-input" maxlength="30" value="<?= esc($beat['mood']) ?>">

        <label class="artista-form-label" for="bpm">BPM</label>
        <input type="number" name="bpm" id="bpm" class="artista-form-input" min="60" max="220" required value="<?= esc($beat['bpm']) ?>">

        <label class="artista-form-label" for="duracion">Duración</label>
        <input type="text" name="duracion" id="duracion" class="artista-form-input" maxlength="10" value="<?= esc($beat['duracion']) ?>">

        <label class="artista-form-label" for="nota_musical">Nota musical <span class="optional">(opcional)</span></label>
        <input type="text" name="nota_musical" id="nota_musical" class="artista-form-input" maxlength="10" value="<?= esc($beat['nota_musical']) ?>">

        <div class="artista-promo-notice">
          <p>
            <i class="bi bi-info-circle-fill"></i>
            <span><strong>Nota:</strong> Tu música se comparte gratuitamente para promoción y difusión de tu trabajo.</span>
          </p>
        </div>

        <label class="artista-form-label" for="archivo_visual">Visual <span class="optional">(imagen o video, opcional)</span></label>
        <input type="file" name="archivo_visual" id="archivo_visual" class="artista-form-input" accept="image/*,video/mp4">

        <?php if(!empty($beat['archivo_visual'])): ?>
          <div class="artista-visual-preview">
            <p>Visual actual:</p>
            <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
              <img src="<?= asset_url($beat['archivo_visual']) ?>" alt="Visual actual">
            <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
              <video src="<?= asset_url($beat['archivo_visual']) ?>" controls></video>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <label class="artista-form-label" for="archivo_preview">Archivo de audio <span class="optional">(mp3)</span></label>
        <input type="file" name="archivo_preview" id="archivo_preview" class="artista-form-input" accept="audio/mp3,audio/mpeg">

        <?php if(!empty($beat['archivo_preview'])): ?>
          <div class="artista-audio-preview">
            <audio controls preload="none" src="<?= asset_url($beat['archivo_preview']) ?>"></audio>
          </div>
        <?php endif; ?>

        <div class="artista-btn-group">
          <button type="submit" class="artista-btn-save">
            <i class="bi bi-save-fill"></i>
            <span>Guardar Cambios</span>
          </button>
          <a href="<?= site_url('artista/panel') ?>" class="artista-btn-cancel">
            <i class="bi bi-x-circle-fill"></i>
            <span>Cancelar</span>
          </a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>

