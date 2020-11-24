<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TanamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tanaman')->insert([
            ['nama' => 'Alpukat', 'jenis' => 'buah'],
            ['nama' => 'Sirih', 'jenis' => 'obat'],
            ['nama' => 'Tebu', 'jenis' => 'kebun'],
            ['nama' => 'Padi', 'jenis' => 'sawah'],
        ]);
    }
}
