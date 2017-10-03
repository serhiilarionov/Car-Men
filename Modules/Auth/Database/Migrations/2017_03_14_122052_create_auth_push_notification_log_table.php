<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthPushNotificationLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_push_notification_log', function (Blueprint $table) {
            $table->increments('id');
            $table->string('push_name');
            $table->string('message_id');
            $table->string('device_id')->unsigned();
            $table->string('send_status');
            $table->string('read_status');

            $table->foreign('device_id')->references('device_id')->on('auth_device');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_push_notification_log');
    }
}
