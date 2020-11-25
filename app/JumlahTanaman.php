<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JumlahTanaman extends Model
{
    protected $table = 'jumlah_tanaman';
    public $timestamps = false;
    protected $fillable = [
        'tanaman_id',
        'tanaman_awal',
        'dibongkar',
        'ditambah',
        'blm_menghasilkan',
        'sdg_menghasilkan',
        'produksi',
        'luas_rusak',
        'produktifitas',
        'tahun',
        'user_id',
        'kuartal_id',
    ];

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class, 'kuartal_id');
    }
}
