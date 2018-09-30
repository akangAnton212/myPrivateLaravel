<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use App\Barang_M;

class ControllerBarang extends Controller
{
    public function index()
    {
        return view("toko.barang");
    }

    public function listBarang(){
        $destinationPath = public_path('uploads/produk');

        $res = DB::table('tbl_product')
                    ->join('tbl_toko', 'tbl_product.id_toko', '=', 'tbl_toko.id_toko')
                    ->select('id_product','nama_barang','stock','harga','satuan','description','foto','tbl_toko.nama_toko')
                    ->get();
        return Datatables::of($res)
                ->addColumn('foto', function ($res) { 
                    $url=asset("uploads/produk/".$res->foto); 
                    return '<img src='.$url.' border="0" width="100" class="img-rounded" align="center" />'; })
                ->addColumn('action', function ($res) {
                    return "<button type='button' class='btn btn-warning' onclick='getData($res->id_product)' data-toggle='modal' data-target='#edit-modal'>
                                <i class='fa fa-edit'></I>
                            </button>
                            <button type='button' class='btn btn-danger' onclick='DeleteData( $res->id_product)'>
                                <i class='fa fa-trash'></i>
                            </button>";
                })->make(true);
    }

    public function tambahBarang(){

    }
}
