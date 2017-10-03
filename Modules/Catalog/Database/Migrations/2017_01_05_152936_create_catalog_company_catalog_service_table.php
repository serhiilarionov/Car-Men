<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCompanyCatalogServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_company_catalog_service', function (Blueprint $table) {
            $table->integer('company_id');
            $table->integer('service_id');
            $table->foreign('company_id')->references('id')->on('catalog_company')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('catalog_service')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_company_catalog_service');
    }
}
