<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_service')->delete();

        \DB::table('catalog_service')->insert([

            [
                'id' => 1,
                'name' => 'Ремонт бензиновых двигателей',
                'category_id' => 2
            ],
            [
                'id' => 2,
                'name' => 'Ремонт дизельных двигателей',
                'category_id' => 2
            ],
            [
                'id' => 3,
                'name' => 'Ремонт топливной аппаратуры дизельных двигателей',
                'category_id' => 2
            ],
            [
                'id' => 4,
                'name' => 'Ремонт выхлопных систем',
                'category_id' => 2
            ],
            [
                'id' => 5,
                'name' => 'Ремонт карбюраторов / инжекторов',
                'category_id' => 2
            ],
            [
                'id' => 6,
                'name' => 'Ремонт АКПП',
                'category_id' => 3
            ],
            [
                'id' => 7,
                'name' => 'Ремонт МКПП',
                'category_id' => 3
            ],
            [
                'id' => 8,
                'name' => 'Развал / Схождение',
                'category_id' => 4
            ],
            [
                'id' => 9,
                'name' => 'Ремонт ходовой части автомобиля',
                'category_id' => 4
            ],
            [
                'id' => 10,
                'name' => 'Кузовной ремонт',
                'category_id' => 5
            ],
            [
                'id' => 11,
                'name' => 'Антикоррозийная обработка автомобилей',
                'category_id' => 5
            ],
            [
                'id' => 12,
                'name' => 'Ремонт автоэлектрики',
                'category_id' => 6
            ],
            [
                'id' => 13,
                'name' => 'Компьютерная диагностика автомобилей',
                'category_id' => 6
            ],
            [
                'id' => 14,
                'name' => 'Ремонт / обслуживание климатических систем автомобиля',
                'category_id' => 6
            ],
            [
                'id' => 15,
                'name' => 'Автосигнализации',
                'category_id' => 6
            ],
            [
                'id' => 16,
                'name' => 'Установка / ремонт автомобильной оптики',
                'category_id' => 6
            ],
            [
                'id' => 17,
                'name' => 'Установка / ремонт автостёкол',
                'category_id' => 7
            ],
            [
                'id' => 18,
                'name' => 'Технический осмотр транспорта',
                'category_id' => 7
            ],
            [
                'id' => 19,
                'name' => 'Аппаратная замена масла',
                'category_id' => 7
            ],
            [
                'id' => 20,
                'name' => 'Тонирование автостёкол',
                'category_id' => 8
            ],
            [
                'id' => 21,
                'name' => 'Тюнинг',
                'category_id' => 8
            ],
            [
                'id' => 22,
                'name' => 'Газовое оборудование для автотранспорта',
                'category_id' => 9
            ],
            [
                'id' => 23,
                'name' => 'Автоматическая мойка',
                'category_id' => 10
            ],
            [
                'id' => 24,
                'name' => 'Бесконтактная мойка',
                'category_id' => 10
            ],
            [
                'id' => 25,
                'name' => 'Ручная мойка',
                'category_id' => 10
            ],
            [
                'id' => 26,
                'name' => 'Химчистка',
                'category_id' => 10
            ],
            [
                'id' => 27,
                'name' => 'Мойка двигателя',
                'category_id' => 10
            ],
            [
                'id' => 28,
                'name' => 'Защитная полировка',
                'category_id' => 10
            ],
            [
                'id' => 29,
                'name' => 'Мойка днища',
                'category_id' => 10
            ],
            [
                'id' => 30,
                'name' => 'Выездной шиномонтаж',
                'category_id' => 18
            ],
            [
                'id' => 31,
                'name' => 'Грузовой шиномонтаж',
                'category_id' => 18
            ],
            [
                'id' => 32,
                'name' => 'Балансировка',
                'category_id' => 18
            ],
            [
                'id' => 33,
                'name' => 'Ремонт дисков',
                'category_id' => 18
            ],
            [
                'id' => 34,
                'name' => 'Ремонт шин',
                'category_id' => 18
            ],
            [
                'id' => 35,
                'name' => 'Хранение шин',
                'category_id' => 18
            ],
            [
                'id' => 36,
                'name' => 'Для мототехники',
                'category_id' => 18
            ],
            [
                'id' => 37,
                'name' => 'Ошиповка',
                'category_id' => 18
            ],
            [
                'id' => 38,
                'name' => 'Многоуровневые',
                'category_id' => 27
            ],
            [
                'id' => 39,
                'name' => 'Надземные',
                'category_id' => 27
            ],
            [
                'id' => 40,
                'name' => 'Подземные',
                'category_id' => 27
            ],
            [
                'id' => 41,
                'name' => 'Стоянки для инвалидов',
                'category_id' => 27
            ],
            [
                'id' => 42,
                'name' => 'ДТ',
                'category_id' => 32
            ],
            [
                'id' => 43,
                'name' => '80',
                'category_id' => 32
            ],
            [
                'id' => 44,
                'name' => '92',
                'category_id' => 32
            ],
            [
                'id' => 45,
                'name' => '95',
                'category_id' => 32
            ],
            [
                'id' => 46,
                'name' => '98',
                'category_id' => 32
            ],
            [
                'id' => 47,
                'name' => 'пропан',
                'category_id' => 32
            ],
            [
                'id' => 48,
                'name' => 'метан',
                'category_id' => 32
            ],
            [
                'id' => 49,
                'name' => 'станция зарядки электротранспорта',
                'category_id' => 32
            ],
            [
                'id' => 50,
                'name' => 'Автозапчасти для легковых автомобилей',
                'category_id' => 41
            ],
            [
                'id' => 51,
                'name' => 'Автозапчасти для грузовых автомобилей',
                'category_id' => 41
            ],
            [
                'id' => 52,
                'name' => 'Контрактные автозапчасти',
                'category_id' => 41
            ],
            [
                'id' => 53,
                'name' => 'Запчасти для общественного транспорта',
                'category_id' => 41
            ],
            [
                'id' => 54,
                'name' => 'Запчасти для спецтехники',
                'category_id' => 41
            ],
            [
                'id' => 55,
                'name' => 'Автоаксессуары',
                'category_id' => 41
            ],
            [
                'id' => 56,
                'name' => 'Шины / Диски',
                'category_id' => 41
            ],
            [
                'id' => 57,
                'name' => 'Автомасла / Мотомасла / Химия',
                'category_id' => 41
            ],
            [
                'id' => 58,
                'name' => 'Автозвук',
                'category_id' => 41
            ],
            [
                'id' => 59,
                'name' => 'Автомобильные аккумуляторы',
                'category_id' => 41
            ],
            [
                'id' => 60,
                'name' => 'Специализированное автооборудование',
                'category_id' => 41
            ],
            [
                'id' => 61,
                'name' => 'Автостекло',
                'category_id' => 41
            ],
            [
                'id' => 62,
                'name' => 'Автоэмали',
                'category_id' => 41
            ],
            [
                'id' => 63,
                'name' => 'Запчасти для мототехники',
                'category_id' => 41
            ],
            [
                'id' => 64,
                'name' => 'Тонировочные / защитные плёнки для автомобилей',
                'category_id' => 41
            ],
        ]);

        \DB::unprepared("select setval('catalog_service_id_seq', (select max(id) + 1 from catalog_service));");
    }


}
