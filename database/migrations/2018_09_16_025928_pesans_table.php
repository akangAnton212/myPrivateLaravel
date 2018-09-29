<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PesansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_pesan', function (Blueprint $table) {
            $table->increments('id_pesan');
            $table->integer('id_cust_penerima')->unsigned();
            $table->integer('id_cust_pengirim')->unsigned();
            $table->text('pesan');
            $table->datetime('tgl');
            $table->boolean('enabled');
            $table->timestamps();
            
            $table->foreign('id_cust_penerima')
                  ->references('id_cust')->on('tbl_customer')
                  ->onDelete('restrict');

            $table->foreign('id_cust_pengirim')
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
        Schema::dropIfExists('tbl_pesan');
    }
}
