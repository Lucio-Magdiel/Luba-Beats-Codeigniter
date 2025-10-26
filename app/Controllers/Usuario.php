<?php

namespace App\Controllers;

use App\Models\BeatModel;
use App\Models\UsuarioModel;
use App\Models\PlaylistModel;
use App\Libraries\CloudinaryService;
use CodeIgniter\Controller;

class Usuario extends Controller
{
    protected $cloudinary;
    
    public function __construct()
    {
        helper('cloudinary');
        $this->cloudinary = new CloudinaryService();
    }
    public function catalogo()
    {
        $session = session();

        if (!$session->get('logueado') || $session->get('tipo') != 'comprador') {
            return redirect()->to('/auth/login');
        }

        $beatModel = new BeatModel();

        $beats = $beatModel->getBeatsConCreador(null, null);

        return view('usuario/catalogo', ['beats' => $beats]);
    }
    
    /**
     * Mi Perfil (editar)
     */
    public function miPerfil()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->find($session->get('id'));
        
        return view('usuario/mi_perfil', ['usuario' => $usuario]);
    }
    
    /**
     * Actualizar perfil
     */
    public function actualizarPerfil()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $usuarioModel = new UsuarioModel();
        $id_usuario = $session->get('id');
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'bio' => 'permit_empty|max_length[500]',
            'foto_perfil' => 'if_exist|max_size[foto_perfil,2048]|ext_in[foto_perfil,jpg,jpeg,png,gif]',
            'banner' => 'if_exist|max_size[banner,5120]|ext_in[banner,jpg,jpeg,png,gif]',
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return view('usuario/mi_perfil', [
                'usuario' => $usuarioModel->find($id_usuario),
                'validation' => $this->validator
            ]);
        }
        
        $data = [
            'bio' => $this->request->getPost('bio')
        ];
        
        // Subir foto de perfil a Cloudinary
        $fotoPerfil = $this->request->getFile('foto_perfil');
        if ($fotoPerfil && $fotoPerfil->isValid()) {
            $result = $this->cloudinary->uploadProfilePhoto(
                $fotoPerfil->getTempName(), 
                $id_usuario
            );
            
            if ($result['success']) {
                $data['foto_perfil'] = $result['url'];
            } else {
                log_message('error', 'Error subiendo foto de perfil: ' . $result['error']);
            }
        }
        
        // Subir banner a Cloudinary
        $banner = $this->request->getFile('banner');
        if ($banner && $banner->isValid()) {
            $result = $this->cloudinary->uploadProfileBanner(
                $banner->getTempName(), 
                $id_usuario
            );
            
            if ($result['success']) {
                $data['banner'] = $result['url'];
            } else {
                log_message('error', 'Error subiendo banner: ' . $result['error']);
            }
        }
        
        $usuarioModel->update($id_usuario, $data);
        
        session()->setFlashdata('mensaje', 'Perfil actualizado exitosamente');
        return redirect()->to('/usuario/mi-perfil');
    }
    
    /**
     * Mis Playlists
     */
    public function misPlaylists()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $playlistModel = new PlaylistModel();
        $playlists = $playlistModel->getPlaylistsUsuario($session->get('id'));
        
        // Agregar conteo de beats
        foreach ($playlists as &$playlist) {
            $playlist['total_beats'] = $playlistModel->contarBeats($playlist['id']);
        }
        
        return view('usuario/playlists', ['playlists' => $playlists]);
    }
    
    /**
     * Crear playlist
     */
    public function crearPlaylist()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'No autenticado']);
            }
            return redirect()->to('/auth/login');
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'permit_empty|max_length[500]',
            'es_publica' => 'required|in_list[0,1]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'message' => 'Datos inválidos']);
            }
            return redirect()->back()->withInput()->with('error', 'Datos inválidos');
        }
        
        $playlistModel = new PlaylistModel();
        
        $playlistId = $playlistModel->insert([
            'id_usuario' => $session->get('id'),
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'es_publica' => $this->request->getPost('es_publica')
        ]);
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Playlist creada exitosamente',
                'playlist_id' => $playlistId
            ]);
        }
        
        session()->setFlashdata('mensaje', 'Playlist creada exitosamente');
        return redirect()->to('/usuario/playlists');
    }
    
    /**
     * Editar playlist
     */
    public function editarPlaylist($id_playlist)
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->getPlaylistConBeats($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no encontrada');
        }
        
        return view('usuario/editar_playlist', ['playlist' => $playlist]);
    }
    
    /**
     * Actualizar playlist
     */
    public function actualizarPlaylist($id_playlist)
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no encontrada');
        }
        
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nombre' => 'required|min_length[3]|max_length[100]',
            'descripcion' => 'permit_empty|max_length[500]',
            'es_publica' => 'required|in_list[0,1]'
        ]);
        
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', 'Datos inválidos');
        }
        
        $playlistModel->update($id_playlist, [
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'es_publica' => $this->request->getPost('es_publica')
        ]);
        
        session()->setFlashdata('mensaje', 'Playlist actualizada');
        return redirect()->to('/usuario/playlists');
    }
    
    /**
     * Eliminar playlist
     */
    public function eliminarPlaylist($id_playlist)
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return redirect()->to('/auth/login');
        }
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Playlist no encontrada');
        }
        
        $playlistModel->delete($id_playlist);
        
        session()->setFlashdata('mensaje', 'Playlist eliminada');
        return redirect()->to('/usuario/playlists');
    }
    
    /**
     * Agregar beat a playlist
     */
    public function agregarBeatPlaylist()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autenticado']);
        }
        
        $id_playlist = $this->request->getPost('id_playlist');
        $id_beat = $this->request->getPost('id_beat');
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Playlist no encontrada']);
        }
        
        if ($playlistModel->agregarBeat($id_playlist, $id_beat)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Beat agregado a la playlist']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'El beat ya está en la playlist']);
    }
    
    /**
     * Quitar beat de playlist
     */
    public function quitarBeatPlaylist()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autenticado']);
        }
        
        $id_playlist = $this->request->getPost('id_playlist');
        $id_beat = $this->request->getPost('id_beat');
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Playlist no encontrada']);
        }
        
        if ($playlistModel->quitarBeat($id_playlist, $id_beat)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Beat eliminado de la playlist']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al eliminar']);
    }
    
    /**
     * Reordenar beats en playlist
     */
    public function reordenarPlaylist()
    {
        $session = session();
        
        if (!$session->get('logueado')) {
            return $this->response->setJSON(['success' => false, 'message' => 'No autenticado']);
        }
        
        $json = $this->request->getJSON();
        $id_playlist = $json->id_playlist ?? null;
        $beats_orden = $json->beats_orden ?? [];
        
        if (!$id_playlist || empty($beats_orden)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Datos incompletos']);
        }
        
        $playlistModel = new PlaylistModel();
        $playlist = $playlistModel->find($id_playlist);
        
        if (!$playlist || $playlist['id_usuario'] != $session->get('id')) {
            return $this->response->setJSON(['success' => false, 'message' => 'Playlist no encontrada']);
        }
        
        if ($playlistModel->reordenarBeats($id_playlist, $beats_orden)) {
            return $this->response->setJSON(['success' => true, 'message' => 'Orden actualizado']);
        }
        
        return $this->response->setJSON(['success' => false, 'message' => 'Error al reordenar']);
    }
}
