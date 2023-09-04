<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'username' => 'admin',
            'firstname' => 'Admin',
            'lastname' => 'Admin',
            'email' => 'admin@argon.com',
            'password' => bcrypt('secret')
        ]);

        DB::table('users')->insert([
            'avatar' => '12.png',
            'username' => 'akbartriprakoso',
            'firstname' => 'Akbar',
            'lastname' => 'Tri Prakoso',
            'email' => 'akbartriprakoso@argon.com',
            'password' => bcrypt('1sampai8')
        ]);
    }
}
