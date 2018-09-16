<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransaksiHeadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi_head', function (Blueprint $table) {
            $table->increments('id_transaksi');
            $table->string('no_transaksi', 20)->unique();
            $table->datetime('tgl_transaksi');
            $table->integer('id_cust')->unsigned();
            $table->integer('id_toko')->unsigned();
            $table->double('total');
            $table->boolean('enabled');
            $table->timestamps();

            $table->foreign('id_cust')
                  ->references('id_cust')->on('tbl_customer')
                  ->onDelete('restrict');

            $table->foreign('id_toko')
                  ->references('id_toko')->on('tbl_toko')
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
        Schema::dropIfExists('tbl_transaksi_head');
    }
}
