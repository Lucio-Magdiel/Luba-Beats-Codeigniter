<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nombre_usuario',
        'correo',
        'contrasena',
        'tipo',
        'foto_perfil',
        'banner',
        'bio',
        'verificado_google',
        'fecha_registro',
    ];

    protected $useTimestamps = false; // ya tienes el campo fecha_registro
}
