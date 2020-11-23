<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $timestamps = false;
    protected $table = [
        'title',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
