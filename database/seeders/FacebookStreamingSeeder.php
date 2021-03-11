<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacebookStreamingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $streaming = [
            ['is_broadcast' => false]
        ];

        DB::table('facebook_streamings')->insert($streaming);
    }
}
