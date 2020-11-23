<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['title' => 'users_list'],
            ['title' => 'users_create'],
            ['title' => 'users_edit'],
        ]);
    }
}
