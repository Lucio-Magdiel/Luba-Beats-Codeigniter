<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Editar Beat | LubaBeats Beta</title>
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

  <div class="upload-form-container mt-8">
    <h1>Editar Beat</h1>

    <?php if(session()->getFlashdata('mensaje')): ?>
      <div class="flash-msg-productor" role="alert" aria-live="polite">
        <?= esc(session()->getFlashdata('mensaje')) ?>
      </div>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
      <div class="flash-msg-productor error" role="alert" aria-live="assertive">
        <?= esc(session()->getFlashdata('error')) ?>
      </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('productor/editar/'.$beat['id']) ?>" enctype="multipart/form-data" autocomplete="off" novalidate>
      <?= csrf_field() ?>
      
      <label class="form-label-productor" for="titulo">Título del beat</label>
      <input type="text" name="titulo" id="titulo" class="form-input-productor" required maxlength="100" value="<?= esc($beat['titulo']) ?>" />

      <label class="form-label-productor" for="genero">Género</label>
      <input type="text" name="genero" id="genero" class="form-input-productor" required maxlength="40" value="<?= esc($beat['genero']) ?>" />

      <label class="form-label-productor" for="mood">Mood</label>
      <input type="text" name="mood" id="mood" class="form-input-productor" maxlength="30" value="<?= esc($beat['mood']) ?>" />

      <label class="form-label-productor" for="bpm">BPM</label>
      <input type="number" name="bpm" id="bpm" class="form-input-productor" min="60" max="220" required value="<?= esc($beat['bpm']) ?>" />

      <label class="form-label-productor" for="duracion">Duración</label>
      <input type="text" name="duracion" id="duracion" class="form-input-productor" maxlength="10" value="<?= esc($beat['duracion']) ?>" />

      <label class="form-label-productor" for="nota_musical">Nota musical</label>
      <input type="text" name="nota_musical" id="nota_musical" class="form-input-productor" maxlength="10" value="<?= esc($beat['nota_musical']) ?>" />

      <label class="form-label-productor" for="precio">Precio ($)</label>
      <input type="number" name="precio" id="precio" class="form-input-productor" step="0.01" min="0" required value="<?= esc($beat['precio']) ?>" />

      <label class="form-label-productor" for="archivo_visual">
        Visual (imagen o video) <span style="font-weight:400;">(opcional)</span>
      </label>
      <input type="file" name="archivo_visual" id="archivo_visual" class="form-input-productor" accept="image/*,video/mp4" />

      <?php if(!empty($beat['archivo_visual'])): ?>
        <div class="visual-preview">
          Visual actual:
          <?php 
          // Detectar si es URL de Cloudinary (completa) o ruta local
          $visualUrl = (strpos($beat['archivo_visual'], 'http') === 0) 
                      ? $beat['archivo_visual'] 
                      : asset_url($beat['archivo_visual']);
          ?>
          <?php if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $beat['archivo_visual'])): ?>
            <img src="<?= $visualUrl ?>" alt="Visual actual">
          <?php elseif(preg_match('/\.mp4$/i', $beat['archivo_visual'])): ?>
            <video src="<?= $visualUrl ?>" controls aria-label="Visual actual"></video>
          <?php endif; ?>
        </div>
      <?php endif; ?>

      <label class="form-label-productor" for="archivo_preview">
        Preview de audio <span style="font-weight:400;">(mp3)</span>
      </label>
      <input type="file" name="archivo_preview" id="archivo_preview" class="form-input-productor" accept="audio/mp3,audio/mpeg" />

      <?php if(!empty($beat['archivo_preview'])): ?>
        <?php 
        // Detectar si es URL de Cloudinary (completa) o ruta local
        $audioUrl = (strpos($beat['archivo_preview'], 'http') === 0) 
                   ? $beat['archivo_preview'] 
                   : asset_url($beat['archivo_preview']);
        ?>
        <audio controls preload="none" src="<?= $audioUrl ?>" class="visual-preview" aria-label="Preview actual"></audio>
      <?php endif; ?>

      <div class="btn-group-productor">
        <button type="submit" class="btn-submit-productor" style="flex: 1;">
          <i class="bi bi-save-fill"></i> Guardar Cambios
        </button>
        <a href="<?= site_url('productor/panel') ?>" class="btn-cancel-productor" role="button" aria-label="Cancelar y volver al panel">
          <i class="bi bi-x-circle-fill"></i> Cancelar
        </a>
      </div>
    </form>
  </div>

  <!-- Scripts -->
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>
