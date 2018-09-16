<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CartTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_cart', function (Blueprint $table) {
            $table->increments('id_cart');
            $table->integer('id_product')->unsigned();
            $table->integer('qty');
            $table->integer('id_cust')->unsigned();
            $table->boolean('enabled');
            $table->timestamps();

            $table->foreign('id_product')
                  ->references('id_product')->on('tbl_product')
                  ->onDelete('restrict');

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
        Schema::dropIfExists('tbl_cart');
    }
}
