<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Verifica que el usuario esté autenticado
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            // Guardar la URL a la que intentaba acceder
            $session->set('redirect_url', current_url());
            
            // Mensaje flash informativo
            $session->setFlashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            
            return redirect()->to('/auth/login');
        }
    }

    /**
     * No se necesita procesamiento después de la ejecución del controlador
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return ResponseInterface|void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se requiere procesamiento posterior
    }
}
