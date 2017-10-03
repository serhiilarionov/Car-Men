<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AuthModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AuthUsersTableSeeder::class);
        //$this->call(AuthUsersCatalogCompanyTableSeeder::class);
        $this->call(AuthUserShowLogSeeder::class);
    }
}
