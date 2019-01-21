<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductStocksTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'product_stocks';

    /**
     * Run the migrations.
     * @table product_stocks
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('shop_outlet_id');
            $table->unsignedInteger('product_id');
            $table->integer('number_of_stock')->default('0');
            $table->string('unit')->nullable()->default('item');

            $table->index(["shop_outlet_id"], 'product_stocks_shop_outlet_id_foreign');

            $table->index(["product_id"], 'product_stocks_product_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('product_id', 'product_stocks_product_id_foreign')
                ->references('id')->on('products')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('shop_outlet_id', 'product_stocks_shop_outlet_id_foreign')
                ->references('id')->on('shop_outlets')
                ->onDelete('cascade')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
