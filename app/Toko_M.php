<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Toko_M extends Model
{
    protected $table = 'tbl_toko';

    protected $fillable = [
        'id_cust',
        'id_toko', 
        'nama_toko',
        'alamat', 
        'telepon',
        'logo', 
        'jam_buka',
        'jam_tutup',
        'enabled',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_toko';

    public function customer(){
        return $this->belongsTo(Login_M::class,'id_cust','id_cust');
    }
}
