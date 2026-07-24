<?php

namespace App\Http\Controllers\Staff;

use App\Enums\DonorOutcomeStatus;
use App\Enums\DonorStatus;
use App\Enums\HouseOfHeroes;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Donor;
use App\Models\Hospital;
use App\Services\PdfGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
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
        $hospitals = Hospital::orderBy('name')->get(['id', 'name', 'code']);

        $query = Donor::with('assignedHospital', 'latestRegistration');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%")
                    ->orWhere('data->representative_full_name', 'like', "%{$search}%")
                    ->orWhere('data->id_number', 'like', "%{$search}%");
            });
        }

        if ($hospitalId = $request->input('hospital_id')) {
            $query->where('assigned_hospital_id', $hospitalId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($house = $request->input('house')) {
            $query->where('data->house_heroes', $house);
        }

        if ($outcomeStatus = $request->input('outcome_status')) {
            $query->where('outcome_status', $outcomeStatus);
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $mapHouseOfHeroes = function (?string $value): ?string {
            return match ($value) {
                null => null,
                default => HouseOfHeroes::tryFrom($value)?->label() ?? $value,
            };
        };

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

        return Inertia::render('staff/donors/index', [
            'donors' => $query->latest()->paginate(20)->withQueryString()->through(function ($donor) use ($courses, $mapHouseOfHeroes) {
                $registration = $donor->latestRegistration;

                return [
                    'id' => $donor->id,
                    'tracking_code' => $donor->tracking_code,
                    'donor_type' => $donor->donor_type,
                    'full_name' => $donor->full_name,
                    'id_number' => $donor->id_number,
                    'email' => $donor->email,
                    'contact_number' => $donor->contact_number,
                    'status' => $donor->status?->value,
                    'outcome_status' => $donor->outcome_status?->value,
                    'staff_remarks' => $donor->staff_remarks,
                    'checked_in_at' => $registration?->checked_in_at?->isoFormat('MMM D, YYYY, h:mm A'),
                    'called_at' => $registration?->called_at?->isoFormat('MMM D, YYYY, h:mm A'),
                    'completed_at' => $registration?->completed_at?->isoFormat('MMM D, YYYY, h:mm A'),
                    'checked_in_time' => $registration?->checked_in_at?->isoFormat('h:mm A'),
                    'called_time' => $registration?->called_at?->isoFormat('h:mm A'),
                    'completed_time' => $registration?->completed_at?->isoFormat('h:mm A'),
                    'course_name' => isset($donor->data['course_id']) ? ($courses[$donor->data['course_id']] ?? null) : null,
                    'house_heroes_label' => $mapHouseOfHeroes($donor->data['house_heroes'] ?? null),
                    'representative_for' => $donor->data['representative_full_name'] ?? null,
                    'hospital_name' => $donor->assignedHospital?->name,
                    'data' => $donor->data,
                ];
            }),
            'hospitals' => $hospitals,
            'statuses' => $statuses,
            'outcomeStatuses' => $outcomeStatuses,
            'houseOptions' => $houseOptions,
            'filters' => $request->only(['search', 'hospital_id', 'status', 'outcome_status', 'house', 'date_from', 'date_to']),
        ]);
    }

    public function update(Request $request, Donor $donor): RedirectResponse
    {
        $validated = $request->validate([
            'outcome_status' => ['nullable', 'string', 'in:completed,rescheduled,not_completed'],
            'staff_remarks' => ['nullable', 'string', 'max:1000'],
        ]);

        $donor->update($validated);

        return back()->with('success', 'Donor status updated.');
    }

    public function search(Request $request): JsonResponse
    {
        $query = $request->input('q');

        if (! $query || strlen($query) < 2) {
            return response()->json([]);
        }

        $donors = Donor::where('id_number', 'like', "%{$query}%")
            ->orWhere('full_name', 'like', "%{$query}%")
            ->orWhere('data->representative_full_name', 'like', "%{$query}%")
            ->limit(10)
            ->get()
            ->map(fn (Donor $donor) => [
                'id' => $donor->id,
                'full_name' => $donor->full_name,
                'id_number' => $donor->id_number,
                'email' => $donor->email,
                'tracking_code' => $donor->tracking_code,
            ]);

        return response()->json($donors);
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Donor::with('assignedHospital');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%")
                    ->orWhere('data->representative_full_name', 'like', "%{$search}%")
                    ->orWhere('data->id_number', 'like', "%{$search}%");
            });
        }

        if ($hospitalId = $request->input('hospital_id')) {
            $query->where('assigned_hospital_id', $hospitalId);
        }

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($outcomeStatus = $request->input('outcome_status')) {
            $query->where('outcome_status', $outcomeStatus);
        }

        if ($house = $request->input('house')) {
            $query->where('data->house_heroes', $house);
        }

        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $courses = Course::pluck('name', 'id');
        $donors = $query->latest()->get();

        $headers = [
            'ID', 'Tracking Code', 'Donor Type', 'ID Number', 'Full Name',
            'Email', 'Contact Number', 'Hospital', 'Course', 'Status',
            'Outcome Status', 'Staff Remarks',
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
                    $donor->outcome_status?->value ?? '',
                    $donor->staff_remarks ?? '',
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
