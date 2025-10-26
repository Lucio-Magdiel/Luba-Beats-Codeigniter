<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Auth extends \CodeIgniter\Controller
{
    public function login()
    {
        echo view('auth/login');
    }

    public function procesar_login()
    {
        // Validación de entrada
        $validation = \Config\Services::validation();
        $validation->setRules([
            'correo' => [
                'label' => 'Correo electrónico',
                'rules' => 'required|valid_email|max_length[255]',
                'errors' => [
                    'required' => 'El {field} es obligatorio.',
                    'valid_email' => 'Debes proporcionar un {field} válido.',
                ]
            ],
            'contrasena' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => 'La {field} es obligatoria.',
                    'min_length' => 'La {field} debe tener al menos 6 caracteres.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('auth/login', [
                'validation' => $validation
            ]);
        }

        $correo    = $this->request->getPost('correo');
        $contrasena = $this->request->getPost('contrasena');

        // Rate limiting básico: verificar intentos fallidos
        $session = session();
        $intentos = $session->get('login_intentos') ?? 0;
        $tiempo_bloqueo = $session->get('login_bloqueado_hasta');

        if ($tiempo_bloqueo && time() < $tiempo_bloqueo) {
            $segundos_restantes = $tiempo_bloqueo - time();
            session()->setFlashdata('error', "Demasiados intentos fallidos. Espera {$segundos_restantes} segundos.");
            return redirect()->to('/auth/login');
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('correo', $correo)->first();

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            // Login exitoso - limpiar intentos
            $session->remove(['login_intentos', 'login_bloqueado_hasta']);
            
            $session->set([
                'id'            => $usuario['id'],
                'nombre_usuario'=> $usuario['nombre_usuario'],
                'tipo'          => $usuario['tipo'],
                'logueado'      => true,
            ]);
            
            // Redirigir a URL guardada o a panel por defecto
            $redirect_url = $session->get('redirect_url');
            $session->remove('redirect_url');
            
            if ($redirect_url) {
                return redirect()->to($redirect_url);
            }
            
            // Redirigir según tipo de usuario
            switch ($usuario['tipo']) {
                case 'super_admin':
                    return redirect()->to('/admin/dashboard');
                case 'productor':
                    return redirect()->to('/productor/panel');
                case 'artista':
                    return redirect()->to('/artista/panel');
                default:
                    return redirect()->to('/catalogo');
            }
        } else {
            // Login fallido - incrementar intentos
            $intentos++;
            $session->set('login_intentos', $intentos);
            
            // Bloquear después de 5 intentos fallidos
            if ($intentos >= 5) {
                $session->set('login_bloqueado_hasta', time() + 300); // 5 minutos
                session()->setFlashdata('error', 'Demasiados intentos fallidos. Cuenta bloqueada por 5 minutos.');
            } else {
                session()->setFlashdata('error', 'Correo o contraseña incorrectos.');
            }
            
            return redirect()->to('/auth/login');
        }
    }

    public function registro()
    {
        echo view('auth/registro');
    }

    public function procesar_registro()
    {
        // Validación robusta
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre_usuario' => [
                'label' => 'Nombre de usuario',
                'rules' => 'required|min_length[3]|max_length[50]|alpha_numeric_space|is_unique[usuarios.nombre_usuario]',
                'errors' => [
                    'required' => 'El {field} es obligatorio.',
                    'min_length' => 'El {field} debe tener al menos 3 caracteres.',
                    'max_length' => 'El {field} no debe exceder 50 caracteres.',
                    'alpha_numeric_space' => 'El {field} solo puede contener letras, números y espacios.',
                    'is_unique' => 'Este {field} ya está en uso.',
                ]
            ],
            'correo' => [
                'label' => 'Correo electrónico',
                'rules' => 'required|valid_email|max_length[255]|is_unique[usuarios.correo]',
                'errors' => [
                    'required' => 'El {field} es obligatorio.',
                    'valid_email' => 'Debes proporcionar un {field} válido.',
                    'is_unique' => 'Este {field} ya está registrado.',
                ]
            ],
            'contrasena' => [
                'label' => 'Contraseña',
                'rules' => 'required|min_length[8]|max_length[255]',
                'errors' => [
                    'required' => 'La {field} es obligatoria.',
                    'min_length' => 'La {field} debe tener al menos 8 caracteres.',
                ]
            ],
            'tipo' => [
                'label' => 'Tipo de usuario',
                'rules' => 'required|in_list[productor,artista,comprador]',
                'errors' => [
                    'required' => 'Debes seleccionar un tipo de usuario.',
                    'in_list' => 'Tipo de usuario inválido.',
                ]
            ],
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return view('auth/registro', [
                'validation' => $validation
            ]);
        }

        $usuarioModel = new UsuarioModel();

        $data = [
            'nombre_usuario' => trim($this->request->getPost('nombre_usuario')),
            'correo'         => strtolower(trim($this->request->getPost('correo'))),
            'contrasena'     => password_hash($this->request->getPost('contrasena'), PASSWORD_BCRYPT, ['cost' => 12]),
            'tipo'           => $this->request->getPost('tipo'),
            'fecha_registro' => date('Y-m-d H:i:s'),
        ];

        try {
            $usuarioModel->insert($data);
            session()->setFlashdata('mensaje', 'Registro exitoso. ¡Bienvenido! Ya puedes iniciar sesión.');
            return redirect()->to('/auth/login');
        } catch (\Exception $e) {
            log_message('error', 'Error en registro: ' . $e->getMessage());
            session()->setFlashdata('error', 'Ocurrió un error al registrar. Por favor intenta de nuevo.');
            return redirect()->to('/auth/registro');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login');
    }
    
}
