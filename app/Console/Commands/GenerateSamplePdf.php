<?php

namespace App\Console\Commands;

use App\Models\Donor;
use App\Models\Hospital;
use App\Services\PdfGenerationService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('make:sample-pdf {--hospital= : Hospital ID or code to use}')]
#[Description('Generate a sample donation form PDF prefilled with test data')]
class GenerateSamplePdf extends Command
{
    public function handle(PdfGenerationService $pdfService)
    {
        if ($hospitalOption = $this->option('hospital')) {
            $hospital = Hospital::where('id', $hospitalOption)
                ->orWhere('code', $hospitalOption)
                ->firstOrFail();
        } else {
            $hospital = $this->choice(
                'Which hospital form should the sample use?',
                Hospital::all()->map(fn ($h) => "{$h->id}: {$h->name} ({$h->code})")->toArray(),
            );

            $hospitalId = (int) explode(':', $hospital)[0];
            $hospital = Hospital::findOrFail($hospitalId);
        }

        $donor = Donor::create([
            'tracking_code' => 'SAMPLE-'.strtoupper(bin2hex(random_bytes(3))),
            'donor_type' => 'student',
            'status' => 'registered',
            'id_number' => 'SAMPLE-001',
            'full_name' => 'Doe, John Michael',
            'email' => 'john.doe@example.com',
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

        $this->components->task('Generating PDF', function () use ($pdfService, $donor, $hospital) {
            $pdf = $pdfService->generate($donor);

            $path = storage_path("app/public/samples/donation-form-{$hospital->code}.pdf");
            if (! is_dir(dirname($path))) {
                mkdir(dirname($path), 0755, true);
            }

            file_put_contents($path, $pdf);

            return true;
        });

        $this->components->twoColumnDetail('Hospital', $hospital->name);
        $this->components->twoColumnDetail('Donor', $donor->full_name);
        $this->components->twoColumnDetail('Saved to', storage_path("app/public/samples/donation-form-{$hospital->code}.pdf"));

        $this->components->success('Sample PDF generated!');
    }
}
