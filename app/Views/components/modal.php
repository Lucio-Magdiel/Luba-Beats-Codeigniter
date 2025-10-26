<?php
/**
 * Componente: Modal
 * Modal reutilizable con backdrop
 * 
 * @param string $id - ID único del modal
 * @param string $title - Título del modal
 * @param string $content - Contenido del modal
 * @param string $size - Tamaño (sm, md, lg, xl)
 * @param bool $showFooter - Mostrar footer con botones
 * @param string $confirmText - Texto del botón de confirmación
 * @param string $confirmAction - Acción al confirmar
 */

$size = $size ?? 'md';
$showFooter = $showFooter ?? true;
$confirmText = $confirmText ?? 'Aceptar';
$confirmAction = $confirmAction ?? '';
?>

<div class="modal-overlay" id="<?= $id ?>" style="display: none;">
    <div class="modal-container modal-<?= $size ?>">
        <div class="modal-header">
            <h3 class="modal-title"><?= $title ?></h3>
            <button class="btn btn-ghost btn-icon" onclick="cerrarModal('<?= $id ?>')">
                <i class="bi bi-x"></i>
            </button>
        </div>
        
        <div class="modal-body">
            <?= $content ?>
        </div>
        
        <?php if ($showFooter): ?>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="cerrarModal('<?= $id ?>')">
                Cancelar
            </button>
            <button class="btn btn-primary" onclick="<?= $confirmAction ?>">
                <?= $confirmText ?>
            </button>
        </div>
        <?php endif; ?>
    </div>
</div>

<style>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.3s ease-out;
}

.modal-container {
    background: var(--dark-bg-secondary);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-2xl);
    max-height: 90vh;
    overflow-y: auto;
    animation: slideIn 0.3s ease-out;
}

.modal-sm { width: 90%; max-width: 400px; }
.modal-md { width: 90%; max-width: 600px; }
.modal-lg { width: 90%; max-width: 800px; }
.modal-xl { width: 90%; max-width: 1200px; }

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.modal-title {
    margin: 0;
    font-size: 1.5rem;
    font-weight: 600;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

@keyframes slideIn {
    from {
        transform: translateY(-50px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>

<script>
function abrirModal(id) {
    document.getElementById(id).style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function cerrarModal(id) {
    document.getElementById(id).style.display = 'none';
    document.body.style.overflow = 'auto';
}

// Cerrar al hacer clic fuera
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('modal-overlay')) {
        cerrarModal(e.target.id);
    }
});

// Cerrar con tecla ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modals = document.querySelectorAll('.modal-overlay');
        modals.forEach(modal => {
            if (modal.style.display !== 'none') {
                cerrarModal(modal.id);
            }
        });
    }
});
</script>
