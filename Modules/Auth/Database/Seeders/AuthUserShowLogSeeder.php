<?php

namespace Modules\Auth\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Catalog\Entities\Company;

class AuthUserShowLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('auth_user_show_log')->delete();
        // seed make for actuality companies
        $insertData = [];
        $actualCompanies = Company::limit(10)->get();
        foreach ($actualCompanies as $company){
            for ($i=1; $i<=random_int(4, 10); $i++){
                $insertData[] = [
                    'entity' => 'Modules\Catalog\Entities\Company',
                    'entity_id' => $company->id,
                    'user_id' => random_int(1, 2),
                    'created_at' => Carbon::now(),
                ];
            }
        }


        \DB::table('auth_user_show_log')->insert($insertData);

        \DB::unprepared("select setval('auth_user_show_log_id_seq', (select max(id) + 1 from auth_user_show_log));");
    }
}
