<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Desa',
                'birth_date' => '1999-11-11',
                'username' => 'admin',
                'password' => bcrypt('admin')
            ],
            [
                'name' => 'Perangkat Desa',
                'birth_date' => '2020-11-20',
                'username' => 'perangkat_desa',
                'password' => bcrypt('perangkat_desa')
            ],
            [
                'name' => 'Poktan',
                'birth_date' => '2020-11-20',
                'username' => 'poktan',
                'password' => bcrypt('poktan')
            ],
        ]);
    }
}
