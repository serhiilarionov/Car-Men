<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCategoryCatalogCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_category_catalog_city', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->default(null)->unsigned();
            $table->foreign('category_id')->references('id')->on('catalog_category');
            $table->integer('city_id')->nullable()->default(null)->unsigned();
            $table->foreign('city_id')->references('id')->on('catalog_city');
            $table->integer('count')->nullable();

            $table->primary(['category_id', 'city_id'])->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_category_catalog_city');
    }
}
