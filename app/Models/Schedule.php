<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['event_id', 'speaker_id', 'description', 'start_time', 'end_time', 'session_name'];
    protected $primaryKey = 'schedule_id';

    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }

    public function speaker(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Speaker::class, 'speaker_id', 'speaker_id');
    }
}

