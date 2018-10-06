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

                $sess = $request->session()->get('id_cust');

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

                    $response = Toko_M::updateOrCreate([
                        'id_cust'  => $sess      
                    ],[
                        'nama_toko'=> $request->input('namaToko'),
                        'alamat'   => $request->input('alamat'),
                        'telepon'  => $request->input('telepon'),
                        'logo'     => $filename,
                        'jam_buka' => $request->input('jamBuka'),
                        'jam_tutup'=> $request->input('jamTutup'),
                        'enabled'  => 1,
                        'id_cust'  => $sess
                    ]);
                    
                    $result = DB::commit();

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        return response()->json(['status'=>200, 'message'=>'Success Create Or Update Your Store!!']);
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

    public function cekToko(Request $request){
         //cek dia udah punya toko apa belom
         $sess = $request->input('id');
         try{
            $data = Toko_M::where('id_cust',$sess)->where('enabled',1)->first();

            if(count($data) > 0){ //apakah User tersebut ada atau tidak
                return ['status'=>200, 'message'=>'Toko Sudah Ada, Apa Anda Ingin MengUpdate Data Toko Anda?'];
            }else{
                return ['status'=>500, 'message'=>'Internal Server Error'];
            }

         }catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
         }
    }
}
