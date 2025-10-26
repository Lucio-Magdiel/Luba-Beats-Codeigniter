<?php

namespace App\Controllers;

use App\Models\BeatModel;
use App\Models\FavoritoModel;
use CodeIgniter\Controller;

class Catalogo extends Controller
{
    public function __construct()
    {
        helper('cloudinary');
    }
    
    public function index()
    {
        $beatModel = new BeatModel();
        $q = $this->request->getGet('q');
        $tipo = $this->request->getGet('tipo'); // Nuevo: filtro por tipo

        // Obtener beats con información del creador
        $beats = $beatModel->getBeatsConCreador($tipo);

        // Filtro de búsqueda
        if ($q) {
            $beats = array_filter($beats, function($beat) use ($q) {
                return stripos($beat['titulo'], $q) !== false || 
                       stripos($beat['genero'], $q) !== false;
            });
        }

        // Separar por tipo para la vista principal
        $beats_data = [
            'todos' => $beats,
            'beats' => array_filter($beats, fn($b) => $b['tipo'] === 'beat'),
            'musica' => array_filter($beats, fn($b) => $b['tipo'] === 'musica'),
            'filtro_activo' => $tipo ?? 'todos'
        ];

        return view('catalogo/index', $beats_data);
    }

    // Vista exclusiva de BEATS
    public function beats()
    {
        $beatModel = new BeatModel();
        $q = $this->request->getGet('q');

        $beats = $beatModel->getBeatsConCreador('beat');

        if ($q) {
            $beats = array_filter($beats, function($beat) use ($q) {
                return stripos($beat['titulo'], $q) !== false || 
                       stripos($beat['genero'], $q) !== false;
            });
        }

        return view('catalogo/beats', ['beats' => $beats]);
    }

    // Vista exclusiva de MÚSICA
    public function musica()
    {
        $beatModel = new BeatModel();
        $q = $this->request->getGet('q');

        $musica = $beatModel->getBeatsConCreador('musica');

        if ($q) {
            $musica = array_filter($musica, function($beat) use ($q) {
                return stripos($beat['titulo'], $q) !== false || 
                       stripos($beat['genero'], $q) !== false;
            });
        }

        return view('catalogo/musica', ['musica' => $musica, 'query' => $q]);
    }

    public function agregar_favorito($id_beat)
    {
        $session = session();
        $favoritoModel = new FavoritoModel();
        $id_usuario = $session->get('id');

        $existe = $favoritoModel->where('id_usuario', $id_usuario)
                               ->where('id_beat', $id_beat)
                               ->first();
        if (!$existe) {
            $favoritoModel->insert([
                'id_usuario' => $id_usuario,
                'id_beat' => $id_beat
            ]);
            session()->setFlashdata('mensaje', 'Beat agregado a favoritos.');
        } else {
            session()->setFlashdata('info', 'Este beat ya está en tus favoritos.');
        }
        return redirect()->to('/catalogo');
    }

    public function quitar_favorito($id_beat)
    {
        $session = session();
        $favoritoModel = new FavoritoModel();
        $id_usuario = $session->get('id');

        $favoritoModel->where('id_usuario', $id_usuario)
                      ->where('id_beat', $id_beat)
                      ->delete();

        session()->setFlashdata('mensaje', 'Beat eliminado de favoritos.');
        return redirect()->to('/catalogo');
    }

    public function mis_favoritos()
    {
        $session = session();
        $favoritoModel = new FavoritoModel();
        $beatModel = new BeatModel();

        $favoritos = $favoritoModel->where('id_usuario', $session->get('id'))->findAll();

        $beats = [];
        foreach ($favoritos as $fav) {
            $beat = $beatModel->getBeatConCreador($fav['id_beat']);
            if ($beat && $beat['estado'] == 'publico') {
                $beats[] = $beat;
            }
        }

        return view('catalogo/mis_favoritos', ['beats' => $beats]);
    }

    public function detalle($id)
    {
        $beatModel = new BeatModel();
        $beat = $beatModel->getBeatConCreador($id);

        if (!$beat || $beat['estado'] != 'publico') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Beat no encontrado');
        }

        return view('catalogo/detalle', ['beat' => $beat]);
    }
}

