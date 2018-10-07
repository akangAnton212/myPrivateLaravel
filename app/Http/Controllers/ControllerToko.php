<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

            $validator = Validator::make($request->all(), [
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $cbganti = $request->input('cbgantifoto');

            if ($cbganti==1 && $request->hasFile('foto')){
                if ($validator->fails()) {    
                    return response()->json(['status'=>422,'message'=>$validator->messages()]);
                }else{

                    //jika checkbox di check dan foto ny ada maka
                    //find data by id, lalu di hapus datanya yg di file
                    $foto = Toko_M::where('id_cust',$request->session()->get('id_cust'))->where('enabled',1)->first();
                    $filenames = 'uploads/avatar_toko/'.$foto->logo;
                    Storage::disk('public_path')->delete($filenames);

                    DB::beginTransaction();

                    $file = $request->file('foto');
                    $extension = $file->getClientOriginalExtension(); // getting image extension
                    $filename =time().'.'.$extension;
                    $destinationPath = public_path('uploads/avatar_toko');
                    $imagePath = $destinationPath. "/".  $filename;
                    $file->move($destinationPath, $filename);

                    $response = Toko_M::updateOrCreate([
                        'id_cust'  => $request->session()->get('id_cust')     
                    ],[
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
                        return response()->json(['status'=>200, 'message'=>'Success Create Or Update Your Store!!']);
                    }
                }   
            }else{
                DB::beginTransaction();

                $file = $request->file('foto');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $destinationPath = public_path('uploads/avatar_toko');
                $imagePath = $destinationPath. "/".  $filename;
                $file->move($destinationPath, $filename);

                $response = Toko_M::updateOrCreate([
                    'id_cust'  => $request->session()->get('id_cust')     
                ],[
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
                    return response()->json(['status'=>200, 'message'=>'Success Create Or Update Your Store!!']);
                }
            }

            // if($request->hasFile('foto')) { 

            //     if ($validator->fails()) {    
            //         return response()->json(['status'=>422,'message'=>$validator->messages()]);
            //     }else{

            //         DB::beginTransaction();

            //         $file = $request->file('foto');
            //         $extension = $file->getClientOriginalExtension(); // getting image extension
            //         $filename =time().'.'.$extension;
            //         $destinationPath = public_path('uploads/avatar_toko');
            //         $imagePath = $destinationPath. "/".  $filename;
            //         $file->move($destinationPath, $filename);

            //         $response = Toko_M::updateOrCreate([
            //             'id_cust'  => $request->session()->get('id_cust')     
            //         ],[
            //             'nama_toko'=> $request->input('namaToko'),
            //             'alamat'   => $request->input('alamat'),
            //             'telepon'  => $request->input('telepon'),
            //             'logo'     => $filename,
            //             'jam_buka' => $request->input('jamBuka'),
            //             'jam_tutup'=> $request->input('jamTutup'),
            //             'enabled'  => 1,
            //             'id_cust'  => $request->session()->get('id_cust')
            //         ]);
                    
            //         $result = DB::commit();

            //         if($result===FALSE){
            //             DB::rollBack();
            //             return response()->json(['status'=>500,'message'=>'Internal Server Error']);
            //         }else{
            //             return response()->json(['status'=>200, 'message'=>'Success Create Or Update Your Store!!']);
            //         }
            //     }                
            // }else{

            // }         

        } catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
        }
    }

    public function pengaturanToko(){
        return view("toko.pengaturan_toko");
    }

    public function cekToko(){
         //cek dia udah punya toko apa belom
         $sess = session()->get('id_cust');
         try{
            $data = array();
            $x =  Toko_M::where('id_cust',$sess)->where('enabled',1)->get();

            foreach($x as $r){
                $data[] = $r->nama_toko;
                $data[] = $r->alamat;
                $data[] = $r->telepon;
                $data[] = $r->logo;
                $data[] = $r->jam_buka;
                $data[] = $r->jam_tutup;
            }

            echo join('|', $data);

         }catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
         }
    }
}
