<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCompanyRatingCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_company_rating_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_rating_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->tinyInteger('rating')->nullable();
            $table->timestamps();

            $table->foreign('company_rating_id')->references('id')->on('catalog_company_rating')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_company_rating_category');
    }
}
