<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->string('name');
            $table->text('description')->nullable();
            $table->double('purchase_price')->unsigned();
            $table->double('selling_price')->unsigned();
            $table->boolean('stockable')->default(0);
            $table->text('image');
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropForeign(['category_id']);
            $table->dropIfExists();
        });
    }
}
