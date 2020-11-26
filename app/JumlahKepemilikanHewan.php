<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JumlahKepemilikanHewan extends Model
{
    protected $table = 'jumlah_kepemilikan_hewan';
    public $timestamps = false;
    protected $fillable = [
        'hewan_id', 'blok', 'pemilik', 'jumlah', 'tahun', 'user_id', 'kuartal_id',
    ];

    public function hewan()
    {
        return $this->belongsTo(Hewan::class);
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
