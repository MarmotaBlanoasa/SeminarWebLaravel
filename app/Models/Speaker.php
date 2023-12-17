<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    protected $primaryKey = 'speaker_id';

    protected $fillable = [
        'nume', 'prenume', 'email', 'telefon', 'bio'
    ];

    public function schedule(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class, 'speaker_id', 'speaker_id');
    }
}

