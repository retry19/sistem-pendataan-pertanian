<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dokumentasi extends Model
{
    protected $table = 'dokumentasi';
    public $timestamps = false;
    protected $fillable = [
        'gambar', 'deskripsi', 'tanggal', 'user_id', 'kuartal_id',
    ];

    protected $dates = [
        'tanggal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quarter()
    {
        return $this->belongsTo(Quarter::class, 'kuartal_id');
    }
}
