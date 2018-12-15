<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('discount_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->timestamps();

            $table->foreign('discount_id')
                ->references('id')->on('discounts')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_discounts', function (Blueprint $table) {
            $table->dropForeign(['discount_id']);
            $table->dropForeign(['product_id']);
            $table->dropIfExists('product_discounts');
        });
    }
}
