<!-- Modal Agregar a Playlist -->
<div id="addToPlaylistModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>
                <i class="bi bi-plus-circle"></i>
                Agregar a Playlist
            </h2>
            <button class="modal-close" onclick="closeAddToPlaylistModal()">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="modal-body" id="playlistsContainer">
            <p class="loading-text">
                <i class="bi bi-hourglass-split"></i>
                Cargando playlists...
            </p>
        </div>
    </div>
</div>

<script>
let currentBeatId = null;

function openAddToPlaylistModal(beatId, beatTitle) {
    currentBeatId = beatId;
    const modal = document.getElementById('addToPlaylistModal');
    const container = document.getElementById('playlistsContainer');
    
    modal.classList.add('active');
    
    // Cargar playlists del usuario
    fetch('<?= base_url('/api/playlists/usuario') ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.playlists.length > 0) {
            container.innerHTML = `
                <p class="modal-subtitle">Selecciona una playlist para "<strong>${beatTitle}</strong>"</p>
                <div class="playlists-list">
                    ${data.playlists.map(playlist => `
                        <div class="playlist-item" onclick="addBeatToPlaylist(${playlist.id}, '${playlist.nombre}')">
                            <div class="playlist-item-icon">
                                <i class="bi bi-music-note-list"></i>
                            </div>
                            <div class="playlist-item-info">
                                <h3>${playlist.nombre}</h3>
                                <p>
                                    <i class="bi bi-music-note"></i> ${playlist.total_beats || 0} pistas
                                    <i class="bi bi-${playlist.es_publica ? 'globe' : 'lock'}"></i>
                                    ${playlist.es_publica ? 'Pública' : 'Privada'}
                                </p>
                            </div>
                            <div class="playlist-item-action">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                        </div>
                    `).join('')}
                </div>
                <button class="btn-secondary" onclick="showCreatePlaylistForm('${beatTitle}')" style="width: 100%; margin-top: 1rem;">
                    <i class="bi bi-plus"></i>
                    Crear Nueva Playlist
                </button>
            `;
        } else {
            container.innerHTML = `
                <div class="empty-playlist-state">
                    <i class="bi bi-music-note-list"></i>
                    <p>No tienes playlists aún</p>
                    <button class="btn-primary" onclick="showCreatePlaylistForm('${beatTitle}')">
                        <i class="bi bi-plus-circle"></i>
                        Crear Mi Primera Playlist
                    </button>
                </div>
            `;
        }
    })
    .catch(error => {
        container.innerHTML = `
            <div class="error-state">
                <i class="bi bi-exclamation-circle"></i>
                <p>Error al cargar playlists</p>
            </div>
        `;
    });
}

function closeAddToPlaylistModal() {
    document.getElementById('addToPlaylistModal').classList.remove('active');
    currentBeatId = null;
}

function addBeatToPlaylist(playlistId, playlistName) {
    fetch('<?= base_url('/usuario/playlist/agregar-beat') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            id_playlist: playlistId,
            id_beat: currentBeatId,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Mostrar mensaje de éxito
            showToast(`Beat agregado a "${playlistName}"`, 'success');
            closeAddToPlaylistModal();
        } else {
            showToast(data.message || 'Error al agregar beat', 'error');
        }
    })
    .catch(error => {
        showToast('Error al procesar la solicitud', 'error');
    });
}

function showCreatePlaylistForm(beatTitle) {
    const container = document.getElementById('playlistsContainer');
    container.innerHTML = `
        <form onsubmit="createPlaylistAndAdd(event, '${beatTitle}')" class="create-playlist-form">
            <div class="form-group">
                <label for="newPlaylistName" class="form-label">Nombre de la Playlist</label>
                <input type="text" 
                       id="newPlaylistName" 
                       class="form-input" 
                       placeholder="Ej: Mis Favoritos 2024"
                       required
                       maxlength="100">
            </div>
            
            <div class="form-group">
                <label class="form-label">Visibilidad</label>
                <div class="radio-group">
                    <label class="radio-label">
                        <input type="radio" name="es_publica" value="1" checked>
                        <span class="radio-custom"></span>
                        <span class="radio-text">
                            <i class="bi bi-globe"></i>
                            Pública
                        </span>
                    </label>
                    <label class="radio-label">
                        <input type="radio" name="es_publica" value="0">
                        <span class="radio-custom"></span>
                        <span class="radio-text">
                            <i class="bi bi-lock"></i>
                            Privada
                        </span>
                    </label>
                </div>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-secondary" onclick="openAddToPlaylistModal(${currentBeatId}, '${beatTitle}')">
                    <i class="bi bi-arrow-left"></i>
                    Volver
                </button>
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle"></i>
                    Crear y Agregar
                </button>
            </div>
        </form>
    `;
}

function createPlaylistAndAdd(event, beatTitle) {
    event.preventDefault();
    
    const nombre = document.getElementById('newPlaylistName').value;
    const esPublica = document.querySelector('input[name="es_publica"]:checked').value;
    
    fetch('<?= base_url('/usuario/playlist/crear') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: new URLSearchParams({
            nombre: nombre,
            es_publica: esPublica,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success && data.playlist_id) {
            // Agregar beat a la nueva playlist
            addBeatToPlaylist(data.playlist_id, nombre);
        } else {
            showToast('Error al crear playlist', 'error');
        }
    })
    .catch(error => {
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

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    const modal = document.getElementById('addToPlaylistModal');
    if (event.target === modal) {
        closeAddToPlaylistModal();
    }
}
</script>

<style>
/* Playlist Items en Modal */
.modal-subtitle {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin-bottom: 1rem;
}

.playlists-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    max-height: 400px;
    overflow-y: auto;
}

.playlist-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.playlist-item:hover {
    background: rgba(255, 255, 255, 0.06);
    border-color: var(--primary);
    transform: translateX(4px);
}

.playlist-item-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #1ed760 0%, #1db954 100%);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: rgba(0, 0, 0, 0.7);
    flex-shrink: 0;
}

.playlist-item-info {
    flex: 1;
    min-width: 0;
}

.playlist-item-info h3 {
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 0.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.playlist-item-info p {
    font-size: 0.75rem;
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.playlist-item-action {
    font-size: 1.5rem;
    color: var(--primary);
    flex-shrink: 0;
}

.empty-playlist-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-playlist-state i {
    font-size: 3rem;
    color: var(--text-secondary);
    opacity: 0.5;
    margin-bottom: 1rem;
}

.empty-playlist-state p {
    font-size: 1rem;
    color: var(--text-secondary);
    margin-bottom: 1.5rem;
}

.loading-text {
    text-align: center;
    padding: 2rem;
    color: var(--text-secondary);
}

.error-state {
    text-align: center;
    padding: 2rem;
}

.error-state i {
    font-size: 2rem;
    color: #e13838;
    margin-bottom: 0.5rem;
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

/* Create Playlist Form */
.create-playlist-form {
    padding: 0;
}
</style>
