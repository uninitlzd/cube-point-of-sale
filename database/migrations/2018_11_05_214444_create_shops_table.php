<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->text('logo')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // Can be: 'Restaurant', 'Non-Restaurant' or Mixed (like coffee shop selling brewed coffee and coffee beans product)
            $table->enum('type', ['1','2','3']);

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropIfExists();
        });
    }
}
