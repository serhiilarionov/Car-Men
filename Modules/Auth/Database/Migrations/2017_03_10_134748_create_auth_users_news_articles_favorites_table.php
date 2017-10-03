<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthUsersNewsArticlesFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_users_news_articles_favorites', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->foreign('user_id')->references('id')->on('auth_users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('article_id')->nullable()->default(null)->unsigned();
            $table->foreign('article_id')->references('id')->on('news_articles')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['user_id', 'article_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_users_news_articles_favorites');
    }
}
