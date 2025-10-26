<?php
/**
 * Componente: Alert
 * Muestra mensajes de alerta estilizados
 * 
 * @param string $tipo - Tipo de alerta (success, danger, warning, info)
 * @param string $mensaje - Mensaje a mostrar
 * @param bool $dismissible - Si se puede cerrar
 */

$tipo = $tipo ?? 'info';
$dismissible = $dismissible ?? true;
?>

<div class="alert alert-<?= $tipo ?> fade-in" role="alert">
    <i class="bi bi-<?= getIconoAlerta($tipo) ?>"></i>
    <span><?= $mensaje ?></span>
    
    <?php if ($dismissible): ?>
    <button onclick="this.parentElement.remove()" 
            class="btn btn-ghost btn-sm" 
            style="margin-left: auto;">
        <i class="bi bi-x"></i>
    </button>
    <?php endif; ?>
</div>

<?php
function getIconoAlerta($tipo) {
    $iconos = [
        'success' => 'check-circle-fill',
        'danger' => 'exclamation-circle-fill',
        'warning' => 'exclamation-triangle-fill',
        'info' => 'info-circle-fill'
    ];
    return $iconos[$tipo] ?? 'info-circle-fill';
}
?>
