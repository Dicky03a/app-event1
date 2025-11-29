<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $fillable = [
        'event_id',
        'registration_id',
        'user_id',
        'amount',
        'payment_status',
        'snap_token',
        'payment_url',
    ];

    protected $casts = [
        'amount' => 'integer',
        'payment_status' => 'string',
    ];

    /**
     * Get the event that the transaction belongs to.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user that the transaction belongs to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event registration associated with this transaction.
     */
    public function eventRegistration(): BelongsTo
    {
        return $this->belongsTo(EventRegistration::class, 'registration_id');
    }
}
