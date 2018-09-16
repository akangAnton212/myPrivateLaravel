<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TokoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_toko', function (Blueprint $table) {
            $table->increments('id_toko');
            $table->integer('id_cust')->unsigned()->unique();
            $table->string('nama_toko', 50);
            $table->string('alamat');
            $table->string('telepon', 15);
            $table->string('logo');
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->boolean('enabled');
            $table->timestamps();

            $table->foreign('id_cust')
                  ->references('id_cust')->on('tbl_customer')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_toko');
    }
}
