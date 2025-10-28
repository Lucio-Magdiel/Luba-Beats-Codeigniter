<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\BeatModel;
use App\Models\PlaylistModel;
use CodeIgniter\Controller;

class Perfil extends Controller
{
    /**
     * Perfil público de un usuario (productor/artista)
     * Ruta: /perfil/{username}
     */
    public function ver($username)
    {
        helper('cloudinary');
        
        $usuarioModel = new UsuarioModel();
        $beatModel = new BeatModel();
        $playlistModel = new PlaylistModel();
        
        // Buscar usuario por nombre de usuario
        $usuario = $usuarioModel->where('nombre_usuario', $username)->first();
        
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Usuario no encontrado');
        }
        
        // Solo mostrar perfiles de productores y artistas
        if (!in_array($usuario['tipo'], ['productor', 'artista', 'super_admin'])) {
            return redirect()->to('/catalogo')->with('error', 'Perfil no disponible');
        }
        
        // Obtener beats/música del usuario
        $beats = $beatModel->where('id_productor', $usuario['id'])
                           ->where('estado', 'publico')
                           ->orderBy('fecha_subida', 'DESC')
                           ->findAll();
        
        // Separar por tipo
        $beats_usuario = array_filter($beats, fn($b) => $b['tipo'] === 'beat');
        $musica_usuario = array_filter($beats, fn($b) => $b['tipo'] === 'musica');
        
        // Obtener playlists públicas
        $playlists = $playlistModel->getPlaylistsUsuario($usuario['id'], true);
        
        // Agregar conteo de beats a cada playlist
        foreach ($playlists as &$playlist) {
            $playlist['total_beats'] = $playlistModel->contarBeats($playlist['id']);
        }
        
        // Estadísticas
        $stats = [
            'total_beats' => count($beats_usuario),
            'total_musica' => count($musica_usuario),
            'total_playlists' => count($playlists),
            'total_tracks' => count($beats)
        ];
        
        $data = [
            'title' => esc($usuario['nombre_usuario']) . ' - LubaBeats Beta',
            'usuario' => $usuario,
            'beats' => $beats_usuario,
            'musica' => $musica_usuario,
            'playlists' => $playlists,
            'stats' => $stats
        ];
        
        return view('perfil/publico', $data);
    }
    
    /**
     * Ver playlist pública
     * Ruta: /perfil/{username}/playlist/{id}
     */
    public function verPlaylist($username, $id_playlist)
    {
        $usuarioModel = new UsuarioModel();
        $playlistModel = new PlaylistModel();
        
        // Buscar usuario
        $usuario = $usuarioModel->where('nombre_usuario', $username)->first();
        
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Usuario no encontrado');
        }
        
        // Obtener playlist con beats
        $playlist = $playlistModel->getPlaylistConBeats($id_playlist);
        
        if (!$playlist) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no encontrada');
        }
        
        // Verificar que la playlist sea del usuario y sea pública
        if ($playlist['id_usuario'] != $usuario['id']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no encontrada');
        }
        
        // Si no es el dueño, verificar que sea pública
        $session = session();
        $es_dueno = $session->get('id') == $usuario['id'];
        
        if (!$es_dueno && !$playlist['es_publica']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no disponible');
        }
        
        $data = [
            'usuario' => $usuario,
            'playlist' => $playlist,
            'es_dueno' => $es_dueno
        ];
        
        return view('perfil/playlist', $data);
    }
}
