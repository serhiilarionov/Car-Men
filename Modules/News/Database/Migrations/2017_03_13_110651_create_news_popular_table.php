<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsPopularTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_articles_popular', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id');
            $table->timestamp('last_date');
            $table->timestamp('publication_date');
            $table->integer('total');

            $table->foreign('article_id')->references('id')->on('news_articles')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_articles_popular');
    }
}
