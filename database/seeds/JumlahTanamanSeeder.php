<?php

use App\Quarter;
use App\Tanaman;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JumlahTanamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jumlah_tanaman')->insert([
            'tanaman_id' => Tanaman::first()->id,
            'tanaman_awal' => 20,
            'dibongkar' => 10,
            'ditambah' => 5,
            'sdg_menghasilkan' => 10,
            'produksi' => 5,
            'tahun' => date('Y'),
            'user_id' => User::first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
    }
}
