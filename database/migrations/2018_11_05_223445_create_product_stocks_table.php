<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_outlet_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('number_of_stock')->default(0);
            $table->timestamps();

            $table->foreign('shop_outlet_id')->references('id')->on('shop_outlets');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropForeign(['shop_outlet_id']);
            $table->dropForeign(['product_id']);
            $table->dropIfExists();
        });
    }
}
