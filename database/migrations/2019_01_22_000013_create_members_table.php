<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'members';

    /**
     * Run the migrations.
     * @table members
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
            $table->unsignedInteger('customer_type_id');
            $table->string('nik', 50);
            $table->string('name');
            $table->string('phone');
            $table->text('address');

            $table->index(["customer_type_id"], 'members_customer_type_id_foreign');

            $table->index(["shop_id"], 'members_shop_id_foreign');
            $table->softDeletes();
            $table->nullableTimestamps();


            $table->foreign('customer_type_id', 'members_customer_type_id_foreign')
                ->references('id')->on('customer_types')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('shop_id', 'members_shop_id_foreign')
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
