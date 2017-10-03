<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogComfortTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_comfort')->delete();

        \DB::table('catalog_comfort')->insert([

            [
                'id' => 1,
                'name' => 'Кафе',            
                'image' => ''            
            ],
            [
                'id' => 2,
                'name' => 'Гостиница',
                'image' => ''
            ],
            [
                'id' => 3,
                'name' => 'Питьевая вода',
                'image' => ''          
            ],
            [
                'id' => 4,
                'name' => 'Зарядка мобильных устройств',
                'image' => ''
            ],
            [
                'id' => 5,
                'name' => 'Банкомат',
                'image' => ''
            ],
            [
                'id' => 6,
                'name' => 'Магазин',
                'image' => ''
            ],
            [
                'id' => 7,
                'name' => 'Туалет',
                'image' => ''
            ],
            [
                'id' => 8,
                'name' => 'Wi-Fi',
                'image' => ''
            ],
            [
                'id' => 9,
                'name' => 'Аптечный пункт',
                'image' => ''
            ],
            [
                'id' => 10,
                'name' => 'Душ',
                'image' => ''
            ]
        ]);

        \DB::unprepared("select setval('catalog_comfort_id_seq', (select max(id) + 1 from catalog_comfort));");
    }
}
