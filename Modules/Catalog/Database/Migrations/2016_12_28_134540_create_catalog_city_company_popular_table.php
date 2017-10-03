<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCityCompanyPopularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_city_company_popular', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('city_id');
            $table->integer('company_id');
            $table->timestamp('last_date');
            $table->integer('total');

            $table->foreign('city_id')->references('id')->on('catalog_city')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('company_id')->references('id')->on('catalog_company')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_city_company_popular');
    }
}
