<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Validator;
use App\Barang_M;
use App\Satuan_M;
use App\Toko_M;
use App\Barang_detail_M;

class ControllerBarang extends Controller
{
    public function index()
    {
        return view("toko.barang");
    }

    public function listBarang(){
        $destinationPath = public_path('uploads/produk');

        // $res = DB::table('tbl_product')
        //             ->join('tbl_toko', 'tbl_product.id_toko', '=', 'tbl_toko.id_toko')
        //             ->select('id_product','nama_barang','stock','harga','id_satuan','description','foto','tbl_toko.nama_toko')
        //             ->get();
        $res = Barang_M::where('enabled', 1)->get();
        return Datatables::of($res)
                ->addColumn('satuan', function ($res) { 
                    return $res->satuan->nama_satuan;
                })
                ->addColumn('nama_toko', function ($res) { 
                    return $res->toko->nama_toko;
                })
                ->addColumn('foto', function ($res) {
                    $foto = $res->foto()->first()->foto;
                    $url=asset("uploads/produk/".$foto); 
                    return '<img src='.$url.' border="0" width="100" class="img-rounded" align="center" />'; })
                ->addColumn('action', function ($res) {
                    return "<button type='button' class='btn btn-warning' onclick='getData($res->id_product)' data-toggle='modal' data-target='#edit-modal'>
                                <i class='fa fa-edit'></I>
                            </button>
                            <button type='button' class='btn btn-danger' onclick='DeleteData($res->id_product)'>
                                <i class='fa fa-trash'></i>
                            </button>
                            <button type='button' class='btn btn-primary' onclick='detail($res->id_product)'>
                                <i class='fa fa-info'></i>
                            </button>";
                            
                })->make(true);
    }

