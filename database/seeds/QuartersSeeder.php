<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuartersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quarters')->insert([
            ['section' => 1, 'is_active' => 1],
            ['section' => 2, 'is_active' => 0],
            ['section' => 3, 'is_active' => 0],
        ]);
    }
}
