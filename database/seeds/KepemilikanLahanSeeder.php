<?php

use App\KelompokTani;
use App\Quarter;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepemilikanLahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kepemilikan_lahan')->insert([
            'blok' => 'Tunggul Jati',
            'pemilik' => 'Lorem Ipsum Do.',
            'luas_sawah' => 0.714,
            'luas_rencana' => 0.714,
            'alamat' => 'Ciawigebang',
            'tahun' => date('Y'),
            'kelompok_tani_id' => KelompokTani::first()->id,
            'user_id' => User::first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
    }
}
