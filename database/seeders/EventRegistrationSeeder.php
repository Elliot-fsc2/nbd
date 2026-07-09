<?php

namespace Database\Seeders;

use App\Models\BloodDonationEvent;
use App\Models\Donor;
use App\Models\EventRegistration;
use App\Models\Hospital;
use Illuminate\Database\Seeder;

class EventRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $event = BloodDonationEvent::first();
        $hospital = Hospital::first();
        $donors = Donor::all();

        foreach ($donors as $i => $donor) {
            EventRegistration::create([
                'donor_id' => $donor->id,
                'event_id' => $event->id,
                'hospital_id' => $hospital->id,
                'queue_number' => str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'status' => 'registered',
            ]);
        }
    }
}
