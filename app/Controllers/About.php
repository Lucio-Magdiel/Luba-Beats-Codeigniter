<?php

namespace App\Controllers;

class About extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Acerca de - LubaBeats Beta'
        ];
        
        return view('home/about', $data);
    }
}
