<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthUserShowLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_user_show_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('entity', 255);
            $table->integer('entity_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->timestamp('created_at');
        });

        Schema::table('auth_user_show_log', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('auth_users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_user_show_log');
    }
}
