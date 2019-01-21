<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'permissions';

    /**
     * Run the migrations.
     * @table permissions
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->uuid('PERMISSIONS_ID');
            $table->string('PERMISSIONS_NAME', 191);
            $table->enum('PERMISSIONS_TYPE', ['POLICY', 'GATE'])->default('GATE');
            $table->timestamp('PERMISSIONS_CREATED_AT')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('PERMISSIONS_CREATED_BY', 191)->nullable()->default(null);
            $table->timestamp('PERMISSIONS_UPDATED_AT')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('PERMISSIONS_UPDATED_BY', 191)->nullable()->default(null);
            $table->timestamp('PERMISSIONS_DELETED_AT')->nullable()->default(null);
            $table->string('PERMISSIONS_DELETED_BY', 191)->nullable()->default(null);
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
