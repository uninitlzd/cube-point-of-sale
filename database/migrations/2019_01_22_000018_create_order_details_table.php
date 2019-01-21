<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'order_details';

    /**
     * Run the migrations.
     * @table order_details
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('product_id');
            $table->double('selling_price')->nullable()->default(null);
            $table->unsignedTinyInteger('discounted')->default('0');
            $table->unsignedInteger('quantity');
            $table->double('sub_total');
            $table->string('customer_note')->nullable()->default(null);

            $table->index(["product_id"], 'order_details_product_id_foreign');

            $table->index(["order_id"], 'order_details_order_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('order_id', 'order_details_order_id_foreign')
                ->references('id')->on('orders')
                ->onDelete('cascade')
                ->onUpdate('restrict');

            $table->foreign('product_id', 'order_details_product_id_foreign')
                ->references('id')->on('products')
                ->onDelete('restrict')
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
