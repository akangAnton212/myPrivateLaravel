<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Login_M extends Model
{
    protected $table = 'tbl_customer';

    protected $fillable = [
        'id_cust',
        'nama', 
        'alamat',
        'email', 
        'telepon',
        'jenis_kelamin', 
        'avatar',
        'password',
        'enabled',
        'remember_token',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'id_cust';
}
