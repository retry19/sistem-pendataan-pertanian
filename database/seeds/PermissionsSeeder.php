<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            ['title' => 'users_management_access'],
            ['title' => 'quarters_management_access'],
            ['title' => 'hewan_management_access'],
            ['title' => 'tanaman_management_access'],
            ['title' => 'kelompok_tani_management_access'],
            ['title' => 'laporan_management_access'],
            ['title' => 'populasi_hewan_list'],
            ['title' => 'populasi_hewan_create'],
            ['title' => 'populasi_hewan_read'],
            ['title' => 'populasi_hewan_update'],
            ['title' => 'populasi_hewan_delete'],
            ['title' => 'populasi_hewan_quarter'],
            ['title' => 'kepemilikan_hewan_list'],
            ['title' => 'kepemilikan_hewan_create'],
            ['title' => 'kepemilikan_hewan_read'],
            ['title' => 'kepemilikan_hewan_update'],
            ['title' => 'kepemilikan_hewan_delete'],
            ['title' => 'kepemilikan_hewan_quarter'],
            ['title' => 'luas_tanam_list'],
            ['title' => 'luas_tanam_create'],
            ['title' => 'luas_tanam_read'],
            ['title' => 'luas_tanam_update'],
            ['title' => 'luas_tanam_delete'],
            ['title' => 'luas_tanam_quarter'],
            ['title' => 'tanaman_buah_list'],
            ['title' => 'tanaman_buah_create'],
            ['title' => 'tanaman_buah_read'],
            ['title' => 'tanaman_buah_update'],
            ['title' => 'tanaman_buah_delete'],
            ['title' => 'tanaman_buah_quarter'],
            ['title' => 'tanaman_obat_list'],
            ['title' => 'tanaman_obat_create'],
            ['title' => 'tanaman_obat_read'],
            ['title' => 'tanaman_obat_update'],
            ['title' => 'tanaman_obat_delete'],
            ['title' => 'tanaman_obat_quarter'],
            ['title' => 'tanaman_kebun_list'],
            ['title' => 'tanaman_kebun_create'],
            ['title' => 'tanaman_kebun_read'],
            ['title' => 'tanaman_kebun_update'],
            ['title' => 'tanaman_kebun_delete'],
            ['title' => 'tanaman_kebun_quarter'],
            ['title' => 'organisme_pengganggu_list'],
            ['title' => 'organisme_pengganggu_create'],
            ['title' => 'organisme_pengganggu_read'],
            ['title' => 'organisme_pengganggu_update'],
            ['title' => 'organisme_pengganggu_delete'],
            ['title' => 'organisme_pengganggu_quarter'],
            ['title' => 'kepemilikan_lahan_list'],
            ['title' => 'kepemilikan_lahan_create'],
            ['title' => 'kepemilikan_lahan_read'],
            ['title' => 'kepemilikan_lahan_update'],
            ['title' => 'kepemilikan_lahan_delete'],
            ['title' => 'kepemilikan_lahan_quarter'],
            ['title' => 'dokumentasi_list'],
            ['title' => 'dokumentasi_create'],
            ['title' => 'dokumentasi_read'],
            ['title' => 'dokumentasi_update'],
            ['title' => 'dokumentasi_delete'],
            ['title' => 'dokumentasi_quarter'],
        ]);
    }
}
