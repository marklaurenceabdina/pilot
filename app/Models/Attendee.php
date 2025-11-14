<?php
// app/Models/Attendee.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'attendance_status',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    /**
     * Get the event that the attendee registered for.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user that registered for the event.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}