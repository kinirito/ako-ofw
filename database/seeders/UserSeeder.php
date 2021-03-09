<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'avatar' => 'default_avatar.jpg',
                'email' => 'gelo043097@gmail.com',
                'username' => 'GeloLavadia',
                'password' => Hash::make('gelo101219'),
                'is_admin' => true,
                'last_name' => 'Lavadia',
                'middle_name' => 'Franco',
                'first_name' => 'Angelo Joshua',
                'birthdate' => Carbon::createFromFormat('m/d/Y', '04/30/1997'),
                'contact' => '09554791765',
                'agency' => 'Direct',
                'occupation' => 'Freelance Programmer',
                'address' => 'Block 25 Lot 51 Comets St. Garden Villas 3 Phase 5 Brgy. Malusak City of Santa Rosa Laguna 4026',
                'country_id' => '170',
                'verification_code' => sha1(time()),
                'is_verified' => true,
                'is_first_login' => false
            ],
            [
                'avatar' => 'default_avatar.jpg',
                'email' => 'drchieumandap@yahoo.com',
                'username' => 'drchieumandap',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'last_name' => 'Umandap',
                'first_name' => 'Celerino',
                'middle_name' => null,
                'birthdate' => Carbon::createFromFormat('m/d/Y', '10/28/1965'),
                'contact' => '09081287864',
                'agency' => 'Direct',
                'occupation' => 'Dentist',
                'address' => '5337 Ben Harrison St. Pio Del Pilar Makati City',
                'country_id' => '170',
                'verification_code' => sha1(time()),
                'is_verified' => true,
                'is_first_login' => false
            ]
        ];

        DB::table('users')->insert($users);
    }
}
