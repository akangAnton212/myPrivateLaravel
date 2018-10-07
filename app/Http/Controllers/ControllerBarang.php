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
        $res = Barang_M::all();
        return Datatables::of($res)
                ->addColumn('satuan', function ($res) { 
                    return $res->satuan->nama_satuan;
                })
                ->addColumn('nama_toko', function ($res) { 
                    return $res->toko->nama_toko;
                })
                ->addColumn('foto', function ($res) { 
                    $url=asset("uploads/produk/".$res->foto); 
                    return '<img src='.$url.' border="0" width="100" class="img-rounded" align="center" />'; })
                ->addColumn('action', function ($res) {
                    return "<button type='button' class='btn btn-warning' onclick='getData($res->id_product)' data-toggle='modal' data-target='#edit-modal'>
                                <i class='fa fa-edit'></I>
                            </button>
                            <button type='button' class='btn btn-danger' onclick='DeleteData( $res->id_product)'>
                                <i class='fa fa-trash'></i>
                            </button>
                            <button type='button' class='btn btn-primary' onclick='detail( $res->id_product)'>
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

    function satuan(){
        $x =  Satuan_M::select('id_satuan as code','nama_satuan')->get();
        $html="";
        $html="<option value=''>Choose One</option>";

        foreach($x as $row){
            $html.="<option data-tokens='".$row->nama_satuan."' value='".$row->code."'>".$row->nama_satuan."</option>";
        }

        echo $html;
    }
}
