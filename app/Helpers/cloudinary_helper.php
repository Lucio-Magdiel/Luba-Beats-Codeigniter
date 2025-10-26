<?php

/**
 * Helper para gestionar URLs de Cloudinary y archivos locales
 */

if (!function_exists('asset_url')) {
    /**
     * Retorna la URL correcta para un asset (local o Cloudinary)
     * 
     * @param string|null $path
     * @return string
     */
    function asset_url($path)
    {
        if (empty($path)) {
            return '';
        }
        
        // Si la URL ya es completa (http:// o https://), retornarla tal cual
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }
        
        // Si es una ruta local, usar base_url()
        return base_url($path);
    }
}
