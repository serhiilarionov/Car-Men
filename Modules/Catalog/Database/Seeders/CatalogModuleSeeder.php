<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CatalogCityTableSeeder::class);
        $this->call(CatalogComfortTableSeeder::class);
        $this->call(CatalogCategoryTableSeeder::class);
        $this->call(CatalogCompanyTableSeeder::class);
        $this->call(CatalogCategoryCityTableSeeder::class);
        //$this->call(CatalogComfortCatalogCompanyTableSeeder::class);
        $this->call(CatalogCategoryCatalogCompanyTableSeeder::class);
        $this->call(CatalogCompanyDetailTableSeeder::class);

        $this->call(CatalogServiceTableSeeder::class);
        $this->call(CatalogCompanyRatingTableSeeder::class);
        $this->call(CatalogParserJsonSeeder::class);
    }
}
