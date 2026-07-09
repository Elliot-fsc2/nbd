<?php

namespace Database\Seeders;

use App\Models\BloodDonationEvent;
use Illuminate\Database\Seeder;

class BloodDonationEventSeeder extends Seeder
{
    public function run(): void
    {
        BloodDonationEvent::create([
            'name' => 'Blood Donation Drive — March 2026',
            'description' => 'Annual blood donation drive for students and staff.',
            'event_date' => '2026-03-25',
            'venue' => 'Gymnasium',
            'status' => 'upcoming',
        ]);
    }
}
