<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KepemilikanLahan extends Model
{
    protected $table = 'kepemilikan_lahan';
    public $timestamps = false;
    protected $fillable = [
        'blok', 'pemilik', 'luas_sawah', 'luas_rencana', 'alamat', 'tahun', 'kelompok_tani_id', 'user_id', 'kuartal_id',
    ];

    public function kelompokTani()
    {
        return $this->belongsTo(KelompokTani::class, 'kelompok_tani_id');
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
