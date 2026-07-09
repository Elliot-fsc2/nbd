<?php

namespace App\Models;

use App\Enums\EventStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BloodDonationEvent extends Model
{
    protected $fillable = [
        'name',
        'description',
        'event_date',
        'venue',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date:Y-m-d',
            'status' => EventStatus::class,
        ];
    }

    /** @return HasMany<EventRegistration, $this> */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class, 'event_id');
    }
}
