<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'user_id',
        'event_id',
        'certificate_number',
        'title',
        'description',
        'issued_date',
        'file_path',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    /**
     * Get the organization that owns the certificate.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * Get the user that owns the certificate.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event associated with the certificate.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
