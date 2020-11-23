<?php

use App\Hewan;
use App\PopulasiHewan;
use App\Quarter;
use App\User;
use Illuminate\Database\Seeder;

class PopulasiHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $populasiAwal['jantan'] = 20;
        $populasiAwal['betina'] = 15;
        $lahir['jantan'] = 0;
        $lahir['betina'] = 0;
        $diPotong['jantan'] = 0;
        $diPotong['betina'] = 0;
        $mati['jantan'] = 0;
        $mati['betina'] = 0;
        $masuk['jantan'] = 0;
        $masuk['betina'] = 0;
        $keluar['jantan'] = 0;
        $keluar['betina'] = 0;
        $populasiAkhir['jantan'] = 0;
        $populasiAkhir['betina'] = 0;

        PopulasiHewan::create([
            'hewan_id' => Hewan::first()->id,
            'populasi_awal' => $populasiAwal,
            'lahir' => $lahir,
            'dipotong' => $diPotong,
            'mati' => $mati,
            'masuk' => $masuk,
            'keluar' => $keluar,
            'tahun' => now()->format('Y'),
            'user_id' => User::first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
    }
}
