<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class SuperAdminFilter implements FilterInterface
{
    /**
     * Verifica que el usuario esté autenticado Y sea Super Admin
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return RequestInterface|ResponseInterface|string|void
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        
        // Verificar si está logueado
        if (!$session->get('logueado')) {
            $session->set('redirect_url', current_url());
            $session->setFlashdata('error', 'Debes iniciar sesión para acceder a esta página.');
            return redirect()->to('/auth/login');
        }
        
        // Verificar si es super admin
        if ($session->get('tipo') !== 'super_admin') {
            $session->setFlashdata('error', 'No tienes permisos de administrador para acceder a esta sección.');
            return redirect()->to('/catalogo');
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
