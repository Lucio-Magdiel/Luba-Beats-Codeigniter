<?php

/**
 * Helper para manejar URLs de archivos que pueden ser locales o de Cloudinary
 */

if (!function_exists('asset_url')) {
    /**
     * Obtener URL completa de un asset (imagen, audio, video)
     * Detecta automáticamente si es URL de Cloudinary o ruta local
     * 
     * @param string|null $path Ruta del archivo
     * @return string URL completa
     */
    function asset_url(?string $path): string
    {
        if (empty($path)) {
            return '';
        }
        
        // Si ya es una URL completa (http:// o https://), devolverla tal cual
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }
        
        // Si es ruta local, agregar base_url()
        return base_url($path);
    }
}
