<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/components/modal.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/pages/playlists.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<main class="playlists-container">
        <div class="playlists-header">
            <div class="header-content">
                <h1 class="page-title">
                    <i class="bi bi-music-note-list"></i>
                    Mis Playlists
                </h1>
                <p class="page-description">Organiza tu música favorita en colecciones personalizadas</p>
            </div>
            <button class="btn-primary" onclick="openCreateModal()">
                <i class="bi bi-plus-circle"></i>
                Nueva Playlist
            </button>
        </div>

        <?php if (session()->getFlashdata('mensaje')): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle"></i>
                <?= session()->getFlashdata('mensaje') ?>
            </div>
        <?php endif; ?>

        <?php if (empty($playlists)): ?>
            <div class="empty-state">
                <i class="bi bi-music-note-list"></i>
                <h2>No tienes playlists aún</h2>
                <p>Crea tu primera playlist para organizar tus beats y música favorita</p>
                <button class="btn-primary" onclick="openCreateModal()">
                    <i class="bi bi-plus-circle"></i>
                    Crear Mi Primera Playlist
                </button>
            </div>
        <?php else: ?>
            <div class="playlists-grid">
                <?php foreach ($playlists as $playlist): ?>
                    <div class="playlist-card">
                        <div class="playlist-cover">
                            <?php if (!empty($playlist['imagen_portada'])): ?>
                                <img src="<?= base_url($playlist['imagen_portada']) ?>" alt="<?= esc($playlist['nombre']) ?>">
                            <?php else: ?>
                                <div class="playlist-cover-default">
                                    <i class="bi bi-music-note-list"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="playlist-overlay">
                                <a href="<?= base_url('/usuario/playlist/editar/' . $playlist['id']) ?>" 
                                   class="btn-icon" 
                                   title="Editar">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn-icon btn-danger" 
                                        onclick="confirmDelete(<?= $playlist['id'] ?>, '<?= esc($playlist['nombre']) ?>')"
                                        title="Eliminar">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="playlist-info">
                            <h3 class="playlist-name">
                                <a href="<?= base_url('/usuario/playlist/editar/' . $playlist['id']) ?>">
                                    <?= esc($playlist['nombre']) ?>
                                </a>
                            </h3>
                            
                            <div class="playlist-meta">
                                <span class="playlist-tracks">
                                    <i class="bi bi-music-note"></i>
                                    <?= $playlist['total_beats'] ?? 0 ?> pistas
                                </span>
                                <span class="playlist-visibility">
                                    <i class="bi bi-<?= $playlist['es_publica'] ? 'globe' : 'lock' ?>"></i>
                                    <?= $playlist['es_publica'] ? 'Pública' : 'Privada' ?>
                                </span>
                            </div>
                            
                            <?php if (!empty($playlist['descripcion'])): ?>
                                <p class="playlist-description"><?= esc($playlist['descripcion']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>

    <!-- Modal Crear Playlist -->
    <div id="createModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>
                    <i class="bi bi-plus-circle"></i>
                    Nueva Playlist
                </h2>
                <button class="modal-close" onclick="closeCreateModal()">
                    <i class="bi bi-x"></i>
                </button>
            </div>
            
            <form action="<?= base_url('/usuario/playlist/crear') ?>" method="POST" class="modal-form">
                <?= csrf_field() ?>
                
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre de la Playlist *</label>
                    <input type="text" 
                           id="nombre" 
                           name="nombre" 
                           class="form-input" 
                           placeholder="Ej: Mis Favoritos 2024"
                           required
                           maxlength="100">
                </div>

                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea id="descripcion" 
                              name="descripcion" 
                              class="form-textarea" 
                              rows="3" 
                              maxlength="500"
                              placeholder="Describe tu playlist..."></textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Visibilidad</label>
                    <div class="radio-group">
                        <label class="radio-label">
                            <input type="radio" name="es_publica" value="1" checked>
                            <span class="radio-custom"></span>
                            <span class="radio-text">
                                <i class="bi bi-globe"></i>
                                Pública - Visible para todos
                            </span>
                        </label>
                        <label class="radio-label">
                            <input type="radio" name="es_publica" value="0">
                            <span class="radio-custom"></span>
                            <span class="radio-text">
                                <i class="bi bi-lock"></i>
                                Privada - Solo yo puedo verla
                            </span>
                        </label>
                    </div>
                </div>

                <div class="modal-actions">
                    <button type="button" class="btn-secondary" onclick="closeCreateModal()">
                        Cancelar
                    </button>
                    <button type="submit" class="btn-primary">
                        <i class="bi bi-check-circle"></i>
                        Crear Playlist
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Confirmar Eliminación -->
    <div id="deleteModal" class="modal">
        <div class="modal-content modal-small">
            <div class="modal-header">
                <h2>
                    <i class="bi bi-exclamation-triangle"></i>
                    Confirmar Eliminación
                </h2>
            </div>
            
            <div class="modal-body">
                <p>¿Estás seguro de eliminar la playlist <strong id="deletePlaylistName"></strong>?</p>
                <p class="text-muted">Esta acción no se puede deshacer.</p>
            </div>

            <form id="deleteForm" method="POST" class="modal-actions">
                <?= csrf_field() ?>
                <button type="button" class="btn-secondary" onclick="closeDeleteModal()">
                    Cancelar
                </button>
                <button type="submit" class="btn-danger">
                    <i class="bi bi-trash"></i>
                    Eliminar
                </button>
            </form>
        </div>
    </div>
</main>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
    <script>
        function openCreateModal() {
            document.getElementById('createModal').classList.add('active');
        }

        function closeCreateModal() {
            document.getElementById('createModal').classList.remove('active');
        }

        function confirmDelete(id, nombre) {
            document.getElementById('deletePlaylistName').textContent = nombre;
            document.getElementById('deleteForm').action = '<?= base_url('/usuario/playlist/eliminar/') ?>' + id;
            document.getElementById('deleteModal').classList.add('active');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('active');
        }

        // Cerrar modal al hacer clic fuera
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.classList.remove('active');
            }
        }
    </script>
<?= $this->endSection() ?>
