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

    public function donors(BloodDonationEvent $event): Response
    {
        $registrations = $event->registrations()
            ->with('donor')
            ->latest()
            ->paginate(20)
            ->through(function ($registration) {
                return [
                    'id' => $registration->id,
                    'given_name' => $registration->donor->data['given_name'] ?? '',
                    'surname' => $registration->donor->data['surname'] ?? '',
                    'blood_type' => $registration->donor->data['blood_type'] ?? '',
                    'created_at' => $registration->created_at->toDateTimeString(),
                ];
            });

        return Inertia::render('admin/events/donors', [
            'event' => $event->only(['id', 'name', 'event_date', 'venue']),
            'registrations' => $registrations,
        ]);
    }
}
