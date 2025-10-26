<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        // Puedes redireccionar directamente al catálogo público
        return redirect()->to('/catalogo');
    }

    public function contacto()
    {
        return view('home/contacto');
    }

    public function enviarContacto()
    {
        $nombre = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $mensaje = $this->request->getPost('mensaje');

        // Aquí podrías guardar la consulta o enviar un email.

        session()->setFlashdata('mensaje', 'Mensaje enviado correctamente. Te responderemos pronto.');
        return redirect()->to('/contacto');
    }
}
