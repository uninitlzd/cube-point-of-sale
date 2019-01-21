<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'products';

    /**
     * Run the migrations.
     * @table products
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('shop_id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('discount_id')->nullable()->default(null);
            $table->string('name');
            $table->text('description')->nullable()->default(null);
            $table->double('purchase_price');
            $table->double('selling_price');
            $table->tinyInteger('stockable')->default('0');
            $table->text('image');

            $table->index(["category_id"], 'products_category_id_foreign');

            $table->index(["discount_id"], 'products_discount_id_foreign');

            $table->index(["shop_id"], 'products_shop_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('category_id', 'products_category_id_foreign')
                ->references('id')->on('categories')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('discount_id', 'products_discount_id_foreign')
                ->references('id')->on('discounts')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('shop_id', 'products_shop_id_foreign')
                ->references('id')->on('shops')
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
