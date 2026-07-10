<?php

namespace App\Models;

use App\Enums\DonorOutcomeStatus;
use App\Enums\DonorStatus;
use App\Enums\DonorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Donor extends Model
{
    protected $fillable = [
        'tracking_code',
        'donor_type',
        'id_number',
        'full_name',
        'email',
        'contact_number',
        'assigned_hospital_id',
        'data',
        'status',
        'outcome_status',
        'staff_remarks',
    ];

    protected function casts(): array
    {
        return [
            'donor_type' => DonorType::class,
            'status' => DonorStatus::class,
            'outcome_status' => DonorOutcomeStatus::class,
            'data' => 'array',
        ];
    }

    /** @return BelongsTo<Hospital, $this> */
    public function assignedHospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class, 'assigned_hospital_id');
    }

    /** @return HasMany<EventRegistration, $this> */
    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /** @return HasOne<EventRegistration, $this> */
    public function latestRegistration(): HasOne
    {
        return $this->hasOne(EventRegistration::class)->latest('created_at');
    }
}
