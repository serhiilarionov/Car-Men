<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_category')->delete();

        \DB::table('catalog_category')->insert([
            [
                'id' => 1,
                'name' => 'СТО',
                'parent_id' => null,
                'active' => 1
            ],
            [
                'id' => 2,
                'name' => 'Двигатель',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 3,
                'name' => 'Коробка передач',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 4,
                'name' => 'Ходовая',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 5,
                'name' => 'Кузовной ремонт',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 6,
                'name' => 'Электрооборудование',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 7,
                'name' => 'Техобслуживание',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 8,
                'name' => 'Тюнинг',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 9,
                'name' => 'ГБО',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 42,
                'name' => 'Другое',
                'parent_id' => 1,
                'active' => 1
            ],
            [
                'id' => 10,
                'name' => 'Автомойки',
                'parent_id' => null,
                'active' => 1
            ],
            /*[
                'id' => 11,
                'name' => 'Автоматическая мойка',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 12,
                'name' => 'Бесконтактная мойка',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 13,
                'name' => 'Ручная мойка',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 14,
                'name' => 'Химчистка',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 15,
                'name' => 'Мойка двигателя',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 16,
                'name' => 'Защитная полировка',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 17,
                'name' => 'Мойка днища',
                'parent_id' => 10,
                'active' => 1
            ],
            [
                'id' => 43,
                'name' => 'Другое',
                'parent_id' => 10,
                'active' => 1
            ],*/
            [
                'id' => 18,
                'name' => 'Шиномонтаж',
                'parent_id' => null,
                'active' => 1
            ],
            /*[
                'id' => 19,
                'name' => 'Выездной шиномонтаж',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 20,
                'name' => 'Грузовой шиномонтаж',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 21,
                'name' => 'Балансировка',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 22,
                'name' => 'Ремонт дисков',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 23,
                'name' => 'Ремонт шин',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 24,
                'name' => 'Хранение шин',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 25,
                'name' => 'Для мототехники',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 26,
                'name' => 'Ошиповка',
                'parent_id' => 18,
                'active' => 1
            ],
            [
                'id' => 44,
                'name' => 'Другое',
                'parent_id' => 18,
                'active' => 1
            ],*/
            [
                'id' => 27,
                'name' => 'Автостоянки',
                'parent_id' => null,
                'active' => 1
            ],
            /*[
                'id' => 28,
                'name' => 'Многоуровневые',
                'parent_id' => 27,
                'active' => 1
            ],
            [
                'id' => 29,
                'name' => 'Надземные',
                'parent_id' => 27,
                'active' => 1
            ],
            [
                'id' => 30,
                'name' => 'Подземные',
                'parent_id' => 27,
                'active' => 1
            ],
            [
                'id' => 31,
                'name' => 'Стоянки для инвалидов',
                'parent_id' => 27,
                'active' => 1
            ],
            [
                'id' => 45,
                'name' => 'Другое',
                'parent_id' => 27,
                'active' => 1
            ],
            */
            [
                'id' => 32,
                'name' => 'АЗС',
                'parent_id' => null,
                'active' => 1
            ],
            /*[
                'id' => 33,
                'name' => 'ДТ',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 34,
                'name' => '80',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 35,
                'name' => '92',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 36,
                'name' => '95',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 37,
                'name' => '98',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 38,
                'name' => 'Пропан',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 39,
                'name' => 'Метан',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 40,
                'name' => 'Станция зарядки электротранспора',
                'parent_id' => 32,
                'active' => 1
            ],
            [
                'id' => 46,
                'name' => 'Другое',
                'parent_id' => 32,
                'active' => 1
            ],*/
            [
                'id' => 41,
                'name' => 'Автомагазины',
                'parent_id' => null,
                'active' => 1
            ],
            /*[
                'id' => 47,
                'name' => 'Другое',
                'parent_id' => 41,
                'active' => 1
            ],*/

        ]);

        \DB::unprepared("select setval('catalog_category_id_seq', (select max(id) + 1 from catalog_category));");
    }
}
