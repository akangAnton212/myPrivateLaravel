<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use App\Register_M;

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
        $username = $request->input('username');
        $password = $request->input('password');
        $rePassword = $request->input('rePassword');

        $validator = Validator::make($request->all(), [
            'username'      => 'required|max:255',
            'password'      => 'required|min:6',
            'rePassword'    => 'required|min:6',
        ]);

        $hashPass = Hash::make($password);

        if ($validator->fails()) {    
            return response()->json(['status'=>422,'message'=>$validator->messages()]);
        }else{
            if($password!=$rePassword){
                return response()->json(['status'=>422,'message'=>'Password Not Match']);
            }else{      
                try{
                    DB::beginTransaction();

                    DB::insert('insert into tbl_customer (nama, password,enabled) values (?, ?, ?)', [
                        $username, 
                        $hashPass,
                        '1'
                    ]);

                    $result = DB::commit();

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        return response()->json(['status'=>200, 'message'=>'Success Saved For '.$username]);
                    }
                }catch(\Exception $e){
                    return ['status'=>500, 'message'=>$e->getMessage()];
                }       
            }
        }        
    }
    
}

