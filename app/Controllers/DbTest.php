<?php 

namespace App\Controllers;

use CodeIgniter\Controller;
use Config\Database;

class DbTest extends Controller
{
    public function index()
    {
        $db = Database::connect();

        $builder = $db->table('usuarios'); // Por ejemplo si ya tienes la tabla usuarios creada

        $query = $builder->get();

        $data = $query->getResult();

        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}
