<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_outlet_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->string('customer_name')->nullable();
            $table->double('total')->unsigned();
            $table->timestamps();

            $table->foreign('shop_outlet_id')->references('id')->on('shop_outlets');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['shop_outlet_id']);
            $table->dropForeign(['employee_id']);
            $table->dropIfExists();
        });
    }
}
