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
            'name' => 'Reza Rachmanuddin',
            'birth_date' => '1999-11-11',
            'username' => 'admin',
            'password' => bcrypt('admin')
        ]);
    }
}
