<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthUsersCatalogCompanyTable extends Migration
{
    /**
     * Run the migrations.
     * Pivot table for favorites
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users_catalog_company', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->foreign('user_id')->references('id')->on('auth_users')
              ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('company_id')->nullable()->default(null)->unsigned();
            $table->foreign('company_id')->references('id')->on('catalog_company')
              ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'company_id']);
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
    }
}