    public function tambahBarang(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($request->hasFile('foto')){
                if ($validator->fails()) {    
                    return response()->json(['status'=>422,'message'=>$validator->messages()]);
                }else{

                    DB::beginTransaction();

                    //ngambil id tokonya
                    $toko = Toko_M::where('id_cust',$request->session()->get('id_cust'))->where('enabled',1)->first();

                    $response = Barang_M::Create([
                        'nama_barang'   => $request->input('nama_barang'),
                        'stock'         => $request->input('stock'),
                        'harga'         => $request->input('harga'),
                        'id_satuan'     => $request->input('satuan'),
                        'description'   => $request->input('description'),
                        'id_toko'       => $toko->id_toko,
                        'enabled'       => 1
                    ]);
                                    
                    $result = DB::commit();

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        //return response()->json(['status'=>200, 'message'=>'Success Create Or Update Your Store!!']);
                    }

                    DB::beginTransaction();

                    //abis di komit ambil id barangnya buat nnti di barang detail

                    foreach($request->file('foto') as $image)
                    {
                        $file = $request->file('foto');
                        $extension = $image->getClientOriginalExtension(); // getting image extension
                        $filename =time().'.'.$extension;
                        $destinationPath = public_path('uploads/produk');
                        $imagePath = $destinationPath. "/".  $filename;
                        $image->move($destinationPath, $filename);
                       
                        $responsex = Barang_detail_M::Create([
                            'id_product'   => $response->id_product,
                            'foto'         => $filename
                        ]);


                        $result = DB::commit();

                    }

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        return response()->json(['status'=>200, 'message'=>'Success Tambah Barang']);
                    }
                }   
            }
        } catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
        }
    }

    public function barangEdit(Request $request){
        $success = false;
        try{
            $validator = Validator::make($request->all(), [
                'foto.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $toko = Toko_M::where('id_cust',$request->session()->get('id_cust'))->where('enabled',1)->first();

            if ($request->hasFile('foto')){
                if ($validator->fails()) {    
                    return response()->json(['status'=>422,'message'=>$validator->messages()]);
                }else{

                    DB::beginTransaction();

                    $response = Barang_M::where('id_product', $request->input('id'))
                                        ->update ([
                                            'nama_barang'   => $request->input('nama_barang_edit'),
                                            'stock'         => $request->input('stock_edit'),
                                            'harga'         => $request->input('harga_edit'),
                                            'id_satuan'     => $request->input('satuan_edit'),
                                            'description'   => $request->input('description_edit'),
                                            'id_toko'       => $toko->id_toko,
                                            'enabled'       => 1
                                        ]);
                                                        
                    $result = DB::commit();

                    if($result===FALSE){
                        DB::rollBack();
                        return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                    }else{
                        $success = true;
                    }

                    DB::beginTransaction();

                    //kalo sukses true maka

                    if($success == true){
                        foreach($request->file('foto') as $image)
                        {
                            $file = $request->file('foto');
                            $extension = $image->getClientOriginalExtension(); // getting image extension
                            $filename =time().'.'.$extension;
                            $destinationPath = public_path('uploads/produk');
                            $imagePath = $destinationPath. "/".  $filename;
                            $image->move($destinationPath, $filename);
                            
                            $responsex = Barang_detail_M::Create([
                                'id_product'   => $request->input('id'),
                                'foto'         => $filename
                            ]);


                            $result = DB::commit();

                        }

                        if($result===FALSE){
                            DB::rollBack();
                            return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                        }else{
                            return response()->json(['status'=>200, 'message'=>'Success Update Barang','kode'=>$request->input('id')]);
                        }
                    }else{
                        return response()->json(['status'=>500, 'message'=>'Gagal Simpan Data']);
                    }    
                }   
            }else{
                DB::beginTransaction();
            
                $response = Barang_M::where('id_product', $request->input('id'))
                                    ->update ([
                                        'nama_barang'   => $request->input('nama_barang_edit'),
                                        'stock'         => $request->input('stock_edit'),
                                        'harga'         => $request->input('harga_edit'),
                                        'id_satuan'     => $request->input('satuan_edit'),
                                        'description'   => $request->input('description_edit'),
                                        'id_toko'       => $toko->id_toko,
                                        'enabled'       => 1
                                    ]);
                                                    
                $result = DB::commit();

                if($result===FALSE){
                    DB::rollBack();
                    return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                }else{
                    return response()->json(['status'=>200, 'message'=>'Success Update Barang!!','kode'=>$request->input('id')]);
                    //$success = true;
                }
            }
        } catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
        }
    }

    function satuan(){
        $x =  Satuan_M::select('id_satuan as code','nama_satuan')->get();
        $html="";
        $html="<option value=''>Choose One</option>";

        foreach($x as $row){
            $html.="<option data-tokens='".$row->nama_satuan."' value='".$row->code."' >".$row->nama_satuan."</option>";
        }
        //<option value="{{ $role->id }}" {{ $selectedRole == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option> 

        echo $html;
    }

    public function listSatuanEdit($id){
        $y = Barang_M::select('id_satuan')->where('id_product', $id)->where('enabled', 1)->get();
        $x =  Satuan_M::select('id_satuan as code','nama_satuan')->get();
        $html="";
        $html="<option value=''>Choose One</option>";

        foreach($x as $row){
            $html.="<option data-tokens='".$row->nama_satuan."' value='".$row->code."' ".$y==$row->code ? 'selected="selected"' : ''.">".$row->nama_satuan."</option>";
        }
        //<option value="{{ $role->id }}" {{ $selectedRole == $role->id ? 'selected="selected"' : '' }}>{{ $role->name }}</option> 

        echo $html;
    }

    public function barangDetail(Request $request){
        $id = $request->input('id');
        $data = array();
        $x = Barang_M::where('id_product', $id)->where('enabled', 1)->get();
        foreach($x as $r){
            $data[] = $r->id_product;
            $data[] = $r->nama_barang;
            $data[] = $r->stock;
            $data[] = $r->harga;
            $data[] = $r->description;
            $data[] = $r->id_satuan;
            $data[] = $r->satuan->nama_satuan;
        }

        echo join('|', $data);
    }

    public function galery(Request $request){
        $html="";
        $id = $request->input('id');
        $y = Barang_detail_M::where('id_product', $id)->get();

        foreach($y as $r){
            $url=asset("uploads/produk/".$r->foto);
            if($r){
                $html .= "
                    <div>
                        <div>
                            <img src=".$url." border='0' width='100' class='img-rounded' align='center'/>
                            <button type='button' style:'width':10; class='btn btn-primary' onclick='delFoto($r->id_detailproduct)'>X</button>
                        </div>
                    </div>";
            }
        }
       

        echo $html;

    }

    public function hapusFoto(Request $request){
        try{
                DB::beginTransaction();
                $barang = DB::table('tbl_detail_product')->select('id_product')->where('id_detailproduct', $request->input('id'))->first();
                $result = DB::table('tbl_detail_product')->where('id_detailproduct', $request->input('id'))->delete();

                $result = DB::commit();

                if($result===FALSE){
                    DB::rollBack();
                    return response()->json(['status'=>500,'message'=>'Internal Server Error']);
                }else{  
                    return response()->json(['status'=>200, 'message'=>'Success Hapus Foto', 'kode'=>$barang->id_product]);
                }
        }catch  (\Exception $e) {
            return ['status'=>500, 'message'=>$e->getMessage()];
        }
        
    }

    public function hapusBarang(Request $request){
        try{
            DB::beginTransaction();
           
            $response = Barang_M::where('id_product', $request->input('id'))
                                ->update ([
                                    'enabled'       => 0
                                ]);

            $result = DB::commit();

            if($result===FALSE){
                DB::rollBack();
                return response()->json(['status'=>500,'message'=>'Internal Server Error']);
            }else{  
                return response()->json(['status'=>200, 'message'=>'Success Hapus Barang']);
            }
       }catch  (\Exception $e) {
        return ['status'=>500, 'message'=>$e->getMessage()];
       }
    }
}
