<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Login_M;
use Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ControllerLogin extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function postLogin(Request $request){
        
        $username = $request->input('username');
        $password = $request->input('password');

        $validator = Validator::make($request->all(), [
            'username'      => 'required|max:255',
            'password'      => 'required|min:6'
        ]);

        if ($validator->fails()) {    
            return response()->json(['status'=>422,'message'=>$validator->messages()]);
        }else{
            if (strlen($password) < 6) {
                return response()->json(['status'=>422,'message'=>'Password Harus 6 Karakter']);
            }else{
                try{
                    $data = Login_M::where('nama',$username)->where('enabled',1)->first();
                    if(count($data) > 0){ //apakah User tersebut ada atau tidak
                        if(Hash::check($password,$data->password)){
                            Session::put('nama',$data->nama);
                            Session::put('id_cust',$data->id_cust);
                            return ['status'=>200, 'message'=>'Login Success'];
                        }
                        else{
                            return ['status'=>500, 'message'=>'Password atau Username, Salah !'];
                        }
                    }
                    else{
                        return ['status'=>500, 'message'=>'Password atau Username, Salah !'];
                    }
                }catch(\Exception $e){
                    return ['status'=>500, 'message'=>$e->getMessage()];
                }
            }
        }  
       
    }
    public function signOut(){
        Session::flush();
        return redirect('/')->with('alert','Kamu sudah logout');
    }
}
