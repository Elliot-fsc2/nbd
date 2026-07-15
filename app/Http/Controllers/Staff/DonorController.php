<?php

namespace App\Http\Controllers\Staff;

use App\Enums\HouseOfHeroes;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Donor;
use App\Services\PdfGenerationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DonorController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = Course::pluck('name', 'id');

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

        $mapHouseOfHeroes = function (?string $value): ?string {
            return match ($value) {
                null => null,
                'member' => 'Member',
                'non_member' => 'Non-member',
                default => HouseOfHeroes::tryFrom($value)?->label() ?? $value,
            };
        };

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
                    'data' => $donor->data,
                ];
            }),
            'filters' => $request->only(['search']),
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
