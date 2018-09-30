<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_customer', function (Blueprint $table) {
            $table->increments('id_cust');
            $table->string('nama', 50)->unique();
            $table->string('alamat');
            $table->string('email', 30);
            $table->string('telepon',15);
            $table->char('jenis_kelamin', 1);
            $table->string('avatar');
            $table->string('password');
            $table->boolean('enabled');
            $table->rememberToken();
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_customer');
    }
}
