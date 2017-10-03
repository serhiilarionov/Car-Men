<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCategoryCatalogCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_category_catalog_company')->delete();

        /*\DB::table('catalog_category_catalog_company')->insert([
            [
                'company_id' => 1,
                'category_id' => 1
            ],
            [
                'company_id' => 1,
                'category_id' => 2
            ],
            [
                'company_id' => 1,
                'category_id' => 3
            ],
            [
                'company_id' => 2,
                'category_id' => 1
            ],
            [
                'company_id' => 3,
                'category_id' => 2
            ],
            [
                'company_id' => 4,
                'category_id' => 3
            ],
            [
                'company_id' => 5,
                'category_id' => 3
            ],
            [
                'company_id' => 6,
                'category_id' => 3
            ],
            [
                'company_id' => 7,
                'category_id' => 4
            ],
            [
                'company_id' => 8,
                'category_id' => 4
            ],
            [
                'company_id' => 9,
                'category_id' => 4
            ],
            [
                'company_id' => 10,
                'category_id' => 2
            ],
            [
                'company_id' => 11,
                'category_id' => 1
            ],
            [
                'company_id' => 12,
                'category_id' => 1
            ],
            [
                'company_id' => 13,
                'category_id' => 1
            ],
            [
                'company_id' => 14,
                'category_id' => 1
            ],
            [
                'company_id' => 15,
                'category_id' => 1
            ],
            [
                'company_id' => 16,
                'category_id' => 1
            ],
            [
                'company_id' => 17,
                'category_id' => 1
            ],
            [
                'company_id' => 18,
                'category_id' => 1
            ],
            [
                'company_id' => 19,
                'category_id' => 1
            ],
            [
                'company_id' => 20,
                'category_id' => 1
            ],
            [
                'company_id' => 21,
                'category_id' => 1
            ],
            [
                'company_id' => 22,
                'category_id' => 1
            ],
            [
                'company_id' => 23,
                'category_id' => 1
            ],
            [
                'company_id' => 24,
                'category_id' => 1
            ],
            [
                'company_id' => 25,
                'category_id' => 1
            ],
            [
                'company_id' => 26,
                'category_id' => 1
            ],
            [
                'company_id' => 27,
                'category_id' => 1
            ],
            [
                'company_id' => 28,
                'category_id' => 1
            ],
            [
                'company_id' => 29,
                'category_id' => 1
            ],
            [
                'company_id' => 30,
                'category_id' => 1
            ],
            [
                'company_id' => 31,
                'category_id' => 1
            ],
            [
                'company_id' => 32,
                'category_id' => 1
            ],
            [
                'company_id' => 33,
                'category_id' => 1
            ],
            [
                'company_id' => 34,
                'category_id' => 1
            ],
            [
                'company_id' => 35,
                'category_id' => 1
            ],
            [
                'company_id' => 36,
                'category_id' => 1
            ],
            [
                'company_id' => 37,
                'category_id' => 1
            ],
            [
                'company_id' => 38,
                'category_id' => 1
            ],
            [
                'company_id' => 39,
                'category_id' => 1
            ],
            [
                'company_id' => 40,
                'category_id' => 1
            ],
            [
                'company_id' => 41,
                'category_id' => 1
            ],
            [
                'company_id' => 42,
                'category_id' => 1
            ],
            [
                'company_id' => 43,
                'category_id' => 1
            ],
            [
                'company_id' => 44,
                'category_id' => 1
            ],
            [
                'company_id' => 45,
                'category_id' => 1
            ],
            [
                'company_id' => 46,
                'category_id' => 1
            ],
            [
                'company_id' => 47,
                'category_id' => 1
            ],
            [
                'company_id' => 48,
                'category_id' => 1
            ],
            [
                'company_id' => 49,
                'category_id' => 1
            ],
            [
                'company_id' => 50,
                'category_id' => 1
            ],
            [
                'company_id' => 51,
                'category_id' => 1
            ],
            [
                'company_id' => 52,
                'category_id' => 1
            ],
            [
                'company_id' => 53,
                'category_id' => 1
            ],
            [
                'company_id' => 54,
                'category_id' => 1
            ],
            [
                'company_id' => 55,
                'category_id' => 1
            ],
            [
                'company_id' => 56,
                'category_id' => 1
            ],
            [
                'company_id' => 57,
                'category_id' => 1
            ],
            [
                'company_id' => 58,
                'category_id' => 1
            ],
            [
                'company_id' => 59,
                'category_id' => 1
            ],
            [
                'company_id' => 60,
                'category_id' => 1
            ],
            [
                'company_id' => 61,
                'category_id' => 1
            ],
            [
                'company_id' => 62,
                'category_id' => 1
            ],
            [
                'company_id' => 63,
                'category_id' => 1
            ]
        ]);*/

        $path = 'Modules/Catalog/Database/Seeders/carmen_public_catalog_category_catalog_company.sql';
        \DB::unprepared(file_get_contents($path));
    }
}
