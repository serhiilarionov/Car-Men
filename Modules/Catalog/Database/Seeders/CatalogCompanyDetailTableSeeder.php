<?php

namespace Modules\Catalog\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CatalogCompanyDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        \DB::table('catalog_company_detail')->delete();

        /*\DB::table('catalog_company_detail')->insert([
            [
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 1
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 2
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 3
            ],
            [
                'phones' => json_encode(['6655443322', '6655443322']),
                'email' => 'Kober@gmail.com',
                'website' => 'Kober.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Kober',
                'company_id' => 4
            ],
            [
                'phones' => json_encode(['6545465478', '2326587965']),
                'email' => 'Colobok@gmail.com',
                'website' => 'Colobok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Colobok',
                'company_id' => 5
            ],
            [
                'phones' => json_encode(['8765634532', '9898765523']),
                'email' => 'Koboloc@gmail.com',
                'website' => 'Koboloc.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Koboloc',
                'company_id' => 6
            ],
            [
                'phones' => json_encode(['5436786578', '3324599879']),
                'email' => 'Aspect@gmail.com',
                'website' => 'Aspect.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 7
            ],
            [
                'phones' => json_encode(['7655674343', '8877698743']),
                'email' => 'Inter@gmail.com',
                'website' => 'Inter.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 8
            ],
            [
                'phones' => json_encode(['3324453654', '9986745463']),
                'email' => 'Megaton@gmail.com',
                'website' => 'Megaton.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Megaton',
                'company_id' => 9
            ],
            [
                'phones' => json_encode(['9897762322', '5466734123']),
                'email' => 'AIS@gmail.com',
                'website' => 'AIS.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'AIS',
                'company_id' => 10
            ],
            [
                'phones' => json_encode(['5455664323', '3244327688']),
                'email' => 'Autogaz@gmail.com',
                'website' => 'Autogaz.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autogaz',
                'company_id' => 11
            ],
            [
                'phones' => json_encode(['9900675646', '7754712332']),
                'email' => 'Autoglass@gmail.com',
                'website' => 'Autoglass.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autoglass',
                'company_id' => 12
            ],[
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 13
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 14
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 15
            ],
            [
                'phones' => json_encode(['6655443322', '6655443322']),
                'email' => 'Kober@gmail.com',
                'website' => 'Kober.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Kober',
                'company_id' => 16
            ],
            [
                'phones' => json_encode(['6545465478', '2326587965']),
                'email' => 'Colobok@gmail.com',
                'website' => 'Colobok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Colobok',
                'company_id' => 17
            ],
            [
                'phones' => json_encode(['8765634532', '9898765523']),
                'email' => 'Koboloc@gmail.com',
                'website' => 'Koboloc.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Koboloc',
                'company_id' => 18
            ],
            [
                'phones' => json_encode(['5436786578', '3324599879']),
                'email' => 'Aspect@gmail.com',
                'website' => 'Aspect.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 19
            ],
            [
                'phones' => json_encode(['7655674343', '8877698743']),
                'email' => 'Inter@gmail.com',
                'website' => 'Inter.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 20
            ],
            [
                'phones' => json_encode(['3324453654', '9986745463']),
                'email' => 'Megaton@gmail.com',
                'website' => 'Megaton.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Megaton',
                'company_id' => 21
            ],
            [
                'phones' => json_encode(['9897762322', '5466734123']),
                'email' => 'AIS@gmail.com',
                'website' => 'AIS.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'AIS',
                'company_id' => 22
            ],
            [
                'phones' => json_encode(['5455664323', '3244327688']),
                'email' => 'Autogaz@gmail.com',
                'website' => 'Autogaz.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autogaz',
                'company_id' => 23
            ],
            [
                'phones' => json_encode(['9900675646', '7754712332']),
                'email' => 'Autoglass@gmail.com',
                'website' => 'Autoglass.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autoglass',
                'company_id' => 24
            ],[
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 25
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 26
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 27
            ],
            [
                'phones' => json_encode(['6655443322', '6655443322']),
                'email' => 'Kober@gmail.com',
                'website' => 'Kober.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Kober',
                'company_id' => 28
            ],
            [
                'phones' => json_encode(['6545465478', '2326587965']),
                'email' => 'Colobok@gmail.com',
                'website' => 'Colobok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Colobok',
                'company_id' => 29
            ],
            [
                'phones' => json_encode(['8765634532', '9898765523']),
                'email' => 'Koboloc@gmail.com',
                'website' => 'Koboloc.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Koboloc',
                'company_id' => 30
            ],
            [
                'phones' => json_encode(['5436786578', '3324599879']),
                'email' => 'Aspect@gmail.com',
                'website' => 'Aspect.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 31
            ],
            [
                'phones' => json_encode(['7655674343', '8877698743']),
                'email' => 'Inter@gmail.com',
                'website' => 'Inter.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 32
            ],
            [
                'phones' => json_encode(['3324453654', '9986745463']),
                'email' => 'Megaton@gmail.com',
                'website' => 'Megaton.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Megaton',
                'company_id' => 33
            ],
            [
                'phones' => json_encode(['9897762322', '5466734123']),
                'email' => 'AIS@gmail.com',
                'website' => 'AIS.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'AIS',
                'company_id' => 34
            ],
            [
                'phones' => json_encode(['5455664323', '3244327688']),
                'email' => 'Autogaz@gmail.com',
                'website' => 'Autogaz.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autogaz',
                'company_id' => 35
            ],
            [
                'phones' => json_encode(['9900675646', '7754712332']),
                'email' => 'Autoglass@gmail.com',
                'website' => 'Autoglass.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autoglass',
                'company_id' => 36
            ],
            [
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 37
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 38
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 39
            ],
            [
                'phones' => json_encode(['6655443322', '6655443322']),
                'email' => 'Kober@gmail.com',
                'website' => 'Kober.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Kober',
                'company_id' => 40
            ],
            [
                'phones' => json_encode(['6545465478', '2326587965']),
                'email' => 'Colobok@gmail.com',
                'website' => 'Colobok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Colobok',
                'company_id' => 41
            ],
            [
                'phones' => json_encode(['8765634532', '9898765523']),
                'email' => 'Koboloc@gmail.com',
                'website' => 'Koboloc.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Koboloc',
                'company_id' => 42
            ],
            [
                'phones' => json_encode(['5436786578', '3324599879']),
                'email' => 'Aspect@gmail.com',
                'website' => 'Aspect.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 43
            ],
            [
                'phones' => json_encode(['7655674343', '8877698743']),
                'email' => 'Inter@gmail.com',
                'website' => 'Inter.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 44
            ],
            [
                'phones' => json_encode(['3324453654', '9986745463']),
                'email' => 'Megaton@gmail.com',
                'website' => 'Megaton.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Megaton',
                'company_id' => 45
            ],
            [
                'phones' => json_encode(['9897762322', '5466734123']),
                'email' => 'AIS@gmail.com',
                'website' => 'AIS.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'AIS',
                'company_id' => 46
            ],
            [
                'phones' => json_encode(['5455664323', '3244327688']),
                'email' => 'Autogaz@gmail.com',
                'website' => 'Autogaz.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autogaz',
                'company_id' => 47
            ],
            [
                'phones' => json_encode(['9900675646', '7754712332']),
                'email' => 'Autoglass@gmail.com',
                'website' => 'Autoglass.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autoglass',
                'company_id' => 48
            ],[
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 49
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 50
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 51
            ],
            [
                'phones' => json_encode(['6655443322', '6655443322']),
                'email' => 'Kober@gmail.com',
                'website' => 'Kober.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Kober',
                'company_id' => 52
            ],
            [
                'phones' => json_encode(['6545465478', '2326587965']),
                'email' => 'Colobok@gmail.com',
                'website' => 'Colobok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Colobok',
                'company_id' => 53
            ],
            [
                'phones' => json_encode(['8765634532', '9898765523']),
                'email' => 'Koboloc@gmail.com',
                'website' => 'Koboloc.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Koboloc',
                'company_id' => 54
            ],
            [
                'phones' => json_encode(['5436786578', '3324599879']),
                'email' => 'Aspect@gmail.com',
                'website' => 'Aspect.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 55
            ],
            [
                'phones' => json_encode(['7655674343', '8877698743']),
                'email' => 'Inter@gmail.com',
                'website' => 'Inter.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Aspect',
                'company_id' => 56
            ],
            [
                'phones' => json_encode(['3324453654', '9986745463']),
                'email' => 'Megaton@gmail.com',
                'website' => 'Megaton.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Megaton',
                'company_id' => 57
            ],
            [
                'phones' => json_encode(['9897762322', '5466734123']),
                'email' => 'AIS@gmail.com',
                'website' => 'AIS.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'AIS',
                'company_id' => 58
            ],
            [
                'phones' => json_encode(['5455664323', '3244327688']),
                'email' => 'Autogaz@gmail.com',
                'website' => 'Autogaz.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autogaz',
                'company_id' => 59
            ],
            [
                'phones' => json_encode(['9900675646', '7754712332']),
                'email' => 'Autoglass@gmail.com',
                'website' => 'Autoglass.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Autoglass',
                'company_id' => 60
            ],[
                'phones' => json_encode(['1233211234', '1233211234']),
                'email' => 'EuroStyle@gmail.com',
                'website' => 'EuroStyle.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'EuroStyle',
                'company_id' => 61
            ],
            [
                'phones' => json_encode(['0111233210', '0111233210']),
                'email' => 'Adidos@gmail.com',
                'website' => 'Adidos.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Adidos',
                'company_id' => 62
            ],
            [
                'phones' => json_encode(['34565781239', '34565781239']),
                'email' => 'Rebok@gmail.com',
                'website' => 'Rebok.com.ua',
                'work_time' => json_encode(['test', 'test']),
                'desc' => 'Rebok',
                'company_id' => 63
            ]
        ]);*/

        $path = 'Modules/Catalog/Database/Seeders/carmen_public_catalog_company_detail.sql';
        \DB::unprepared(file_get_contents($path));

        /*$path = 'Modules/Catalog/Database/Seeders/carmen_public_catalog_company_detail_update.sql';
        \DB::unprepared(file_get_contents($path));*/

        //\DB::unprepared("select setval('catalog_company_detail_id_seq', (select max(id) + 1 from catalog_company_detail));");

    }
}
