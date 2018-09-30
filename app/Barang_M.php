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
        'satuan',
        'description', 
        'foto',
        'id_toko',
        'enabled',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_product';
}
