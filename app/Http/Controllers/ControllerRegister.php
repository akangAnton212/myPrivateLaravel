<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ControllerRegister extends Controller
{
    public function index()
    {
        return view("register");
    }

    public function daftar()
    {
        
    }

    public function daftarSimpan(Request $request)
    {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required|min:4',
            'rePassword' => 'required|min:4'
        ]);
        
        $Repass = $request->input("rePassword");
        $pass = $request->input("password");

        if ($pass != $Repass)
        {
            $validator->errors()->add("rePassword", "Password Not Match");
            return back()->withErrors($validator);

        }else
        {
            return $request->input("username");
        }

        
    }
    
}
