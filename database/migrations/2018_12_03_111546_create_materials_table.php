<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned();
            $table->string('name');
            $table->double('quantity')->unsigned();
            $table->string('unit');
            $table->string('supplier');
            $table->date('purchase_date');
            $table->timestamps();

            $table->foreign('shop_id')
                ->references('id')->on('shops')
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
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['shop_id']);
            $table->dropIfExists('materials');
        });
    }
}
