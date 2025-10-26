<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class SecureHeaders extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Security Headers Configuration
     * --------------------------------------------------------------------------
     * 
     * Define security headers to protect against common web vulnerabilities
     */

    /**
     * X-Frame-Options
     * Protege contra ataques de clickjacking
     * 
     * Options: 'DENY', 'SAMEORIGIN', 'ALLOW-FROM uri'
     */
    public string $xFrameOptions = 'SAMEORIGIN';

    /**
     * X-Content-Type-Options
     * Previene MIME type sniffing
     */
    public string $xContentTypeOptions = 'nosniff';

    /**
     * X-XSS-Protection
     * Habilita la protección XSS del navegador
     */
    public string $xXSSProtection = '1; mode=block';

    /**
     * Referrer-Policy
     * Controla cuánta información de referencia se envía
     */
    public string $referrerPolicy = 'strict-origin-when-cross-origin';

    /**
     * Strict-Transport-Security (HSTS)
     * Fuerza conexiones HTTPS
     * Solo habilitar si tu sitio usa HTTPS
     */
    public ?string $strictTransportSecurity = null; // 'max-age=31536000; includeSubDomains'

    /**
     * Content-Security-Policy
     * Política de seguridad de contenido
     * Personaliza según tus necesidades
     */
    public ?string $contentSecurityPolicy = null;
    
    /**
     * Permissions-Policy
     * Controla las características del navegador que pueden ser usadas
     */
    public string $permissionsPolicy = 'geolocation=(), microphone=(), camera=()';
}
