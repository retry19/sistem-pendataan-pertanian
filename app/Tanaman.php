<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    protected $table = 'tanaman';
    public $timestamps = false;
    protected $fillable = [
        'nama', 'jenis',
    ];  
}
