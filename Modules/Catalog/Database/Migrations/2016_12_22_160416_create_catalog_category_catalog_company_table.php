<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCatalogCategoryCatalogCompanyTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('catalog_category_catalog_company', function (Blueprint $table) {
			$table->integer('category_id')->nullable()->default(null)->unsigned();
			$table->foreign('category_id')->references('id')->on('catalog_category')
				->onUpdate('cascade')->onDelete('cascade');
			$table->integer('company_id')->nullable()->default(null)->unsigned();
			$table->foreign('company_id')->references('id')->on('catalog_company')
				->onUpdate('cascade')->onDelete('cascade');

			$table->primary(['category_id', 'company_id'])->unigue();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('catalog_category_catalog_company');
	}
}
