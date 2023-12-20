<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'nume', 'description', 'email', 'phone'
    ];
    protected $primaryKey = 'sponsor_id';

    public function events(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        // Corrected relationship definition
        return $this->belongsToMany(Event::class, 'event_sponsor', 'sponsor_id', 'event_id');
    }
}
