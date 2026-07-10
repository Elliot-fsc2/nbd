<?php

namespace App\Console\Commands;

use App\Mail\DonorFormMail;
use App\Models\Donor;
use App\Models\Hospital;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

#[Signature('make:sample-pdf {--hospital= : Hospital ID or code to use}')]
#[Description('Generate a sample donation form PDF prefilled with test data')]
class GenerateSamplePdf extends Command
{
    public function handle()
    {
        if ($hospitalOption = $this->option('hospital')) {
            $hospital = Hospital::where('id', $hospitalOption)
                ->orWhere('code', $hospitalOption)
                ->firstOrFail();
        } else {
            $hospitals = Hospital::all();
            $selected = $this->choice(
                'Which hospital form should the sample use?',
                $hospitals->map(fn ($h) => "{$h->name} ({$h->code})")->toArray(),
            );

            $hospital = $hospitals->first(fn ($h) => "{$h->name} ({$h->code})" === $selected);
        }

        $donor = Donor::make([
            'tracking_code' => 'SAMPLE-'.strtoupper(bin2hex(random_bytes(3))),
            'donor_type' => 'student',
            'status' => 'registered',
            'id_number' => 'SAMPLE-001',
            'full_name' => 'Doe, John Michael',
            'email' => 'adrxyz20@gmail.com',
            'contact_number' => '09171234567',
            'assigned_hospital_id' => $hospital->id,
            'data' => [
                'surname' => 'Doe',
                'given_name' => 'John Michael',
                'middle_name' => 'Cruz',
                'birthdate' => '1995-06-15',
                'age' => 31,
                'sex' => 'male',
                'civil_status' => 'single',
                'blood_type' => 'O+',
                'occupation' => 'Software Engineer',
                'house_heroes' => 'makabayan',
                'course_id' => '1',
                'house_no' => '123',
                'street' => 'Rizal Street',
                'subdivision' => '',
                'barangay' => 'Barangay San Juan',
                'city_province' => 'Manila',
                'email' => 'john.doe@example.com',
                'contact_number' => '09171234567',
                'donor_type' => 'student',
                'id_number' => 'SAMPLE-001',
                'representative_full_name' => '',
                'consent' => '1',
            ],
        ]);

        $this->components->task('Sending sample PDF via email', function () use ($donor) {
            Mail::to($donor->email)->send(new DonorFormMail($donor));

            return true;
        });

        $this->components->twoColumnDetail('Hospital', $hospital->name);
        $this->components->twoColumnDetail('Donor', $donor->full_name);
        $this->components->twoColumnDetail('Emailed to', $donor->email);

        $this->components->success('Sample PDF sent via email!');
    }
}
