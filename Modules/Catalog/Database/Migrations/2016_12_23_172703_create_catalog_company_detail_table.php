<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCompanyDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_company_detail', function (Blueprint $table) {
            $table->jsonb('phones')->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();
            $table->jsonb('work_time')->nullable();
            $table->string('desc', 2000)->nullable();
            $table->jsonb('payment')->nullable();
            $table->integer('company_id')->unsigned()->nullable();
            $table->foreign('company_id')->references('id')->on('catalog_company')->onDelete('cascade');
            $table->primary('company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_company_detail');
    }
}
