<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'orders';

    /**
     * Run the migrations.
     * @table orders
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
            $table->unsignedInteger('employee_id');
            $table->unsignedInteger('customer_type_id')->nullable()->default('1');
            $table->unsignedInteger('member_id')->nullable()->default(null);
            $table->string('customer_name')->nullable()->default(null);
            $table->double('tax');
            $table->double('order_total');
            $table->double('total');
            $table->double('paid');
            $table->integer('amount');

            $table->index(["employee_id"], 'orders_employee_id_foreign');

            $table->index(["shop_outlet_id"], 'orders_shop_outlet_id_foreign');

            $table->index(["customer_type_id"], 'orders_transaction_type_id_foreign');

            $table->index(["member_id"], 'orders_member_id_foreign');
            $table->nullableTimestamps();


            $table->foreign('employee_id', 'orders_employee_id_foreign')
                ->references('id')->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('member_id', 'orders_member_id_foreign')
                ->references('id')->on('members')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('shop_outlet_id', 'orders_shop_outlet_id_foreign')
                ->references('id')->on('shop_outlets')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('customer_type_id', 'orders_transaction_type_id_foreign')
                ->references('id')->on('customer_types')
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
