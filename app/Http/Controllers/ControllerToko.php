<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use App\Toko_M;

class ControllerToko extends Controller
{
    public function index()
    {
        return view("toko.dashboard");
    }

    public function buatToko(){
        return view("toko.buat_toko");
    }

    public function buatTokoPost(Request $request){
        try{
            if($request->hasFile('foto')) { 

                $validator = Validator::make($request->all(), [
                    'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($validator->fails()) {    
                    return response()->json(['status'=>422,'message'=>$validator->messages()]);
                }else{

                    DB::beginTransaction();

                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $destinationPath = public_path('uploads/avatar_toko');
                    $imagePath = $destinationPath. "/".  $filename;
                    $file->move($destinationPath, $filename);

                    $response = Toko_M::create([
                        'nama_toko'=> $request->input('namaToko'),
                        'alamat'   => $request->input('alamat'),
                        'telepon'  => $request->input('telepon'),
                        'logo'     => $filename,
                        'jam_buka' => $request->input('jamBuka'),
                        'jam_tutup'=> $request->input('jamTutup'),
                        'enabled'  => 1,
                        'id_cust'  => $request->session()->get('id_cust')   
                    ]);
                    
                    $result = DB::commit();

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        return response()->json(['status'=>200, 'message'=>'Success Create New Store!!']);
                    }
                }                
            }         

        } catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
        }
    }

    public function pengaturanToko(){
        return view("toko.pengaturan_toko");
    }
}
