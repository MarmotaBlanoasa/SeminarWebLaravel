<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';
    protected $fillable = ['event_name', 'event_description', 'date_start', 'date_end', 'location', 'max_tickets', 'event_image', 'price'];
    protected $casts = [
        'date_start' => 'datetime:Y-m-d',
        'date_end' => 'datetime:Y-m-d',
    ];
    public function speakers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Speaker::class, 'event_speaker', 'event_id', 'speaker_id');
    }

    public function events(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_sponsor', 'sponsor_id', 'event_id');
    }
    public function sponsors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Sponsor::class, 'event_sponsor', 'event_id', 'sponsor_id');
    }
    public function schedules(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Schedule::class, 'event_id');
    }
    public function tickets(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}

