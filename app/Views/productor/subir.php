<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Subir nuevo Beat | CHOJIN Beats</title>
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
    <h1>Subir nuevo Beat</h1>

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

    <form method="post" action="<?= site_url('productor/guardar') ?>" enctype="multipart/form-data" autocomplete="off">
      <?= csrf_field() ?>
      
      <label class="form-label-productor" for="titulo">Título del beat</label>
      <input type="text" name="titulo" id="titulo" class="form-input-productor" required maxlength="100" placeholder="Ej: Moonlight Drill"/>

      <label class="form-label-productor" for="genero">Género</label>
      <input type="text" name="genero" id="genero" class="form-input-productor" required maxlength="40" placeholder="Ej: Trap, Drill..."/>

      <label class="form-label-productor" for="mood">Mood</label>
      <input type="text" name="mood" id="mood" class="form-input-productor" maxlength="30" placeholder="Ej: Melancólico, Épico…"/>

      <label class="form-label-productor" for="bpm">BPM</label>
      <input type="number" name="bpm" id="bpm" class="form-input-productor" min="60" max="220" required placeholder="Ej: 140"/>

      <label class="form-label-productor" for="duracion">Duración</label>
      <input type="text" name="duracion" id="duracion" class="form-input-productor" maxlength="10" placeholder="Ej: 3:20"/>

      <label class="form-label-productor" for="nota_musical">Nota musical</label>
      <input type="text" name="nota_musical" id="nota_musical" class="form-input-productor" maxlength="10" placeholder="Ej: Am, G#m…"/>

      <label class="form-label-productor" for="precio">Precio ($)</label>
      <input type="number" name="precio" id="precio" class="form-input-productor" step="0.01" min="0" required placeholder="Ej: 24.99"/>

      <label class="form-label-productor" for="archivo_visual">
        Visual (imagen o video) <span style="font-weight:400;">(opcional)</span>
      </label>
      <input type="file" name="archivo_visual" id="archivo_visual" class="form-input-productor" accept="image/*,video/mp4"/>

      <label class="form-label-productor" for="archivo_preview">
        Preview de audio <span style="font-weight:400;">(mp3, obligatorio)</span>
      </label>
      <input type="file" name="archivo_preview" id="archivo_preview" class="form-input-productor" accept="audio/mp3,audio/mpeg" required/>

      <button type="submit" class="btn-submit-productor">
        <i class="bi bi-cloud-upload-fill"></i> Subir Beat
      </button>
    </form>
    
    <div style="text-align:center;margin-top:2.8em;">
      <a href="<?= site_url('productor/panel') ?>" style="color:#65d36e;font-weight:700;text-decoration:underline;font-size:1.09em;">
        &larr; Regresar al Panel de Productor
      </a>
    </div>
  </div>

  <!-- Scripts -->
  <script src="<?= base_url('assets/js/app.js') ?>"></script>
</body>
</html>