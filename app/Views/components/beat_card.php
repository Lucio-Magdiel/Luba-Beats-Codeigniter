<?php
/**
 * Componente: Card de Beat
 * Muestra una tarjeta con la información de un beat
 * 
 * @param array $beat - Datos del beat
 * @param string $tipo - Tipo de vista ('grid' o 'list')
 */

$tipo = $tipo ?? 'grid';
?>

<div class="beat-card <?= $tipo === 'grid' ? 'card' : 'beat-list-item' ?>">
    <!-- Preview Image -->
    <div class="beat-preview">
        <?php if (!empty($beat['archivo_preview'])): ?>
            <img src="<?= base_url('uploads/previews/' . $beat['archivo_preview']) ?>" 
                 alt="<?= esc($beat['titulo']) ?>" 
                 class="beat-image">
        <?php else: ?>
            <div class="beat-placeholder">
                <i class="bi bi-music-note-beamed"></i>
            </div>
        <?php endif; ?>
        
        <!-- Play Button Overlay -->
        <button class="play-button" 
                id="play-<?= $beat['id'] ?>"
                onclick="reproductor.reproducir('<?= base_url('uploads/previews/' . $beat['archivo_preview']) ?>', 'play-<?= $beat['id'] ?>')">
            <i class="bi bi-play-fill"></i>
        </button>
    </div>
    
    <!-- Beat Info -->
    <div class="beat-info">
        <div class="flex justify-between items-center mb-2">
            <h4 class="beat-title"><?= esc($beat['titulo']) ?></h4>
            <?php if ($beat['precio'] > 0): ?>
                <span class="beat-price">$<?= number_format($beat['precio'], 2) ?></span>
            <?php else: ?>
                <span class="badge badge-success">GRATIS</span>
            <?php endif; ?>
        </div>
        
        <div class="beat-meta">
            <span class="beat-genre">
                <i class="bi bi-disc"></i>
                <?= esc($beat['genero']) ?>
            </span>
            <span class="beat-bpm">
                <i class="bi bi-speedometer"></i>
                <?= esc($beat['bpm']) ?> BPM
            </span>
            <span class="beat-mood">
                <i class="bi bi-heart"></i>
                <?= esc($beat['mood']) ?>
            </span>
        </div>
        
        <?php if (!empty($beat['productor'])): ?>
        <div class="beat-producer">
            <i class="bi bi-person"></i>
            <a href="<?= site_url('productor/' . $beat['id_productor']) ?>">
                <?= esc($beat['productor']) ?>
            </a>
        </div>
        <?php endif; ?>
        
        <!-- Actions -->
        <div class="beat-actions">
            <button class="btn btn-primary btn-sm" onclick="window.location='<?= site_url('beat/' . $beat['id']) ?>'">
                <i class="bi bi-eye"></i> Ver Detalles
            </button>
            
            <?php if (session()->has('usuario_id')): ?>
                <button class="btn btn-outline btn-sm btn-icon" 
                        onclick="toggleFavorito(<?= $beat['id'] ?>)">
                    <i class="bi bi-heart"></i>
                </button>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
.beat-card {
    overflow: hidden;
}

.beat-preview {
    position: relative;
    width: 100%;
    padding-bottom: 100%; /* Aspect ratio 1:1 */
    overflow: hidden;
    border-radius: var(--radius);
    margin-bottom: 1rem;
}

.beat-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.beat-card:hover .beat-image {
    transform: scale(1.05);
}

.beat-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    font-size: 3rem;
    color: white;
}

.play-button {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: rgba(139, 92, 246, 0.9);
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
}

.beat-preview:hover .play-button {
    opacity: 1;
}

.play-button:hover {
    transform: translate(-50%, -50%) scale(1.1);
    background: var(--primary);
}

.beat-title {
    font-size: 1.125rem;
    font-weight: 600;
    margin: 0;
    color: var(--dark-text);
}

.beat-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--primary-light);
}

.beat-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
    margin-bottom: 0.75rem;
    font-size: 0.875rem;
    color: var(--dark-text-secondary);
}

.beat-meta span {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.beat-producer {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.875rem;
    color: var(--gray-400);
}

.beat-producer a {
    color: var(--primary-light);
    text-decoration: none;
    transition: color 0.3s ease;
}

.beat-producer a:hover {
    color: var(--primary);
}

.beat-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.beat-list-item {
    display: flex;
    gap: 1rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius);
    transition: all 0.3s ease;
}

.beat-list-item:hover {
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(139, 92, 246, 0.3);
}

.beat-list-item .beat-preview {
    width: 120px;
    padding-bottom: 120px;
    flex-shrink: 0;
}

.beat-list-item .beat-info {
    flex: 1;
}
</style>
