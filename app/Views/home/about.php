<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?></title>
    <meta name="description" content="Conoce la historia de LubaBeats Beta, una plataforma gratuita de beats creada por la familia LUBA. Desarrollada por Magdiel UCHIHA.">
    
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
        
        .about-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }
        
        /* Header Hero */
        .about-hero {
            text-align: center;
            padding: 4rem 2rem;
            margin-bottom: 4rem;
            position: relative;
        }
        
        .hero-logo {
            width: 120px;
            height: 120px;
            margin: 0 auto 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .hero-logo svg {
            filter: drop-shadow(0 10px 30px rgba(139, 92, 246, 0.3));
        }
        
        .about-hero h1 {
            font-size: 4rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fff 0%, #a78bfa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
            letter-spacing: -0.03em;
        }
        
        .about-hero .subtitle {
            font-size: 1.5rem;
            color: var(--gray-400);
            font-weight: 500;
            margin-bottom: 2rem;
        }
        
        .about-hero .lead {
            font-size: 1.25rem;
            line-height: 1.8;
            color: var(--gray-300);
            max-width: 800px;
            margin: 0 auto;
        }
        
        /* Secciones */
        .about-section {
            background: rgba(30, 33, 37, 0.6);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            padding: 3rem 2.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .about-section h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #a78bfa;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
        .about-section h2 i {
            font-size: 2.25rem;
        }
        
        .about-section p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--gray-300);
            margin-bottom: 1.25rem;
        }
        
        .about-section strong {
            color: #a78bfa;
            font-weight: 600;
        }
        
        /* Grid de características */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        
        .feature-card {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 1rem;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s;
        }
        
        .feature-card:hover {
            background: rgba(139, 92, 246, 0.1);
            border-color: rgba(139, 92, 246, 0.3);
            transform: translateY(-4px);
        }
        
        .feature-card i {
            font-size: 3rem;
            color: #a78bfa;
            margin-bottom: 1rem;
        }
        
        .feature-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 0.75rem;
        }
        
        .feature-card p {
            font-size: 0.95rem;
            color: var(--gray-400);
            margin: 0;
        }
        
        /* Sección del desarrollador */
        .developer-section {
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.15) 0%, rgba(236, 72, 153, 0.1) 100%);
            border: 1px solid rgba(139, 92, 246, 0.3);
        }
        
        .developer-card {
            display: flex;
            align-items: center;
            gap: 2rem;
            margin-bottom: 2rem;
        }
        
        .developer-avatar {
            flex-shrink: 0;
            width: 140px;
            height: 140px;
            border-radius: 50%;
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            border: 4px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3.5rem;
            font-weight: 900;
            color: #fff;
            letter-spacing: -2px;
        }
        
        .developer-info h3 {
            font-size: 2rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.5rem;
        }
        
        .developer-info .role {
            display: inline-block;
            padding: 0.4rem 1rem;
            background: rgba(139, 92, 246, 0.2);
            border: 1px solid rgba(139, 92, 246, 0.4);
            border-radius: 50px;
            color: #a78bfa;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 1rem;
        }
        
        .social-links {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            margin-top: 1.5rem;
        }
        
        .social-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.25rem;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            color: var(--gray-300);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }
        
        .social-link:hover {
            background: rgba(139, 92, 246, 0.15);
            border-color: #8b5cf6;
            color: #a78bfa;
            transform: translateY(-2px);
        }
        
        .social-link i {
            font-size: 1.1rem;
        }
        
        /* Timeline */
        .timeline {
            position: relative;
            padding-left: 2rem;
            margin-top: 2rem;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #8b5cf6, #ec4899);
            border-radius: 2px;
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 2rem;
        }
        
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.5rem;
            top: 0.5rem;
            width: 12px;
            height: 12px;
            background: #a78bfa;
            border: 3px solid #1a1a2e;
            border-radius: 50%;
        }
        
        .timeline-item h4 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #a78bfa;
            margin-bottom: 0.5rem;
        }
        
        .timeline-item p {
            font-size: 1rem;
            color: var(--gray-300);
            margin: 0;
        }
        
        /* Botón volver */
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
        
        @media (max-width: 768px) {
            .about-hero h1 {
                font-size: 2.5rem;
            }
            
            .about-hero .subtitle {
                font-size: 1.2rem;
            }
            
            .developer-card {
                flex-direction: column;
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="about-container">
        <a href="<?= site_url('catalogo') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i>
            <span>Volver al catálogo</span>
        </a>
        
        <!-- Hero Section -->
        <div class="about-hero">
            <div class="hero-logo">
                <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M60 6L100 30V90L60 114L20 90V30L60 6Z" fill="url(#heroGradient)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                    <text x="60" y="78" font-family="Inter, sans-serif" font-size="48" font-weight="900" fill="white" text-anchor="middle">LB</text>
                    <defs>
                        <linearGradient id="heroGradient" x1="20" y1="6" x2="100" y2="114">
                            <stop offset="0%" stop-color="#374151"/>
                            <stop offset="100%" stop-color="#1f2937"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            
            <h1>LubaBeats Beta</h1>
            <p class="subtitle">Plataforma Gratuita de la Familia LUBA</p>
            <p class="lead">
                Una plataforma innovadora creada para conectar productores y artistas musicales, 
                facilitando la distribución y promoción de beats profesionales de manera completamente gratuita.
            </p>
        </div>
        
        <!-- Nuestra Historia -->
        <div class="about-section">
            <h2>
                <i class="bi bi-book"></i>
                Nuestra Historia
            </h2>
            <p>
                <strong>LubaBeats Beta</strong> nació de un sueño familiar. Todo comenzó cuando mi hermano 
                <strong>Chojin</strong>, un talentoso productor musical, me propuso crear una plataforma 
                donde pudiera vender sus beats de manera profesional. Lo que inició como un proyecto personal 
                evolucionó rápidamente en algo mucho más grande.
            </p>
            <p>
                El nombre <strong>LUBA</strong> representa nuestra empresa familiar, un símbolo del esfuerzo 
                conjunto de todos nosotros en este emprendimiento. Lo que comenzó como "CHOJIN Beats" se transformó 
                en <strong>LubaBeats Beta</strong>, una plataforma diseñada para toda la comunidad musical.
            </p>
            <p>
                Decidimos que esta versión Beta sería <strong>completamente gratuita</strong> para todos los usuarios, 
                tanto productores como artistas. Queremos que cualquier persona con talento pueda compartir su música 
                sin barreras económicas, construyendo una comunidad donde el talento sea lo único que importe.
            </p>
            
            <div class="timeline">
                <div class="timeline-item">
                    <h4>🎵 El Inicio</h4>
                    <p>Chojin propone crear una plataforma para vender sus beats</p>
                </div>
                <div class="timeline-item">
                    <h4>🚀 Evolución</h4>
                    <p>El proyecto crece y se convierte en una plataforma para toda la familia LUBA</p>
                </div>
                <div class="timeline-item">
                    <h4>🎁 Beta Gratuita</h4>
                    <p>Lanzamiento de LubaBeats Beta: acceso gratuito para toda la comunidad</p>
                </div>
                <div class="timeline-item">
                    <h4>🌟 El Futuro</h4>
                    <p>Próxima versión con Next.js, Express.js y Supabase en desarrollo</p>
                </div>
            </div>
        </div>
        
        <!-- Características -->
        <div class="about-section">
            <h2>
                <i class="bi bi-stars"></i>
                ¿Qué Ofrecemos?
            </h2>
            <div class="features-grid">
                <div class="feature-card">
                    <i class="bi bi-cloud-upload"></i>
                    <h3>Sube Tus Beats</h3>
                    <p>Plataforma gratuita para que productores suban y compartan sus creaciones</p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-music-note-list"></i>
                    <h3>Catálogo Profesional</h3>
                    <p>Explora miles de beats organizados por género, BPM y más</p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-play-circle"></i>
                    <h3>Reproductor Integrado</h3>
                    <p>Escucha beats directamente en la plataforma con nuestro reproductor moderno</p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-heart"></i>
                    <h3>Favoritos y Playlists</h3>
                    <p>Crea colecciones personalizadas de tus beats favoritos</p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-person-badge"></i>
                    <h3>Perfiles de Productor</h3>
                    <p>Construye tu presencia como productor con un perfil personalizado</p>
                </div>
                <div class="feature-card">
                    <i class="bi bi-shield-check"></i>
                    <h3>100% Gratuito</h3>
                    <p>Sin costos ocultos, sin comisiones. Completamente gratis para todos</p>
                </div>
            </div>
        </div>
        
        <!-- Tecnología -->
        <div class="about-section">
            <h2>
                <i class="bi bi-code-slash"></i>
                Tecnología
            </h2>
            <p>
                Esta versión Beta está construida con tecnologías modernas y robustas para garantizar 
                la mejor experiencia posible:
            </p>
            <ul style="color: var(--gray-300); font-size: 1.1rem; line-height: 2;">
                <li><strong>CodeIgniter 4</strong> - Framework PHP moderno y eficiente</li>
                <li><strong>MySQL</strong> - Base de datos relacional confiable</li>
                <li><strong>Cloudinary</strong> - Almacenamiento y entrega optimizada de archivos multimedia</li>
                <li><strong>Diseño Responsivo</strong> - Funciona perfectamente en todos los dispositivos</li>
            </ul>
            <p>
                Actualmente estamos desarrollando la próxima generación de LubaBeats con una arquitectura 
                completamente nueva utilizando <strong>Next.js</strong>, <strong>Express.js</strong> y 
                <strong>Supabase</strong>, que ofrecerá características aún más avanzadas.
            </p>
        </div>
        
        <!-- Desarrollador -->
        <div class="about-section developer-section">
            <h2>
                <i class="bi bi-person-circle"></i>
                El Desarrollador
            </h2>
            
            <div class="developer-card">
                <div class="developer-avatar">MU</div>
                <div class="developer-info">
                    <h3>Magdiel UCHIHA</h3>
                    <div class="role">Full Stack Developer</div>
                    <p style="margin: 0;">
                        Desarrollador principal de LubaBeats Beta. Apasionado por crear experiencias 
                        digitales que conecten personas y faciliten el acceso a la música. Este proyecto 
                        representa el amor por mi familia y la música.
                    </p>
                </div>
            </div>
            
            <p>
                ¿Quieres conocer más sobre el desarrollo del proyecto o tienes ideas para colaborar? 
                ¡No dudes en contactarme!
            </p>
            
            <div class="social-links">
                <a href="<?= site_url('magdiel') ?>" class="social-link">
                    <i class="bi bi-person-badge"></i>
                    <span>Ver Perfil Completo</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-github"></i>
                    <span>GitHub</span>
                </a>
                <a href="#" class="social-link">
                    <i class="bi bi-linkedin"></i>
                    <span>LinkedIn</span>
                </a>
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
            </div>
        </div>
        
        <!-- Llamada a la acción -->
        <div class="about-section" style="text-align: center; background: linear-gradient(135deg, rgba(139, 92, 246, 0.2) 0%, rgba(236, 72, 153, 0.15) 100%); border-color: rgba(139, 92, 246, 0.4);">
            <h2 style="justify-content: center;">
                <i class="bi bi-rocket-takeoff"></i>
                ¿Listo para Compartir tu Música?
            </h2>
            <p style="font-size: 1.2rem; margin-bottom: 2rem;">
                Únete a la comunidad de LubaBeats Beta y comienza a compartir tus beats hoy mismo.
            </p>
            <a href="<?= site_url('catalogo') ?>" style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 2.5rem; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; text-decoration: none; font-weight: 700; font-size: 1.1rem; border-radius: 12px; transition: all 0.3s;">
                <i class="bi bi-music-note-beamed"></i>
                <span>Explorar Catálogo</span>
            </a>
        </div>
    </div>
    
    <footer style="text-align: center; padding: 3rem 1rem; color: var(--gray-500);">
        <i class="bi bi-heart-fill" style="color: #ec4899; font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
        <p style="margin: 0;">
            Desarrollado con 💜 por Magdiel UCHIHA
            <br>
            <small>&copy; <?= date('Y') ?> LubaBeats Beta - Familia LUBA</small>
        </p>
    </footer>
</body>
</html>
