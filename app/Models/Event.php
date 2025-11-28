<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'created_by',
        'title',
        'slug',
        'description',
        'location',
        'event_date',
        'event_time',
        'status',
        'approved_by',
        'approved_at',
        'rejection_reason',
        'is_free',
        'price',
    ];

    protected $casts = [
        'event_date' => 'date',
        'event_time' => 'string', // Store as string since TIME field in DB
        'approved_at' => 'datetime',
        'is_free' => 'boolean',
    ];

    /**
     * Get the event time as a Carbon instance for formatting.
     */
    public function getEventTimeAttribute($value)
    {
        // If it's a time string like '10:00', convert to carbon for formatting
        if ($value && !empty($value)) {
            return \Carbon\Carbon::createFromTimeString($value);
        }
        return $value;
    }

    /**
     * Get the organization that owns the event.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who approved the event.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the related transactions for this event.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class);
    }

    /**
     * Scope a query to only include pending events.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
