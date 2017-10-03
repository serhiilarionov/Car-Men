<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParseCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parse_company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->float('rating')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('fuel')->nullable();
            $table->text('description')->nullable();
            $table->jsonb('services')->nullable();
            $table->string('data_url')->unique()->nullable();
            $table->jsonb('image')->nullable();
            $table->string('logo')->nullable();
            $table->string('washing_type')->nullable();
            $table->string('location_description')->nullable();
            $table->jsonb('car_brand')->nullable();
            $table->jsonb('services_car_brand')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('work_hour')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parse_company');
    }
}
