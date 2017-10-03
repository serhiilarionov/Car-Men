<?php

namespace Modules\Catalog\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Phaza\LaravelPostgis\Geometries\Point;

class CatalogCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_company')->delete();
        
        $path = 'Modules/Catalog/Database/Seeders/carmen_public_catalog_company.sql';
        \DB::unprepared(file_get_contents($path));

        \DB::unprepared("select setval('catalog_company_id_seq', (select max(id) + 1 from catalog_company));");
    }
}
