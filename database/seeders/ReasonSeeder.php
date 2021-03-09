<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reasons = [
            ['reason' => 'HINDI  AKO PINAPASWELDO NG AKING AMO'],
            ['reason' => 'TAPOS NA PO ANG AKING KONTRATA, PERO AYAW AKONG PAUWIIN'],
            ['reason' => 'SINASAKTAN AKO NG AKING AMO'],
            ['reason' => 'HINDI AKO PINAPAKAIN '],
            ['reason' => 'AKO PO AY MAY KARAMDAMAN O SAKIT'],
            ['reason' => 'PINAGTANGKAAN AKONG GAHASAIN NG AKING AMO'],
            ['reason' => 'HINDI INAASIKASO NG AKING AMO ANG AKING IQAMA'],
            ['reason' => 'IBA PANG DAHILAN']
        ];

        DB::table('reasons')->insert($reasons);
    }
}
