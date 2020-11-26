<?php

use App\Hewan;
use App\Quarter;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JumlahKepemilikanHewanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('jumlah_kepemilikan_hewan')->insert([
            'hewan_id' => Hewan::first()->id,
            'blok' => 'Tunggul Jati',
            'pemilik' => 'Lorem Ipsum',
            'jumlah' => 20,
            'tahun' => date('Y'),
            'user_id' => User::first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
    }
}
