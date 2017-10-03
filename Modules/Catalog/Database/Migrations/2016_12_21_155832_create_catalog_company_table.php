<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_company', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('city_id')->unsigned()->nullable();
            $table->string('address');
            $table->string('point')->nullable();
            $table->string('short_desc');
            $table->string('picture');
            $table->float('rating');
            $table->integer('price_rel')->default(2);
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('city_id')->references('id')->on('catalog_city')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_users_catalog_company');
        Schema::dropIfExists('catalog_company');
    }
}
