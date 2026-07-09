<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Mail\QueueCalledMail;
use App\Models\BloodDonationEvent;
use App\Models\Donor;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class QueueController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('staff/queue/index', [
            'events' => BloodDonationEvent::whereIn('status', ['upcoming', 'ongoing'])->latest()->get(),
        ]);
    }

    public function display(BloodDonationEvent $event): Response
    {
        $current = $event->registrations()
            ->with('donor', 'hospital')
            ->where('status', 'in_progress')
            ->first();

        $next = $event->registrations()
            ->with('donor', 'hospital')
            ->where('status', 'checked_in')
            ->orderBy('queue_number')
            ->take(3)
            ->get();

        $waiting = $event->registrations()
            ->with('donor', 'hospital')
            ->where('status', 'checked_in')
            ->orderBy('queue_number')
            ->get();

        return Inertia::render('staff/queue/display', [
            'event' => $event,
            'current' => $current,
            'next' => $next,
            'waiting' => $waiting,
        ]);
    }

    public function eventQueue(BloodDonationEvent $event): Response
    {
        $current = $event->registrations()
            ->with('donor')
            ->where('status', 'in_progress')
            ->first();

        $waiting = $event->registrations()
            ->with('donor')
            ->where('status', 'checked_in')
            ->orderBy('queue_number')
            ->get();

        $completed = $event->registrations()
            ->with('donor')
            ->whereIn('status', ['completed', 'skipped'])
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('staff/queue/event-queue', [
            'event' => $event,
            'current' => $current,
            'waiting' => $waiting,
            'completed' => $completed,
        ]);
    }

    public function checkIn(Request $request, BloodDonationEvent $event): RedirectResponse
    {
        $validated = $request->validate([
            'id_number' => ['required', 'string'],
        ]);

        $donor = Donor::where('id_number', $validated['id_number'])->first();

        if (! $donor) {
            return back()->withErrors(['id_number' => 'No donor found with that ID number.']);
        }

        $existingRegistration = EventRegistration::where('donor_id', $donor->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existingRegistration) {
            if ($existingRegistration->status !== 'registered') {
                return back()->withErrors(['id_number' => 'Donor is already checked in for this event.']);
            }
        }

        $lastQueueNumber = EventRegistration::where('event_id', $event->id)
            ->whereNotNull('queue_number')
            ->orderBy('queue_number', 'desc')
            ->value('queue_number');

        $nextNumber = $lastQueueNumber ? intval(substr($lastQueueNumber, -3)) + 1 : 1;
        $queueNumber = strtoupper(substr($event->name, 0, 3)).'-'.str_pad((string) $nextNumber, 3, '0', STR_PAD_LEFT);

        if ($existingRegistration) {
            $existingRegistration->update([
                'status' => 'checked_in',
                'queue_number' => $queueNumber,
                'checked_in_by' => $request->user()->id,
                'checked_in_at' => now(),
            ]);
        } else {
            EventRegistration::create([
                'donor_id' => $donor->id,
                'event_id' => $event->id,
                'hospital_id' => $donor->assigned_hospital_id,
                'queue_number' => $queueNumber,
                'status' => 'checked_in',
                'checked_in_by' => $request->user()->id,
                'checked_in_at' => now(),
            ]);
        }

        $donor->update(['status' => 'checked_in']);

        return redirect()->route('staff.events.queue', $event)->with('success', "Donor checked in. Queue number: {$queueNumber}");
    }

    public function next(EventRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'in_progress',
            'called_at' => now(),
        ]);

        $registration->donor->update(['status' => 'in_progress']);

        Mail::to($registration->donor->email)->send(new QueueCalledMail($registration));

        return back()->with('success', 'Donor called.');
    }

    public function complete(EventRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $registration->donor->update(['status' => 'completed']);

        return back()->with('success', 'Donor marked as completed.');
    }

    public function skip(EventRegistration $registration): RedirectResponse
    {
        $registration->update(['status' => 'skipped']);
        $registration->donor->update(['status' => 'skipped']);

        return back()->with('success', 'Donor skipped.');
    }
}
