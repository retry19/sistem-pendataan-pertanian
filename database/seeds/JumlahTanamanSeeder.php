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
        $sawah = Tanaman::where('jenis', 'sawah')->get();
        $buah = Tanaman::where('jenis', 'buah')->get();
        $obat = Tanaman::where('jenis', 'obat')->get();
        $kebun = Tanaman::where('jenis', 'kebun')->get();

        foreach ($sawah as $s) {
            DB::table('jumlah_tanaman')->insert([
                'tanaman_id' => $s->id,
                'tanaman_awal' => 5,
                'sdg_menghasilkan' => 2,
                'luas_rusak' => 0,
                'ditambah' => 2,
                'produktifitas' => 3,
                'produksi' => 3,
                'tahun' => date('Y'),
                'user_id' => User::first()->id,
                'kuartal_id' => Quarter::getIdActived()
            ]);
        }

        foreach ($buah as $b) {
            DB::table('jumlah_tanaman')->insert([
                'tanaman_id' => $b->id,
                'tanaman_awal' => 50,
                'dibongkar' => 10,
                'ditambah' => 5,
                'blm_menghasilkan' => 20,
                'sdg_menghasilkan' => 10,
                'produksi' => 5,
                'tahun' => date('Y'),
                'user_id' => User::first()->id,
                'kuartal_id' => Quarter::getIdActived()
            ]);
        }

        foreach ($obat as $o) {
            DB::table('jumlah_tanaman')->insert([
                'tanaman_id' => $o->id,
                'tanaman_awal' => 50,
                'dibongkar' => 10,
                'sdg_menghasilkan' => 10,
                'ditambah' => 5,
                'produksi' => 5,
                'luas_rusak' => 2,
                'tahun' => date('Y'),
                'user_id' => User::first()->id,
                'kuartal_id' => Quarter::getIdActived()
            ]);
        }

        foreach ($kebun as $k) {
            DB::table('jumlah_tanaman')->insert([
                'tanaman_id' => $k->id,
                'tanaman_awal' => 50,
                'dibongkar' => 10,
                'ditambah' => 5,
                'blm_menghasilkan' => 10,
                'sdg_menghasilkan' => 5,
                'produksi' => 5,
                'tahun' => date('Y'),
                'user_id' => User::first()->id,
                'kuartal_id' => Quarter::getIdActived()
            ]);
        }
    }
}
