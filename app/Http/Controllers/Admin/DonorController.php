<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Services\PdfGenerationService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class DonorController extends Controller
{
    public function index(Request $request): Response
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

        if ($hospitalId = $request->get('hospital_id')) {
            $query->where('assigned_hospital_id', $hospitalId);
        }

        return Inertia::render('admin/donors/index', [
            'donors' => $query->latest()->paginate(20)->withQueryString()->through(function ($donor) {
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
                    'data' => $donor->data,
                ];
            }),
            'filters' => $request->only(['search', 'status', 'hospital_id']),
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
