<?php

namespace App\Console\Commands;

use App\Models\Course;
use App\Models\Donor;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Collection;

#[Signature('app:export-donors {--path= : Output file path} {--hospital= : Filter by hospital ID or code}')]
#[Description('Export donors list to CSV with JSON data columns expanded')]
class ExportDonors extends Command
{
    private const DATA_COLUMNS = [
        'surname',
        'given_name',
        'middle_name',
        'birthdate',
        'age',
        'sex',
        'civil_status',
        'blood_type',
        'occupation',
        'house_no',
        'street',
        'subdivision',
        'barangay',
        'city_province',
        'house_heroes',
        'representative_full_name',
        'course_id',
        'year_section',
        'instructor_name',
        'consent',
    ];

    private const CSV_HEADERS = [
        'id',
        'tracking_code',
        'donor_type',
        'id_number',
        'full_name',
        'email',
        'contact_number',
        'hospital',
        'course',
        'status',
        'outcome_status',
        'staff_remarks',
        'created_at',
        'updated_at',
        ...self::DATA_COLUMNS,
    ];

    public function handle(): int
    {
        $path = $this->option('path') ?? storage_path('app/donors_export_'.now()->format('Y-m-d_His').'.csv');
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $courses = Course::pluck('name', 'id');

        $query = Donor::query()
            ->select([
                'donors.id',
                'donors.tracking_code',
                'donors.donor_type',
                'donors.id_number',
                'donors.full_name',
                'donors.email',
                'donors.contact_number',
                'donors.assigned_hospital_id',
                'donors.status',
                'donors.outcome_status',
                'donors.staff_remarks',
                'donors.data',
                'donors.created_at',
                'donors.updated_at',
            ])
            ->with('assignedHospital:id,name,code');

        if ($hospitalOption = $this->option('hospital')) {
            $query->whereHas('assignedHospital', function ($q) use ($hospitalOption) {
                $q->where('id', $hospitalOption)
                    ->orWhere('code', $hospitalOption);
            });
        }

        $total = (clone $query)->count();

        if ($total === 0) {
            $this->components->warn('No donors found to export.');

            return self::SUCCESS;
        }

        $handle = fopen($path, 'w');

        if ($handle === false) {
            $this->components->error("Failed to open file for writing: {$path}");

            return self::FAILURE;
        }

        fputcsv($handle, self::CSV_HEADERS);

        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $query->chunkById(500, function (Collection $donors) use ($handle, $bar, $courses) {
            foreach ($donors as $donor) {
                $data = $donor->data ?? [];
                $courseId = $data['course_id'] ?? null;

                $row = [
                    $donor->id,
                    $donor->tracking_code,
                    $donor->donor_type->value,
                    $donor->id_number,
                    $donor->full_name,
                    $donor->email,
                    $donor->contact_number,
                    $donor->assignedHospital?->name ?? '',
                    $courseId && $courses->has($courseId) ? $courses[$courseId] : '',
                    $donor->status->value,
                    $donor->outcome_status?->value,
                    $donor->staff_remarks,
                    $donor->created_at,
                    $donor->updated_at,
                ];

                foreach (self::DATA_COLUMNS as $column) {
                    $row[] = $data[$column] ?? '';
                }

                fputcsv($handle, $row);
                $bar->advance();
            }
        });

        fclose($handle);
        $bar->finish();
        $this->newLine();

        $this->components->success("Exported {$total} donors to {$path}");

        return self::SUCCESS;
    }
}
