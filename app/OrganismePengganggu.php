<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganismePengganggu extends Model
{
    protected $table = 'organisme_pengganggu';
    public $timestamps = false;
    protected $fillable = [
        'tanaman_id', 'bencana', 'luas_serangan', 'upaya', 'tahun', 'user_id', 'kuartal_id',
    ];

    public function tanaman()
    {
        return $this->belongsTo(Tanaman::class);
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
