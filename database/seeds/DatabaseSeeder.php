<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(\Modules\Catalog\Database\Seeders\CatalogModuleSeeder::class);
         $this->call(\Modules\Auth\Database\Seeders\AuthModuleSeeder::class);
    }
}
