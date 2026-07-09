<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

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
                    'surname' => $donor->data['surname'] ?? '',
                    'given_name' => $donor->data['given_name'] ?? '',
                    'blood_type' => $donor->data['blood_type'] ?? '',
                    'email' => $donor->email,
                    'contact_number' => $donor->contact_number,
                ];
            }),
            'filters' => $request->only(['search', 'status', 'hospital_id']),
        ]);
    }
}
