<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'section', 'is_active',
    ];
}
