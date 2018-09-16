<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControllerToko extends Controller
{
    public function index()
    {
        return view("toko.dashboard");
    }
}
