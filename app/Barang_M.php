<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Barang_M extends Model
{
    protected $table = 'tbl_product';

    protected $fillable = [
        'id_product',
        'nama_barang', 
        'stock',
        'harga', 
        'id_satuan',
        'description', 
        'foto',
        'id_toko',
        'enabled',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_product';

    public function toko(){
        return $this->belongsTo(Toko_M::class,'id_toko','id_toko');
    }

    public function satuan(){
        return $this->belongsTo(Satuan_M::class,'id_satuan','id_satuan');
    }

}
