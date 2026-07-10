<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DonorController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Donor::with('assignedHospital', 'latestRegistration');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%");
            });
        }

        return Inertia::render('staff/donors/index', [
            'donors' => $query->latest()->paginate(20)->withQueryString()->through(function ($donor) {
                $registration = $donor->latestRegistration;

                return [
                    'id' => $donor->id,
                    'tracking_code' => $donor->tracking_code,
                    'full_name' => $donor->full_name,
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
}
