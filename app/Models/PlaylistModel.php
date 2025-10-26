<?php

namespace App\Models;

use CodeIgniter\Model;

class PlaylistModel extends Model
{
    protected $table = 'playlists';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'id_usuario',
        'nombre',
        'descripcion',
        'imagen_portada',
        'es_publica',
        'fecha_creacion',
        'fecha_actualizacion'
    ];
    
    protected $useTimestamps = false;
    
    /**
     * Obtener playlists de un usuario
     */
    public function getPlaylistsUsuario($id_usuario, $solo_publicas = false)
    {
        $builder = $this->where('id_usuario', $id_usuario);
        
        if ($solo_publicas) {
            $builder->where('es_publica', 1);
        }
        
        return $builder->orderBy('fecha_creacion', 'DESC')->findAll();
    }
    
    /**
     * Obtener playlist con sus beats
     */
    public function getPlaylistConBeats($id_playlist)
    {
        $db = \Config\Database::connect();
        
        // Datos de la playlist
        $playlist = $this->find($id_playlist);
        
        if (!$playlist) {
            return null;
        }
        
        // Beats de la playlist ordenados
        $builder = $db->table('playlist_beats pb');
        $builder->select('b.*, u.nombre as nombre_usuario, pb.orden, pb.fecha_agregado');
        $builder->join('beats b', 'b.id = pb.id_beat');
        $builder->join('usuarios u', 'u.id = b.id_usuario');
        $builder->where('pb.id_playlist', $id_playlist);
        $builder->orderBy('pb.orden', 'ASC');
        
        $playlist['beats'] = $builder->get()->getResultArray();
        
        return $playlist;
    }
    
    /**
     * Contar beats en una playlist
     */
    public function contarBeats($id_playlist)
    {
        $db = \Config\Database::connect();
        return $db->table('playlist_beats')
                  ->where('id_playlist', $id_playlist)
                  ->countAllResults();
    }
    
    /**
     * Verificar si un beat está en una playlist
     */
    public function tieneBeat($id_playlist, $id_beat)
    {
        $db = \Config\Database::connect();
        return $db->table('playlist_beats')
                  ->where('id_playlist', $id_playlist)
                  ->where('id_beat', $id_beat)
                  ->countAllResults() > 0;
    }
    
    /**
     * Agregar beat a playlist
     */
    public function agregarBeat($id_playlist, $id_beat)
    {
        $db = \Config\Database::connect();
        
        // Verificar si ya existe
        if ($this->tieneBeat($id_playlist, $id_beat)) {
            return false;
        }
        
        // Obtener el siguiente orden
        $maxOrden = $db->table('playlist_beats')
                       ->selectMax('orden')
                       ->where('id_playlist', $id_playlist)
                       ->get()
                       ->getRow();
        
        $nuevoOrden = ($maxOrden && $maxOrden->orden) ? $maxOrden->orden + 1 : 1;
        
        return $db->table('playlist_beats')->insert([
            'id_playlist' => $id_playlist,
            'id_beat' => $id_beat,
            'orden' => $nuevoOrden
        ]);
    }
    
    /**
     * Quitar beat de playlist
     */
    public function quitarBeat($id_playlist, $id_beat)
    {
        $db = \Config\Database::connect();
        return $db->table('playlist_beats')
                  ->where('id_playlist', $id_playlist)
                  ->where('id_beat', $id_beat)
                  ->delete();
    }
    
    /**
     * Reordenar beats en playlist
     */
    public function reordenarBeats($id_playlist, $beats_orden)
    {
        $db = \Config\Database::connect();
        
        foreach ($beats_orden as $orden => $id_beat) {
            $db->table('playlist_beats')
               ->where('id_playlist', $id_playlist)
               ->where('id_beat', $id_beat)
               ->update(['orden' => $orden + 1]);
        }
        
        return true;
    }
}
