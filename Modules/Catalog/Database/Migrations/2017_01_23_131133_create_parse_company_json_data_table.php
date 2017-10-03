<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParseCompanyJsonDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parse_company_json_data', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_id')->unique();
            $table->integer('city_id');
            $table->jsonb('category_id');
            $table->string('status', 10)->default('wait');
            $table->jsonb('info')->nullable();
            $table->jsonb('gallery')->nullable();
            $table->string('parse_status', 10)->default('wait');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parse_company_json_data');
    }
}
