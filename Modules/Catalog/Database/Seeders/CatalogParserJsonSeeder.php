<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogParserJsonSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
        
    \DB::table('parse_company_json_data')->delete();

    $path = 'Modules/Catalog/Database/Seeders/carmen_public_parse_company_json_data.sql';
    \DB::unprepared(file_get_contents($path));
  }
}
