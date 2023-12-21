<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'event_id',
        'ticket_type',
        'user_id',
        'price',
    ];
    protected $primaryKey = 'ticket_id';
    protected $casts = [
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'created_at' => 'datetime',
    ];
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'ticket_id');
    }
    public function event(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id', 'event_id');
    }
}

