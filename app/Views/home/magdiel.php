<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magdiel UCHIHA - Perfil | CHOJIN BEATS</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    
    <style>
        .profile-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }
        
        .profile-card {
            background: rgba(30, 33, 37, 0.95);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(101, 211, 110, 0.2);
        }
        
        .profile-card h1 {
            font-size: 2.75rem;
            font-weight: 900;
            background: linear-gradient(135deg, #1ed760 0%, #1db954 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 2rem;
            letter-spacing: -0.02em;
        }
        
        .profile-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1ed760;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .profile-card h2 i {
            font-size: 1.75rem;
        }
        
        .profile-card p {
            font-size: 1.05rem;
            line-height: 1.7;
            color: var(--gray-300);
            margin-bottom: 1.5rem;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 0.75rem 1.5rem;
            background: transparent;
            color: #1ed760;
            border: 2px solid #1ed760;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s;
        }
        
        .btn-back:hover {
            background: #1ed760;
            color: #000;
            transform: translateX(-4px);
        }
        
        .profile-footer {
            text-align: center;
            padding: 2rem 1rem;
            color: var(--gray-500);
            font-size: 0.95rem;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <a href="<?= site_url('catalogo') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Volver al catálogo</span>
        </a>
        
        <div class="profile-card">
            <h1>Magdiel UCHIHA</h1>

            <h2>
                <i class="bi bi-person-circle"></i>
                Acerca del creador
            </h2>
            <p>
                Bienvenido al perfil oficial de Magdiel UCHIHA, creador y desarrollador de CHOJIN BEATS.
                Esta plataforma nace con la visión de conectar productores y artistas musicales, facilitando
                la distribución y comercialización de beats profesionales.
            </p>

            <h2>
                <i class="bi bi-code-slash"></i>
                Proyectos y desarrollo
            </h2>
            <p>
                CHOJIN BEATS es una plataforma desarrollada con las últimas tecnologías web, diseñada para
                ofrecer la mejor experiencia tanto a productores como a compradores de beats. El sistema
                incluye gestión de usuarios, catálogos dinámicos, reproducción de audio integrada y mucho más.
            </p>

            <h2>
                <i class="bi bi-envelope"></i>
                Contacto
            </h2>
            <p>
                Para colaboraciones, proyectos o soporte técnico, puedes contactar a Magdiel a través de
                la sección de <a href="<?= site_url('contacto') ?>" style="color: #1ed760; font-weight: 700; text-decoration: underline;">contacto</a>
                de la plataforma.
            </p>
        </div>
    </div>

    <footer class="profile-footer">
        <i class="bi bi-music-note-beamed" style="color: #1ed760; font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        &copy; <?= date('Y') ?> Magdiel UCHIHA - CHOJIN BEATS
    </footer>
</body>
</html>
