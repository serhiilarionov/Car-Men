<?php

namespace Modules\Catalog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogComfortCatalogCompanyTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

    \DB::table('catalog_comfort_catalog_company')->delete();

    \DB::table('catalog_comfort_catalog_company')->insert([
      [
        'company_id' => 1,
        'comfort_id' => 1
      ],
      [
        'company_id' => 1,
        'comfort_id' => 2
      ],
      [
        'company_id' => 1,
        'comfort_id' => 3
      ],
      [
        'company_id' => 1,
        'comfort_id' => 4
      ],
      [
        'company_id' => 2,
        'comfort_id' => 1
      ],
      [
        'company_id' => 2,
        'comfort_id' => 2
      ],
      [
        'company_id' => 2,
        'comfort_id' => 3
      ],
      [
        'company_id' => 2,
        'comfort_id' => 4
      ],
    ]);
  }
}
