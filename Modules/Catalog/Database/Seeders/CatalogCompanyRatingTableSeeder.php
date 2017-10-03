<?php

namespace Modules\Catalog\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCompanyRatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_company_rating_category')->delete();
        \DB::table('catalog_company_rating')->delete();

        \DB::table('catalog_company_rating')->insert([
            [
                'id' => 1,
                'company_id' => 9939,
                'user_id' => 1,
                'display_name' => 'Михаил',
                'title' => 'Отличное место',
                'text' => 'Был несколько раз, все на высшем уровне!',
                'total_rating' => 5,
                'price_rel' => 2,
                'answer_name' => 'Администрация',
                'answer_text' => 'Приезжайте еще, будем всегда рады.',
                'answer_date' => '2017-01-15 12:23:32',
                'created_at' => '2017-01-13 11:27:11',
                'updated_at' => '2017-01-15 12:23:32',
            ],
            [
                'id' => 2,
                'company_id' => 9939,
                'user_id' => 2,
                'display_name' => 'Николай Иванович',
                'title' => 'Бывает и лучше',
                'text' => 'Есть определенные проблемы над которыми нужно поработать.',
                'total_rating' => 3,
                'price_rel' => 3,
                'answer_name' => null,
                'answer_text' => null,
                'answer_date' => null,
                'created_at' => '2017-01-12 15:17:19',
                'updated_at' => '2017-01-12 15:17:19',
            ],
            [
                'id' => 3,
                'company_id' => 10029,
                'user_id' => 1,
                'display_name' => 'Михаил',
                'title' => 'Приеду еще раз',
                'text' => 'Профессионализм на высшем уровне. Далеко и неудобно добираться. Цены очень высокиею',
                'total_rating' => 4,
                'price_rel' => 4,
                'answer_name' => 'Руководство компании',
                'answer_text' => 'Спасибо за отзыв. Цена соответсвует качеству.',
                'answer_date' => '2017-01-16 17:32:45',
                'created_at' => '2017-01-10 10:12:26',
                'updated_at' => '2017-01-15 12:23:32',
            ],
        ]);

        \DB::unprepared("select setval('catalog_company_rating_id_seq', (select max(id) + 1 from catalog_company_rating));");

        \DB::table('catalog_company_rating_category')->insert([
            [
                'company_rating_id' => 1,
                'category_id' => 32,
                'rating' => 4,
            ],
            [
                'company_rating_id' => 1,
                'category_id' => 1,
                'rating' => 5,
            ],
            [
                'company_rating_id' => 1,
                'category_id' => 2,
                'rating' => 2,
            ],
            [
                'company_rating_id' => 2,
                'category_id' => 1,
                'rating' => 5,
            ],
        ]);
        \DB::unprepared("select setval('catalog_company_rating_category_id_seq', (select max(id) + 1 from catalog_company_rating_category));");
    }
}
