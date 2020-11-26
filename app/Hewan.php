<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    protected $table = 'hewan';
    public $timestamps = false;
    protected $fillable = [
        'nama',
    ];
}
