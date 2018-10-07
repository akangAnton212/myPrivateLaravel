<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang_detail_M extends Model
{
    protected $table = 'tbl_detail_product';

    protected $fillable = [
        'id_detailproduct',
        'id_product',
        'foto'
    ];
    protected $primaryKey = 'id_detailproduct';
}
