<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventRegistration extends Model
{
    protected $fillable = [
        'donor_id',
        'event_id',
        'hospital_id',
        'queue_number',
        'status',
        'checked_in_by',
        'checked_in_at',
        'called_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'checked_in_at' => 'datetime',
            'called_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<Donor, $this> */
    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class);
    }

    /** @return BelongsTo<BloodDonationEvent, $this> */
    public function event(): BelongsTo
    {
        return $this->belongsTo(BloodDonationEvent::class, 'event_id');
    }

    /** @return BelongsTo<Hospital, $this> */
    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    /** @return BelongsTo<User, $this> */
    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }
}
