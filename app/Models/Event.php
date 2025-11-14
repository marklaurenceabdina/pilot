<?php
// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'date',
        'time',
        'location',
        'capacity',
        'category',
        'status',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
    ];

    /**
     * Get the attendees for the event.
     */
    public function attendees(): HasMany
    {
        return $this->hasMany(Attendee::class);
    }

    /**
     * Get the registered attendees count (computed attribute)
     */
    public function getRegisteredAttribute(): int
    {
        return $this->attendees()->where('attendance_status', '!=', 'cancelled')->count();
    }

    /**
     * Check if event is full
     */
    public function getIsFullAttribute(): bool
    {
        return $this->registered >= $this->capacity;
    }

    /**
     * Scope for upcoming events
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'upcoming')
                    ->orWhere('status', 'ongoing')
                    ->orderBy('date')
                    ->orderBy('time');
    }

    /**
     * Scope for active events (not cancelled)
     */
    public function scopeActive($query)
    {
        return $query->where('status', '!=', 'cancelled');
    }
}