<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Satuan_M extends Model
{
    protected $table = 'tbl_satuan';

    protected $fillable = [
        'id_satuan',
        'nama_satuan'
    ];
    protected $primaryKey = 'id_satuan';

   
}
