<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quarter extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'section', 'is_active',
    ];

    public static function getIdActived()
    {
        $quarter = self::firstWhere('is_active', true);
        if (!$quarter) {
            return 0;
        }

        return $quarter->id;
    }
}
