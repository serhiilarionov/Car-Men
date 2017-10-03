<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogComfortCatalogCompanyTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('catalog_comfort_catalog_company', function (Blueprint $table) {
      $table->integer('company_id')->unsigned()->nullable()->default(null);
      $table->integer('comfort_id')->unsigned()->nullable()->default(null);

      $table->foreign('company_id')->references('id')->on('catalog_company')->onDelete('cascade');
      $table->foreign('comfort_id')->references('id')->on('catalog_comfort')->onDelete('cascade');

      $table->primary(['company_id', 'comfort_id']);
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('catalog_comfort_catalog_company');
  }
}
