<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopOutletsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shop_outlets';

    /**
     * Run the migrations.
     * @table shop_outlets
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
            $table->string('name');
            $table->string('phone')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->tinyInteger('is_main_branch')->default('0');
            $table->unsignedInteger('number_of_table')->nullable()->default(null);

            $table->index(["shop_id"], 'shop_outlets_shop_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('shop_id', 'shop_outlets_shop_id_foreign')
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
