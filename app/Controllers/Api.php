<?php

namespace App\Controllers;

use App\Models\PlaylistModel;
use CodeIgniter\Controller;

class Api extends Controller
{
    /**
     * Obtener playlists del usuario autenticado (para modal)
     */
    public function playlistsUsuario()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'No autenticado'
            ]);
        }
        
        $playlistModel = new PlaylistModel();
        $playlists = $playlistModel->getPlaylistsUsuario($session->get('id'));
        
        // Agregar conteo de beats
        foreach ($playlists as &$playlist) {
            $playlist['total_beats'] = $playlistModel->contarBeats($playlist['id']);
        }
        
        return $this->response->setJSON([
            'success' => true,
            'playlists' => $playlists
        ]);
    }
}
