<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Magdiel UCHIHA - Desarrollador | LubaBeats Beta</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/app.css') ?>">
    
    <style>
        body {
            background: linear-gradient(135deg, #0f0f1e 0%, #1a1a2e 100%);
            min-height: 100vh;
        }
        
        .profile-container {
            max-width: 900px;
            margin: 3rem auto;
            padding: 0 1.5rem;
        }
        
        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        
        .avatar-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
            position: relative;
        }
        
        .avatar-upload {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 4px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .avatar-initials {
            font-size: 4rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -2px;
        }
        
        .upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #8b5cf6, #ec4899);
            border: 3px solid #0f0f1e;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 0.2s;
        }
        
        .upload-btn:hover {
            transform: scale(1.1);
        }
        
        .upload-btn i {
            color: #fff;
            font-size: 1.1rem;
        }
        
        .profile-card {
            background: rgba(30, 33, 37, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            margin-bottom: 2rem;
        }
        
        .profile-card h1 {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }
        
        .role-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            background: rgba(139, 92, 246, 0.15);
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 50px;
            color: #a78bfa;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }
        
        .profile-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #a78bfa;
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
            line-height: 1.8;
            color: var(--gray-300);
            margin-bottom: 1.5rem;
        }
        
        .social-links {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: var(--gray-300);
            text-decoration: none;
            transition: all 0.2s;
        }
        
        .social-link:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: #8b5cf6;
            color: #a78bfa;
            transform: translateY(-2px);
        }
        
        .social-link i {
            font-size: 1.25rem;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 2rem;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.05);
            color: #a78bfa;
            border: 1px solid rgba(139, 92, 246, 0.3);
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s;
        }
        
        .btn-back:hover {
            background: rgba(139, 92, 246, 0.15);
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
        
        <div class="profile-header">
            <div class="avatar-container">
                <div class="avatar-upload" id="avatarPreview">
                    <span class="avatar-initials">MU</span>
                </div>
                <label for="avatarInput" class="upload-btn" title="Subir foto de perfil">
                    <i class="bi bi-camera-fill"></i>
                </label>
                <input type="file" id="avatarInput" accept="image/*" style="display: none;">
            </div>
        </div>
        
        <div class="profile-card">
            <h1>Magdiel UCHIHA</h1>
            <div style="text-align: center;">
                <span class="role-badge">Full Stack Developer</span>
            </div>

            <h2>
                <i class="bi bi-person-badge"></i>
                Acerca del Desarrollador
            </h2>
            <p>
                Full Stack Developer apasionado por crear experiencias digitales innovadoras. 
                Desarrollador principal de <strong>LubaBeats Beta</strong>, una plataforma que nace con la visión 
                de conectar productores y artistas musicales, facilitando la distribución y comercialización 
                de beats profesionales de manera completamente gratuita.
            </p>

            <h2>
                <i class="bi bi-rocket-takeoff"></i>
                Historia del Proyecto
            </h2>
            <p>
                LubaBeats Beta comenzó como un proyecto personal para mi hermano <strong>Chojin</strong>, 
                un talentoso productor musical. Lo que inició como una plataforma para la venta de sus beats 
                evolucionó en una visión más grande: crear un espacio donde cualquier productor o artista 
                pueda compartir su música. El nombre proviene de <strong>LUBA</strong>, nuestra empresa familiar, 
                representando el esfuerzo conjunto de nuestra familia en este emprendimiento.
            </p>

            <h2>
                <i class="bi bi-code-slash"></i>
                Tecnología y Desarrollo
            </h2>
            <p>
                Esta versión Beta está desarrollada con <strong>CodeIgniter 4, PHP, MySQL y Cloudinary</strong>, 
                diseñada para ofrecer la mejor experiencia tanto a productores como a usuarios. El sistema 
                incluye gestión de usuarios, catálogos dinámicos, reproducción de audio integrada, playlists 
                personalizadas y mucho más. Actualmente trabajando en la próxima generación con 
                <strong>Next.js, Express.js y Supabase</strong>.
            </p>

            <h2>
                <i class="bi bi-chat-dots"></i>
                Conecta Conmigo
            </h2>
            <p style="text-align: center; margin-bottom: 1rem;">
                ¿Tienes un proyecto en mente? ¿Necesitas colaborar o quieres saber más sobre LubaBeats? 
                ¡Hablemos!
            </p>
            
            <div class="social-links">
                <a href="#" class="social-link">
                    <i class="bi bi-facebook"></i>
                    <span>Facebook</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-instagram"></i>
                    <span>Instagram</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-tiktok"></i>
                    <span>TikTok</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-youtube"></i>
                    <span>YouTube</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-twitter-x"></i>
                    <span>Twitter/X</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-github"></i>
                    <span>GitHub</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-linkedin"></i>
                    <span>LinkedIn</span>
                </a>
                <a href="<?= site_url('contacto') ?>" class="social-link">
                    <i class="bi bi-envelope"></i>
                    <span>Email</span>
                </a>
            </div>
        </div>
    </div>

    <footer class="profile-footer">
        <i class="bi bi-heart-fill" style="color: #ec4899; font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        Desarrollado con pasión por Magdiel UCHIHA
        <br>
        <small>&copy; <?= date('Y') ?> LubaBeats Beta - Familia LUBA</small>
    </footer>

    <script>
        // Preview de avatar cuando se selecciona una imagen
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const avatarPreview = document.getElementById('avatarPreview');
                    avatarPreview.innerHTML = `<img src="${event.target.result}" style="width: 100%; height: 100%; object-fit: cover;">`;
                    
                    // Aquí podrías agregar la lógica para subir la imagen a Cloudinary
                    // Por ahora solo muestra el preview
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
