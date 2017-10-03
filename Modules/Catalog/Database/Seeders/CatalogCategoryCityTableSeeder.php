<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCategoryCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        \DB::table('catalog_category_catalog_city')->delete();

        \DB::table('catalog_category_catalog_city')->insert([
            [
                'category_id' => '1',
                'city_id' => '1'
            ],
            [
                'category_id' => '2',
                'city_id' => '1'
            ],
            [
                'category_id' => '3',
                'city_id' => '1'
            ],
            [
                'category_id' => '4',
                'city_id' => '1'
            ],
            [
                'category_id' => '5',
                'city_id' => '1'
            ],
        ]);
    }
}
