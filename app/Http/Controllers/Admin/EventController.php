<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodDonationEvent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        $events = BloodDonationEvent::withCount('registrations')->latest()->get()->map(function ($event) {
            return [
                ...$event->toArray(),
                'event_date' => $event->event_date->isoFormat('MMMM D, YYYY'),
            ];
        });

        return Inertia::render('admin/events/index', [
            'events' => $events,
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('admin/events/form', [
            'event' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'venue' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:upcoming,ongoing,completed'],
        ]);

        BloodDonationEvent::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(BloodDonationEvent $event): Response
    {
        return Inertia::render('admin/events/form', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, BloodDonationEvent $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date'],
            'venue' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'string', 'in:upcoming,ongoing,completed'],
        ]);

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function destroy(BloodDonationEvent $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    public function donors(Request $request, BloodDonationEvent $event): Response
    {
        $query = $event->registrations()->with('donor');

        if ($search = $request->input('search')) {
            $query->whereHas('donor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('tracking_code', 'like', "%{$search}%")
                    ->orWhere('data->given_name', 'like', "%{$search}%")
                    ->orWhere('data->surname', 'like', "%{$search}%");
            });
        }

        $registrations = $query->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(function ($registration) {
                return [
                    'id' => $registration->id,
                    'given_name' => $registration->donor->data['given_name'] ?? '',
                    'surname' => $registration->donor->data['surname'] ?? '',
                    'blood_type' => $registration->donor->data['blood_type'] ?? '',
                    'created_at' => $registration->created_at->isoFormat('MMM D, YYYY, h:mm A'),
                ];
            });

        return Inertia::render('admin/events/donors', [
            'event' => [
                'id' => $event->id,
                'name' => $event->name,
                'event_date' => $event->event_date->isoFormat('MMMM D, YYYY'),
                'venue' => $event->venue,
            ],
            'registrations' => $registrations,
            'filters' => $request->only(['search']),
        ]);
    }
}
