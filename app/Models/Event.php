<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';

    public function sponsors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsor', 'event_id', 'sponsor_id');
    }
}

