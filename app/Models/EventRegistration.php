<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'payment_status',
        'payment_reference',
        'ticket_code',
        'registered_at',
        'attendance_status',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
        'payment_status' => 'string',
        'attendance_status' => 'string',
    ];

    /**
     * Get the event that owns the registration.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user that owns the registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include free registrations.
     */
    public function scopeFree($query)
    {
        return $query->where('payment_status', 'free');
    }

    /**
     * Scope a query to only include pending registrations.
     */
    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope a query to only include paid registrations.
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope a query to only include registered users (free, pending, or paid).
     */
    public function scopeRegistered($query)
    {
        return $query->whereIn('payment_status', ['free', 'pending', 'paid']);
    }
}
