<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\BeatModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $usuarioModel;
    protected $beatModel;

    public function __construct()
    {
        helper(['form', 'url', 'session']);
        $this->usuarioModel = new UsuarioModel();
        $this->beatModel = new BeatModel();
    }

    /**
     * Panel principal de administración
     */
    public function dashboard()
    {
        $data = [
            'totalUsuarios' => $this->usuarioModel->countAll(),
            'totalBeats' => $this->beatModel->countAll(),
            'totalProductores' => $this->usuarioModel->where('tipo', 'productor')->countAllResults(),
            'totalArtistas' => $this->usuarioModel->where('tipo', 'artista')->countAllResults(),
            'totalCompradores' => $this->usuarioModel->where('tipo', 'comprador')->countAllResults(),
            'totalAdmins' => $this->usuarioModel->where('tipo', 'super_admin')->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Listar todos los usuarios
     */
    public function usuarios()
    {
        $busqueda = $this->request->getGet('buscar');
        
        if ($busqueda) {
            $usuarios = $this->usuarioModel
                ->like('nombre_usuario', $busqueda)
                ->orLike('correo', $busqueda)
                ->findAll();
        } else {
            $usuarios = $this->usuarioModel->findAll();
        }

        return view('admin/usuarios', ['usuarios' => $usuarios]);
    }

    /**
     * Editar usuario
     */
    public function editarUsuario($id)
    {
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            session()->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('/admin/usuarios');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'nombre_usuario' => [
                    'label' => 'Nombre de usuario',
                    'rules' => 'required|min_length[3]|max_length[50]',
                ],
                'correo' => [
                    'label' => 'Correo',
                    'rules' => 'required|valid_email',
                ],
                'tipo' => [
                    'label' => 'Tipo de usuario',
                    'rules' => 'required|in_list[super_admin,productor,artista,comprador]',
                ],
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $data = [
                    'nombre_usuario' => $this->request->getPost('nombre_usuario'),
                    'correo' => $this->request->getPost('correo'),
                    'tipo' => $this->request->getPost('tipo'),
                ];

                // Solo actualizar contraseña si se proporciona
                $nuevaPassword = $this->request->getPost('nueva_contrasena');
                if (!empty($nuevaPassword)) {
                    $data['contrasena'] = password_hash($nuevaPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                }

                $this->usuarioModel->update($id, $data);
                session()->setFlashdata('mensaje', 'Usuario actualizado correctamente.');
                return redirect()->to('/admin/usuarios');
            }

            return view('admin/editar_usuario', [
                'usuario' => $usuario,
                'validation' => $validation
            ]);
        }

        return view('admin/editar_usuario', ['usuario' => $usuario]);
    }

    /**
     * Eliminar usuario
     */
    public function eliminarUsuario($id)
    {
        $session = session();
        $usuario = $this->usuarioModel->find($id);

        if (!$usuario) {
            $session->setFlashdata('error', 'Usuario no encontrado.');
            return redirect()->to('/admin/usuarios');
        }

        // No permitir que el admin se elimine a sí mismo
        if ($id == $session->get('id')) {
            $session->setFlashdata('error', 'No puedes eliminar tu propia cuenta.');
            return redirect()->to('/admin/usuarios');
        }

        // No permitir eliminar otros super admins
        if ($usuario['tipo'] === 'super_admin') {
            $session->setFlashdata('error', 'No puedes eliminar cuentas de Super Admin.');
            return redirect()->to('/admin/usuarios');
        }

        $this->usuarioModel->delete($id);
        $session->setFlashdata('mensaje', 'Usuario eliminado correctamente.');
        return redirect()->to('/admin/usuarios');
    }

    /**
     * Gestionar beats (ver todos los beats del sistema)
     */
    public function beats()
    {
        $beats = $this->beatModel
            ->select('beats.*, usuarios.nombre_usuario as productor_nombre')
            ->join('usuarios', 'usuarios.id = beats.id_productor')
            ->findAll();

        return view('admin/beats', ['beats' => $beats]);
    }

    /**
     * Eliminar beat (desde admin)
     */
    public function eliminarBeat($id)
    {
        $beat = $this->beatModel->find($id);

        if (!$beat) {
            session()->setFlashdata('error', 'Beat no encontrado.');
            return redirect()->to('/admin/beats');
        }

        $this->beatModel->delete($id);
        session()->setFlashdata('mensaje', 'Beat eliminado permanentemente.');
        return redirect()->to('/admin/beats');
    }

    /**
     * Cambiar estado de un beat
     */
    public function cambiarEstadoBeat($id)
    {
        $beat = $this->beatModel->find($id);

        if (!$beat) {
            session()->setFlashdata('error', 'Beat no encontrado.');
            return redirect()->to('/admin/beats');
        }

        $nuevoEstado = $this->request->getPost('estado');
        
        if (!in_array($nuevoEstado, ['publico', 'oculto', 'eliminado'])) {
            session()->setFlashdata('error', 'Estado inválido.');
            return redirect()->to('/admin/beats');
        }

        $this->beatModel->update($id, ['estado' => $nuevoEstado]);
        session()->setFlashdata('mensaje', 'Estado del beat actualizado.');
        return redirect()->to('/admin/beats');
    }
}
