<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Link de Inicio de Sesión</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            text-align: center;
            color: white;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .content h2 {
            color: #333;
            font-size: 22px;
            margin-top: 0;
        }
        .content p {
            color: #666;
            font-size: 16px;
            margin: 15px 0;
        }
        .button {
            display: inline-block;
            padding: 16px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 25px 0;
            transition: transform 0.2s;
        }
        .button:hover {
            transform: translateY(-2px);
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 14px;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            font-size: 13px;
            color: #999;
        }
        .footer a {
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎵 CHOJIN BEATS</h1>
            <p>Tu Marketplace de Beats Premium</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <h2>¡Hola, <?= esc($nombre) ?>!</h2>
            
            <p>Has solicitado un enlace mágico para iniciar sesión en tu cuenta de CHOJIN Beats.</p>
            
            <p>Haz clic en el botón de abajo para acceder automáticamente a tu cuenta:</p>
            
            <div style="text-align: center;">
                <a href="<?= $link ?>" class="button">
                    🔐 Iniciar Sesión Ahora
                </a>
            </div>
            
            <div class="info-box">
                <p><strong>⏰ Este enlace expira en 15 minutos</strong></p>
                <p>Por razones de seguridad, solo puedes usar este enlace una vez.</p>
            </div>
            
            <p style="font-size: 14px; color: #999; margin-top: 30px;">
                Si el botón no funciona, copia y pega este enlace en tu navegador:
            </p>
            <p style="font-size: 13px; word-break: break-all; color: #667eea;">
                <?= $link ?>
            </p>
            
            <p style="font-size: 14px; color: #999; margin-top: 30px;">
                <strong>¿No solicitaste este enlace?</strong><br>
                Puedes ignorar este correo de forma segura. Nadie podrá acceder a tu cuenta sin este enlace.
            </p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>© <?= date('Y') ?> CHOJIN BEATS · Todos los derechos reservados</p>
            <p>Desarrollado con ❤️ por <a href="#">LUBA</a></p>
        </div>
    </div>
</body>
</html>
