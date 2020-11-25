<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelompokTaniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kelompok_tani')->insert([
            ['nama' => 'Sriunggul Mekar'],
            ['nama' => 'Silih Asih'],
        ]);
    }
}
