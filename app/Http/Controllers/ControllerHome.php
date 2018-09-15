<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerHome extends Controller
{
    public function Index_get()
    {
        $data = array(
                        'name'=>'akang',
                        'alamat'=>'bantar Gebang',
                        'Telepon'=>'089637801'
                    );
        $datax = array(
                        'akang',
                        'bantar Gebang',
                        '089637801'
                    );
        
        return view ('Home/Index', ['list' => $datax]);
    }
}
