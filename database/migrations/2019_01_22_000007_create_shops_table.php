<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'shops';

    /**
     * Run the migrations.
     * @table shops
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->text('logo')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->text('address')->nullable()->default(null);
            $table->enum('type', ['1', '2', '3']);
            $table->unsignedInteger('tax')->default('0');

            $table->index(["user_id"], 'shops_user_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('user_id', 'shops_user_id_foreign')
                ->references('id')->on('users')
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
