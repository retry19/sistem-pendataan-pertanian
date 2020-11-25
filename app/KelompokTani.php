<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KelompokTani extends Model
{
    protected $table = 'kelompok_tani';
    public $timestamps = false;
    protected $fillable = [
        'nama',
    ];
}
