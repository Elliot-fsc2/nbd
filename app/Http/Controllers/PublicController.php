<?php

namespace App\Http\Controllers;

use App\Enums\HouseOfHeroes;
use App\Mail\DonorFormMail;
use App\Models\Course;
use App\Models\Donor;
use App\Services\HospitalAssignmentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    public function __construct(
        protected HospitalAssignmentService $assignmentService,
    ) {}

    public function form(): Response
    {
        return Inertia::render('welcome', [
            'courses' => Cache::remember('courses', 3600, fn () => Course::with('department:id,name')->orderBy('name')->get()->toArray()),
            'houseOfHeroes' => collect(HouseOfHeroes::cases())->map(fn ($case) => [
                'value' => $case->value,
                'label' => $case->name,
            ]),
        ]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donor_type' => ['nullable', 'string', 'in:student,employee,representative'],
            'id_number' => ['nullable', 'string', Rule::unique('donors', 'id_number')],
            'representative_full_name' => ['nullable', 'string', 'regex:/^[\pL\s.\-\']*$/u'],

            'surname' => ['required', 'string', 'regex:/^[\pL\s.\-\']+$/u'],
            'given_name' => ['required', 'string', 'regex:/^[\pL\s.\-\']+$/u'],
            'middle_name' => ['nullable', 'string', 'regex:/^[\pL\s.\-\']*$/u'],
            'birthdate' => ['required', 'date'],
            'age' => ['required', 'integer', 'min:1', 'max:150'],
            'sex' => ['required', 'string', 'in:male,female'],
            'civil_status' => ['required', 'string', 'in:single,married,divorced,widowed'],
            'blood_type' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-,Unknown,unknown'],
            'occupation' => ['nullable', 'string', 'regex:/^[\pL\pN\s.,\-\']+$/u'],

            'house_no' => ['nullable', 'string'],
            'street' => ['nullable', 'string'],
            'subdivision' => ['nullable', 'string', 'regex:/^[\pL\pN\s.,\-\']*$/u'],
            'barangay' => ['nullable', 'string', 'regex:/^[\pL\s.\-\']+$/u'],
            'city_province' => ['nullable', 'string', 'regex:/^[\pL\s.\-\']+$/u'],

            'email' => ['required', 'email', app()->isProduction() ? Rule::unique('donors', 'email') : ''],
            'contact_number' => ['nullable', 'string', 'regex:/^(09|\+639)\d{9}$/'],
            'course_id' => ['nullable', 'string'],
            'year_section' => ['nullable', 'string'],
            'house_heroes' => ['nullable', 'string', Rule::enum(HouseOfHeroes::class)],

            'consent' => ['required', 'accepted'],
        ]);

        $donorType = $validated['donor_type'] ?: 'student';

        $fullName = trim("{$validated['surname']}, {$validated['given_name']} {$validated['middle_name']}");

        $idNumber = $validated['id_number'] ?? null;

        $hospital = $this->assignmentService->assign();

        $donor = Donor::create([
            'tracking_code' => Str::random(10),
            'donor_type' => $donorType,
            'id_number' => $idNumber,
            'full_name' => $fullName,
            'email' => $validated['email'],
            'contact_number' => $validated['contact_number'],
            'assigned_hospital_id' => $hospital->id,
            'data' => $validated,
            'status' => 'registered',
        ]);

        Mail::to($donor->email)->queue(new DonorFormMail($donor));

        return redirect()->route('home')->with('success', 'Your form has been submitted successfully! Please check your email for the PDF.');
    }
}
