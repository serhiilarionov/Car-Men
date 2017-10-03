<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AuthUsersCatalogCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        \DB::table('auth_users_catalog_company')->delete();

        \DB::table('auth_users_catalog_company')->insert([
          [
            'company_id' => 1,
            'user_id' => 1
          ],
          [
            'company_id' => 2,
            'user_id' => 1
          ],
          [
            'company_id' => 3,
            'user_id' => 2
          ],
          [
            'company_id' => 4,
            'user_id' => 1
          ],
          [
            'company_id' => 5,
            'user_id' => 2
          ],
          [
            'company_id' => 6,
            'user_id' => 2
          ],
          [
            'company_id' => 7,
            'user_id' => 1
          ],
          [
            'company_id' => 8,
            'user_id' => 1
          ],
          [
            'company_id' => 9,
            'user_id' => 2
          ],
          [
            'company_id' => 10,
            'user_id' => 2
          ],
          [
            'company_id' => 11,
            'user_id' => 1
          ],
          [
            'company_id' => 12,
            'user_id' => 2
          ],
        ]);
    }
}
