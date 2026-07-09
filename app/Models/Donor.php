<?php

namespace App\Models;

use App\Enums\DonorStatus;
use App\Enums\DonorType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected function casts(): array
    {
        return [
            'donor_type' => DonorType::class,
            'status' => DonorStatus::class,
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
}
