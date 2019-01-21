<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopTablesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shop_tables';

    /**
     * Run the migrations.
     * @table shop_tables
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
            $table->unsignedInteger('number');
            $table->tinyInteger('reserved')->default('0');

            $table->index(["shop_outlet_id"], 'shop_tables_shop_outlet_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('shop_outlet_id', 'shop_tables_shop_outlet_id_foreign')
                ->references('id')->on('shop_outlets')
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
