<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        \DB::statement('TRUNCATE catalog_city CASCADE');
        
        \DB::table('catalog_city')->delete();

        \DB::table('catalog_city')->insert([
            [
                'id' => 1,
                'name' => 'Кривой Рог',
                'point' => '33.391783 47.910483',
                'bound' => '33.134698, 47.637942, 33.598335, 48.176781',
                'active' => 1,
            ],
            [
                'id' => 2,
                'name' => 'Днепр',
                'point' => '35.046183 48.464717',
                'bound' => '34.757975, 48.355729, 35.242738, 48.568868',
                'active' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Киев',
                'point' => '30.5234 50.4501',
                'bound' => '30.2394401, 50.213273, 30.82594, 50.5907981',
                'active' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Львов',
                'point' => '30.5234 50.4501',
                'bound' => '30.2394401, 50.213273, 30.82594, 50.5907981',
                'active' => 1,
            ],
            [
                'id' => 5,
                'name' => 'Одесса',
                'point' => '30.5234 50.4501',
                'bound' => '30.2394401, 50.213273, 30.82594, 50.5907981',
                'active' => 1,
            ],
            [
                'id' => 6,
                'name' => 'Харьков',
                'point' => '30.5234 50.4501',
                'bound' => '30.2394401, 50.213273, 30.82594, 50.5907981',
                'active' => 1,
            ],
        ]);

        \DB::unprepared("select setval('catalog_city_id_seq', (select max(id) + 1 from catalog_city));");
    }
}
