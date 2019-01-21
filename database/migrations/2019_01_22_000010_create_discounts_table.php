<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscountsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'discounts';

    /**
     * Run the migrations.
     * @table discounts
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
            $table->double('percentage');
            $table->date('start_at')->nullable()->default(null);
            $table->date('end_at')->nullable()->default(null);

            $table->index(["shop_id"], 'discounts_shop_id_foreign');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('shop_id', 'discounts_shop_id_foreign')
                ->references('id')->on('shops')
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
