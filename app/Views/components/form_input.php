<?php
/**
 * Componente: Input de Formulario
 * Input personalizado con label, validación y mensajes de error
 * 
 * @param string $name - Nombre del input
 * @param string $label - Etiqueta del input
 * @param string $type - Tipo de input (text, email, password, etc.)
 * @param string $value - Valor por defecto
 * @param bool $required - Si es requerido
 * @param string $placeholder - Placeholder
 * @param string $icon - Icono de Bootstrap Icons (opcional)
 * @param string $error - Mensaje de error (opcional)
 */

$type = $type ?? 'text';
$value = $value ?? '';
$required = $required ?? false;
$placeholder = $placeholder ?? '';
$icon = $icon ?? null;
$error = $error ?? null;
?>

<div class="form-group">
    <label for="<?= $name ?>" class="form-label">
        <?= $label ?>
        <?php if ($required): ?>
            <span style="color: var(--danger);">*</span>
        <?php endif; ?>
    </label>
    
    <?php if ($icon): ?>
    <div class="input-group">
        <i class="bi bi-<?= $icon ?> input-icon"></i>
        <input type="<?= $type ?>" 
               id="<?= $name ?>" 
               name="<?= $name ?>" 
               class="form-control <?= $error ? 'is-invalid' : '' ?>" 
               value="<?= esc($value) ?>"
               placeholder="<?= esc($placeholder) ?>"
               <?= $required ? 'required' : '' ?>>
    </div>
    <?php else: ?>
    <input type="<?= $type ?>" 
           id="<?= $name ?>" 
           name="<?= $name ?>" 
           class="form-control <?= $error ? 'is-invalid' : '' ?>" 
           value="<?= esc($value) ?>"
           placeholder="<?= esc($placeholder) ?>"
           <?= $required ? 'required' : '' ?>>
    <?php endif; ?>
    
    <?php if ($error): ?>
    <span class="error-message"><?= $error ?></span>
    <?php endif; ?>
</div>

<style>
.form-control.is-invalid {
    border-color: var(--danger);
}

.error-message {
    display: block;
    color: var(--danger);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}
</style>
