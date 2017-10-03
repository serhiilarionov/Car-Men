<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCompanyRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalog_company_rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('user_id')->nullable();
            $table->string('display_name')->nullable();
            $table->string('title')->nullable();
            $table->text('text')->nullable();
            $table->float('total_rating')->nullable();
            $table->tinyInteger('price_rel')->nullable();
            $table->string('answer_name')->nullable();
            $table->text('answer_text')->nullable();
            $table->dateTime('answer_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('catalog_company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('catalog_company_rating');
    }
}
