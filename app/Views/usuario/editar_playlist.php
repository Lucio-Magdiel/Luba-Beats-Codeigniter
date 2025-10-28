<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Playlist - LubaBeats Beta</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/reset.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/variables.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/base/typography.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/buttons.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/forms.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/components/cards.css?v=' . time()) ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/pages/editar-playlist.css?v=' . time()) ?>">
    <!-- SortableJS para Drag & Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
</head>
<body>
    <header class="header">
        <div class="header-container">
            <div class="header-logo">
                <a href="<?= base_url('/') ?>">
                    <i class="bi bi-music-note-beamed"></i>
                    <span><span style="color: #1ed760;">LUBA</span><span style="color: #fff;">Beats</span></span>
                </a>
            </div>
            <nav class="header-nav">
                <a href="<?= base_url('/catalogo') ?>">
                    <i class="bi bi-grid"></i>
                    <span>Catálogo</span>
                </a>
                <a href="<?= base_url('/usuario/playlists') ?>" class="active">
                    <i class="bi bi-music-note-list"></i>
                    <span>Mis Playlists</span>
                </a>
                <a href="<?= base_url('/usuario/mi-perfil') ?>">
                    <i class="bi bi-person-circle"></i>
                    <span>Mi Perfil</span>
                </a>
            </nav>
            <div class="header-actions">
                <a href="<?= base_url('/auth/logout') ?>" class="btn-secondary">
                    <i class="bi bi-box-arrow-right"></i>
                    Cerrar Sesión
                </a>
            </div>
        </div>
    </header>

    <main class="editor-container">
        <div class="editor-header">
            <a href="<?= base_url('/usuario/playlists') ?>" class="back-link">
                <i class="bi bi-arrow-left"></i>
                Volver a Playlists
            </a>
            <h1 class="page-title">
                <i class="bi bi-pencil-square"></i>
                Editar Playlist
            </h1>
        </div>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('mensaje') ?>
            </div>
        <?php endif; ?>

        <div class="editor-content">
            <div class="editor-sidebar">
                <form action="<?= base_url('/usuario/playlist/actualizar/' . $playlist['id']) ?>" method="POST" class="playlist-form">
                    <?= csrf_field() ?>
                    
                    <div class="form-section">
                        <h2 class="section-title">Información de la Playlist</h2>
                        
                        <div class="form-group">
                            <label for="nombre" class="form-label">Nombre *</label>
                            <input type="text" 
                                   id="nombre" 
                                   name="nombre" 
                                   class="form-input" 
                                   value="<?= esc($playlist['nombre']) ?>"
                                   required
                                   maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea id="descripcion" 
                                      name="descripcion" 
                                      class="form-textarea" 
                                      rows="4" 
                                      maxlength="500"><?= esc($playlist['descripcion'] ?? '') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Visibilidad</label>
                            <div class="radio-group">
                                <label class="radio-label">
                                    <input type="radio" 
                                           name="es_publica" 
                                           value="1" 
                                           <?= $playlist['es_publica'] ? 'checked' : '' ?>>
                                    <span class="radio-custom"></span>
                                    <span class="radio-text">
                                        <i class="bi bi-globe"></i>
                                        Pública
                                    </span>
                                </label>
                                <label class="radio-label">
                                    <input type="radio" 
                                           name="es_publica" 
                                           value="0"
                                           <?= !$playlist['es_publica'] ? 'checked' : '' ?>>
                                    <span class="radio-custom"></span>
                                    <span class="radio-text">
                                        <i class="bi bi-lock"></i>
                                        Privada
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="<?= base_url('/usuario/playlists') ?>" class="btn-secondary">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="bi bi-check-circle"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>

            <div class="editor-main">
                <div class="tracks-section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="bi bi-music-note"></i>
                            Pistas (<?= count($playlist['beats'] ?? []) ?>)
                        </h2>
                        <button class="btn-primary" onclick="openAddModal()">
                            <i class="bi bi-plus"></i>
                            Agregar Pista
                        </button>
                    </div>

                    <?php if (empty($playlist['beats'])): ?>
                        <div class="empty-state">
                            <i class="bi bi-music-note"></i>
                            <h3>No hay pistas en esta playlist</h3>
                            <p>Agrega beats o música desde el catálogo</p>
                            <button class="btn-primary" onclick="openAddModal()">
                                <i class="bi bi-plus-circle"></i>
                                Agregar Primera Pista
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="tracks-list" id="tracksList">
                            <?php foreach ($playlist['beats'] as $beat): ?>
                                <div class="track-item" data-beat-id="<?= $beat['id'] ?>">
                                    <div class="track-handle">
                                        <i class="bi bi-grip-vertical"></i>
                                    </div>
                                    
                                    <div class="track-cover">
                                        <?php if (!empty($beat['imagen_visual'])): ?>
                                            <img src="<?= base_url($beat['imagen_visual']) ?>" alt="<?= esc($beat['titulo']) ?>">
                                        <?php else: ?>
                                            <div class="track-cover-default">
                                                <i class="bi bi-music-note"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="track-info">
                                        <h3 class="track-title"><?= esc($beat['titulo']) ?></h3>
                                        <p class="track-artist">
                                            <?php
                                            $tipo_label = $beat['tipo'] === 'beat' ? 'Beat' : 'Música';
                                            echo esc($beat['nombre_usuario'] ?? 'Desconocido') . ' • ' . $tipo_label;
                                            ?>
                                        </p>
                                    </div>
                                    
                                    <div class="track-actions">
                                        <button class="btn-icon btn-danger" 
                                                onclick="removeTrack(<?= $beat['id'] ?>, '<?= esc($beat['titulo']) ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <script>
        function openAddModal() {
            alert('Funcionalidad para agregar pistas desde el catálogo (próximamente)');
            // TODO: Implementar modal con catálogo de beats
        }

        function removeTrack(beatId, beatTitle) {
            if (!confirm(`¿Eliminar "${beatTitle}" de la playlist?`)) {
                return;
            }

            fetch('<?= base_url('/usuario/playlist/quitar-beat') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: new URLSearchParams({
                    id_playlist: <?= $playlist['id'] ?>,
                    id_beat: beatId,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message || 'Error al eliminar la pista');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        }

        // Drag & Drop con SortableJS
        document.addEventListener('DOMContentLoaded', function() {
            const tracksList = document.getElementById('tracksList');
            
            if (tracksList && tracksList.children.length > 0) {
                const sortable = new Sortable(tracksList, {
                    animation: 150,
                    handle: '.track-handle',
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        // Obtener nuevo orden
                        const items = tracksList.querySelectorAll('.track-item');
                        const newOrder = Array.from(items).map(item => item.getAttribute('data-beat-id'));
                        
                        // Guardar en servidor
                        saveNewOrder(newOrder);
                    }
                });
            }
        });

        function saveNewOrder(beatsOrder) {
            fetch('<?= base_url('/usuario/playlist/reordenar') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id_playlist: <?= $playlist['id'] ?>,
                    beats_orden: beatsOrder,
                    <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Orden actualizado', 'success');
                } else {
                    showToast('Error al guardar el orden', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error al procesar la solicitud', 'error');
            });
        }

        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                ${message}
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.classList.add('show');
            }, 10);
            
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>

    <style>
        /* Estilos para Drag & Drop */
        .sortable-ghost {
            opacity: 0.4;
            background: rgba(30, 215, 96, 0.1);
        }

        .sortable-chosen {
            cursor: grabbing;
        }

        .sortable-drag {
            opacity: 1;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }

        .track-handle {
            cursor: grab;
        }

        .track-handle:active {
            cursor: grabbing;
        }

        /* Toast Notifications */
        .toast {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.4);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 10000;
        }

        .toast.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-success {
            background: rgba(30, 215, 96, 0.15);
            color: #1ed760;
            border: 1px solid rgba(30, 215, 96, 0.3);
        }

        .toast-error {
            background: rgba(225, 56, 56, 0.15);
            color: #e13838;
            border: 1px solid rgba(225, 56, 56, 0.3);
        }

        .toast i {
            font-size: 1.25rem;
        }
    </style>
</body>
</html>
