<?php

namespace App\Http\Controllers\Admin;

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
                    'hospital_name' => $donor->assignedHospital?->name,
                    'course_name' => isset($donor->data['course_id']) ? ($courses[$donor->data['course_id']] ?? null) : null,
                    'house_heroes_label' => $mapHouseOfHeroes($donor->data['house_heroes'] ?? null),
                    'data' => $donor->data,
                ];
            }),
            'hospitals' => $hospitals,
            'statuses' => $statuses,
            'houseOptions' => $houseOptions,
            'filters' => $request->only(['search', 'status', 'hospital_id', 'house']),
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
