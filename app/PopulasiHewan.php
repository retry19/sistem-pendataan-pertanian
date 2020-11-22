<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopulasiHewan extends Model
{
    protected $table = 'populasi_hewan';
    public $timestamps = false;
    protected $fillable = [
        'hewan_id', 'populasi_awal', 'lahir', 'dipotong', 'mati', 'masuk', 'keluar', 'populasi_akhir', 'tahun', 'user_id', 'kuartal_id',
    ];

    protected $casts = [
        'populasi_awal' => 'array',
        'lahir' => 'array',
        'dipotong' => 'array',
        'mati' => 'array',
        'masuk' => 'array',
        'keluar' => 'array',
        'populasi_akhir' => 'array',
    ];

    public function hewan()
    {
        return $this->belongsTo(Hewan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
