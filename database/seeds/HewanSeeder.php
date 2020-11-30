<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hewan')->insert([
            ['nama' => 'Sapi Potong'],
            ['nama' => 'Kerbau'],
            ['nama' => 'Kambing'],
            ['nama' => 'Domba'],
            ['nama' => 'Kuda'],
            ['nama' => 'Kelinci'],
            ['nama' => 'Anjing'],
            ['nama' => 'Ayam Buras'],
            ['nama' => 'Ayam Ras Pedaging'],
            ['nama' => 'Ayam Ras Petelur'],
            ['nama' => 'Itik'],
            ['nama' => 'Merpati'],
            ['nama' => 'Puyuh'],
            ['nama' => 'Entog'],
        ]);
    }
}
