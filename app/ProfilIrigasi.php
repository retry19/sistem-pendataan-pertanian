<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfilIrigasi extends Model
{
    protected $table = 'profil_irigasi';
    protected $fillable = [
        'kondisi_umum',
        'sumber_air',
        'ketersediaan_air',
        'profil_sosial',
        'profil_teknik',
        'profil_kelembagaan',
        'kondisi_usahatani',
        'potensi_sumberdaya_lokal',
        'tahun',
    ];
}
