<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DonorOutcomeStatus;
use App\Enums\DonorStatus;
use App\Enums\HouseOfHeroes;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Donor;
use App\Models\Hospital;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonorController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = Course::pluck('name', 'id');

        $query = Donor::with('assignedHospital');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($hospitalId = $request->get('hospital_id')) {
            $query->where('assigned_hospital_id', $hospitalId);
        }

        if ($house = $request->get('house')) {
            $query->where('data->house_heroes', $house);
        }

        if ($outcomeStatus = $request->get('outcome_status')) {
            $query->where('outcome_status', $outcomeStatus);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $mapHouseOfHeroes = function (?string $value): ?string {
            return match ($value) {
                null => null,
                default => HouseOfHeroes::tryFrom($value)?->label() ?? $value,
            };
        };

        $hospitals = Hospital::orderBy('name')->get(['id', 'name', 'code']);

        $statuses = collect(DonorStatus::cases())->map(fn ($case) => [
            'value' => $case->value,
            'label' => ucwords(str_replace('_', ' ', $case->value)),
        ]);

        $outcomeStatuses = collect(DonorOutcomeStatus::cases())->map(fn ($case) => [
            'value' => $case->value,
            'label' => ucwords(str_replace('_', ' ', $case->value)),
        ]);

        $houseOptions = collect(HouseOfHeroes::cases())->map(fn ($case) => [
            'value' => $case->value,
            'label' => $case->name,
        ]);

        return Inertia::render('admin/donors/index', [
            'donors' => $query->latest()->paginate(20)->withQueryString()->through(function ($donor) use ($courses, $mapHouseOfHeroes) {
                return [
                    'id' => $donor->id,
                    'tracking_code' => $donor->tracking_code,
                    'full_name' => $donor->full_name,
                    'donor_type' => $donor->donor_type?->value,
                    'id_number' => $donor->id_number,
                    'email' => $donor->email,
                    'contact_number' => $donor->contact_number,
                    'status' => $donor->status?->value,
                    'outcome_status' => $donor->outcome_status?->value,
                    'hospital_name' => $donor->assignedHospital?->name,
                    'course_name' => isset($donor->data['course_id']) ? ($courses[$donor->data['course_id']] ?? null) : null,
                    'house_heroes_label' => $mapHouseOfHeroes($donor->data['house_heroes'] ?? null),
                    'created_at' => $donor->created_at,
                    'data' => $donor->data,
                ];
            }),
            'hospitals' => $hospitals,
            'statuses' => $statuses,
            'outcomeStatuses' => $outcomeStatuses,
            'houseOptions' => $houseOptions,
            'filters' => $request->only(['search', 'status', 'outcome_status', 'hospital_id', 'house', 'date_from', 'date_to']),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Donor::with('assignedHospital');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($outcomeStatus = $request->get('outcome_status')) {
            $query->where('outcome_status', $outcomeStatus);
        }

        if ($hospitalId = $request->get('hospital_id')) {
            $query->where('assigned_hospital_id', $hospitalId);
        }

        if ($house = $request->get('house')) {
            $query->where('data->house_heroes', $house);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $courses = Course::pluck('name', 'id');
        $donors = $query->latest()->get();

        $headers = [
            'ID', 'Tracking Code', 'Donor Type', 'ID Number', 'Full Name',
            'Email', 'Contact Number', 'Hospital', 'Course', 'Status',
            'Surname', 'Given Name', 'Middle Name', 'Birthdate', 'Age',
            'Sex', 'Civil Status', 'Blood Type', 'Occupation',
            'House No', 'Street', 'Subdivision', 'Barangay', 'City/Province',
            'House of Heroes', 'Representative For', 'Year & Section',
            'Instructor Name', 'Created At',
        ];

        $callback = function () use ($donors, $courses, $headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            foreach ($donors as $donor) {
                $data = $donor->data ?? [];
                $courseId = $data['course_id'] ?? null;

                fputcsv($handle, [
                    $donor->id,
                    $donor->tracking_code,
                    $donor->donor_type?->value ?? '',
                    $donor->id_number,
                    $donor->full_name,
                    $donor->email,
                    $donor->contact_number,
                    $donor->assignedHospital?->name ?? '',
                    $courseId && $courses->has($courseId) ? $courses[$courseId] : '',
                    $donor->status?->value ?? '',
                    $data['surname'] ?? '',
                    $data['given_name'] ?? '',
                    $data['middle_name'] ?? '',
                    $data['birthdate'] ?? '',
                    $data['age'] ?? '',
                    $data['sex'] ?? '',
                    $data['civil_status'] ?? '',
                    $data['blood_type'] ?? '',
                    $data['occupation'] ?? '',
                    $data['house_no'] ?? '',
                    $data['street'] ?? '',
                    $data['subdivision'] ?? '',
                    $data['barangay'] ?? '',
                    $data['city_province'] ?? '',
                    $data['house_heroes'] ?? '',
                    $data['representative_full_name'] ?? '',
                    $data['year_section'] ?? '',
                    $data['instructor_name'] ?? '',
                    $donor->created_at,
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, 'donors-export-'.now()->format('Y-m-d_His').'.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function form(Donor $donor, PdfGenerationService $pdfService): SymfonyResponse
    {
        $pdf = $pdfService->generate($donor);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf;
        }, 'donation-form-'.str($donor->full_name)->slug().'.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
