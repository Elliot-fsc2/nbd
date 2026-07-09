<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodDonationEvent;
use App\Models\Donor;
use App\Models\Hospital;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        return Inertia::render('admin/dashboard', [
            'stats' => [
                'total_donors' => Donor::count(),
                'total_hospitals' => Hospital::count(),
                'total_events' => BloodDonationEvent::count(),
                'total_users' => User::count(),
                'recent_donors' => Donor::latest()->take(5)->get(),
                'upcoming_events' => BloodDonationEvent::where('status', 'upcoming')->take(5)->get(),
            ],
        ]);
    }
}
