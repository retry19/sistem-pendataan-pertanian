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
            ['nama' => 'Padi', 'jenis' => 'sawah'],
            ['nama' => 'Jagung', 'jenis' => 'sawah'],
            ['nama' => 'Kacang Kedelai', 'jenis' => 'sawah'],
            ['nama' => 'Kacang Tanah', 'jenis' => 'sawah'],
            ['nama' => 'Kacang Hijau', 'jenis' => 'sawah'],
            ['nama' => 'Ubi Kayu', 'jenis' => 'sawah'],
            ['nama' => 'Ubi Jalar', 'jenis' => 'sawah'],
            ['nama' => 'Bawang Merah', 'jenis' => 'sawah'],
            ['nama' => 'Kacang Panjang', 'jenis' => 'sawah'],
            ['nama' => 'Cabai Merah', 'jenis' => 'sawah'],
            ['nama' => 'Cabai Rawit', 'jenis' => 'sawah'],
            ['nama' => 'Terung', 'jenis' => 'sawah'],
            ['nama' => 'Ketimun', 'jenis' => 'sawah'],
            ['nama' => 'Tomat', 'jenis' => 'sawah'],
            ['nama' => 'Kacang Merah', 'jenis' => 'sawah'],
            ['nama' => 'Buncis', 'jenis' => 'sawah'],
            ['nama' => 'Semangka', 'jenis' => 'sawah'],
            ['nama' => 'Leunca', 'jenis' => 'sawah'],
            ['nama' => 'Alpukat', 'jenis' => 'buah'],
            ['nama' => 'Belimbing', 'jenis' => 'buah'],
            ['nama' => 'Duku', 'jenis' => 'buah'],
            ['nama' => 'Durian', 'jenis' => 'buah'],
            ['nama' => 'Jambu Biji', 'jenis' => 'buah'],
            ['nama' => 'Jambu Air', 'jenis' => 'buah'],
            ['nama' => 'Jeruk Silam', 'jenis' => 'buah'],
            ['nama' => 'Mangga', 'jenis' => 'buah'],
            ['nama' => 'Nangka', 'jenis' => 'buah'],
            ['nama' => 'Nenas', 'jenis' => 'buah'],
            ['nama' => 'Pepaya', 'jenis' => 'buah'],
            ['nama' => 'Pisang', 'jenis' => 'buah'],
            ['nama' => 'Rambutan', 'jenis' => 'buah'],
            ['nama' => 'Sawo', 'jenis' => 'buah'],
            ['nama' => 'Sirsak', 'jenis' => 'buah'],
            ['nama' => 'Sukun', 'jenis' => 'buah'],
            ['nama' => 'Melinjo', 'jenis' => 'buah'],
            ['nama' => 'Petai', 'jenis' => 'buah'],
            ['nama' => 'Jengkol', 'jenis' => 'buah'],
            ['nama' => 'Jahe', 'jenis' => 'obat'],
            ['nama' => 'Laos', 'jenis' => 'obat'],
            ['nama' => 'Kencur', 'jenis' => 'obat'],
            ['nama' => 'Kunyit', 'jenis' => 'obat'],
            ['nama' => 'Lempuyang', 'jenis' => 'obat'],
            ['nama' => 'Temu Lawak', 'jenis' => 'obat'],
            ['nama' => 'Temu Ireng', 'jenis' => 'obat'],
            ['nama' => 'Dlinggo', 'jenis' => 'obat'],
            ['nama' => 'Kapulaga', 'jenis' => 'obat'],
            ['nama' => 'Mengkudu', 'jenis' => 'obat'],
            ['nama' => 'Mahkota Desa', 'jenis' => 'obat'],
            ['nama' => 'Lidah Buaya', 'jenis' => 'obat'],
            ['nama' => 'Tebu', 'jenis' => 'kebun'],
            ['nama' => 'Kelapa', 'jenis' => 'kebun'],
            ['nama' => 'Cengkeh', 'jenis' => 'kebun'],
            ['nama' => 'Kopi', 'jenis' => 'kebun'],
            ['nama' => 'Kapuk', 'jenis' => 'kebun'],
            ['nama' => 'Kemiri', 'jenis' => 'kebun'],
            ['nama' => 'Pala', 'jenis' => 'kebun'],
        ]);
    }
}
