<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TransaksiDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_transaksi_detail', function (Blueprint $table) {
            $table->increments('id_transaksi_detail');
            $table->string('no_transaksi', 20);
            $table->integer('id_product')->unsigned();
            $table->integer('qty');
            $table->double('harga');
            $table->boolean('enabled');
            $table->timestamps();
            
            $table->foreign('id_product')
                  ->references('id_product')->on('tbl_product')
                  ->onDelete('restrict');

            $table->foreign('no_transaksi')
                  ->references('no_transaksi')->on('tbl_transaksi_head')
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
        Schema::dropIfExists('tbl_transaksi_detail');
    }
}
