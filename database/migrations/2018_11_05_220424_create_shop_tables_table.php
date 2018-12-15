<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_outlet_id')->unsigned();
            $table->integer('number')->unsigned();
            $table->boolean('reserved')->default(false);
            $table->timestamps();

            $table->foreign('shop_outlet_id')->references('id')->on('shop_outlets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_tables', function (Blueprint $table) {
            $table->dropForeign(['shop_outlet_id']);
            $table->dropIfExists();
        });
    }
}
