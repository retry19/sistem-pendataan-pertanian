<?php

use App\Quarter;
use App\Tanaman;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrganismePenggangguSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('organisme_pengganggu')->insert([
            'tanaman_id' => Tanaman::first()->id,
            'bencana' => 'Hama',
            'luas_serangan' => 2,
            'upaya' => 'Lorem ipsum dolor',
            'tahun' => date('Y'),
            'user_id' => User::first()->id,
            'kuartal_id' => Quarter::getIdActived()
        ]);
    }
}
