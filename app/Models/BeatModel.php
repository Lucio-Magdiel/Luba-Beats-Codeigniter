<?php

namespace App\Models;

use CodeIgniter\Model;

class BeatModel extends Model
{
    protected $table = 'beats';
    protected $primaryKey = 'id';

    protected $allowedFields = [
    'id_productor',
    'tipo',              // Nuevo: beat o musica
    'titulo',
    'genero',
    'bpm',
    'mood',
    'precio',
    'archivo_preview',
    'archivo_full',
    'estado',
    'fecha_subida',
    'duracion',
    'nota_musical',
    'archivo_visual'
];


    protected $useTimestamps = false; // ya tienes campo fecha_subida que defines en app
    
    /**
     * Obtener beats con información del creador
     */
    public function getBeatsConCreador($tipo = null, $limit = null)
    {
        $builder = $this->db->table('beats');
        $builder->select('beats.*, usuarios.nombre_usuario, usuarios.foto_perfil, usuarios.tipo as tipo_usuario');
        $builder->join('usuarios', 'usuarios.id = beats.id_productor');
        $builder->where('beats.estado', 'publico');
        
        if ($tipo) {
            $builder->where('beats.tipo', $tipo);
        }
        
        $builder->orderBy('beats.fecha_subida', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->get()->getResultArray();
    }
    
    /**
     * Obtener un beat con información del creador
     */
    public function getBeatConCreador($id)
    {
        $builder = $this->db->table('beats');
        $builder->select('beats.*, usuarios.nombre_usuario, usuarios.foto_perfil, usuarios.tipo as tipo_usuario');
        $builder->join('usuarios', 'usuarios.id = beats.id_productor');
        $builder->where('beats.id', $id);
        
        return $builder->get()->getRowArray();
    }
}
