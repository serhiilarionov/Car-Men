<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsSourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_sources', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        DB::table('news_sources')->insert([
          [
            'id' => 1,
            'name' => 'Автоцентр'
          ],
          [
            'id' => 2,
            'name' => 'Автоконсалтинг'
          ],
        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_sources');
    }
}
