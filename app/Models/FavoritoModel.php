<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoritoModel extends Model
{
    protected $table      = 'favoritos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_usuario', 'id_beat', 'fecha_agregado'];
    public $timestamps = false;
}
