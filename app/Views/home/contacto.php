<!DOCTYPE html>
<html>
<head>
    <title>Contacto - LubaBeats Beta</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Contacto</h1>
    <?php if(session()->getFlashdata('mensaje')): ?>
        <div style="color: green;"><?= session()->getFlashdata('mensaje') ?></div>
    <?php endif; ?>
    <form method="post" action="<?= site_url('contacto') ?>">
        <?= csrf_field() ?>
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Mensaje:</label><br>
        <textarea name="mensaje" required></textarea><br><br>
        <button type="submit">Enviar mensaje</button>
    </form>
    <br><a href="<?= site_url('/') ?>">Volver al Home</a>
</body>
</html>
