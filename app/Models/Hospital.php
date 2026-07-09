<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hospital extends Model
{
    protected $fillable = ['name', 'code'];

    /** @return HasMany<Donor, $this> */
    public function donors(): HasMany
    {
        return $this->hasMany(Donor::class, 'assigned_hospital_id');
    }

    /** @return HasMany<EventRegistration, $this> */
    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }
}
