<?php

namespace App\Http\Controllers\Staff;

use App\Enums\DonorOutcomeStatus;
use App\Http\Controllers\Controller;
use App\Mail\QueueCalledMail;
use App\Models\BloodDonationEvent;
use App\Models\Donor;
use App\Models\EventRegistration;
use Illuminate\Http\JsonResponse;
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
            ->get();

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

    public function eventQueue(Request $request, BloodDonationEvent $event): Response
    {
        $current = $event->registrations()
            ->with('donor', 'hospital')
            ->where('status', 'in_progress')
            ->get();

        $waiting = $event->registrations()
            ->with('donor', 'hospital')
            ->where('status', 'checked_in')
            ->orderBy('queue_number')
            ->take(100)
            ->get();

        $completedQuery = $event->registrations()
            ->with('donor', 'hospital')
            ->whereIn('status', ['completed', 'skipped']);

        if ($search = $request->query('search')) {
            $completedQuery->whereHas('donor', function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        $completed = $completedQuery->latest()->take(50)->get();

        return Inertia::render('staff/queue/event-queue', [
            'event' => $event,
            'current' => $current,
            'waiting' => $waiting,
            'completed' => $completed,
        ]);
    }

    public function checkIn(Request $request, BloodDonationEvent $event): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'donor_id' => ['required', 'integer', 'exists:donors,id'],
        ]);

        $donor = Donor::findOrFail($validated['donor_id']);

        $existingRegistration = EventRegistration::where('donor_id', $donor->id)
            ->where('event_id', $event->id)
            ->first();

        if ($existingRegistration) {
            if ($donor->outcome_status === DonorOutcomeStatus::Rescheduled) {
                $existingRegistration->update(['status' => 'registered']);
            } elseif ($existingRegistration->status !== 'registered') {
                $error = 'Donor is already checked in for this event.';

                return $request->wantsJson()
                    ? response()->json(['error' => $error], 422)
                    : back()->withErrors(['donor_id' => $error]);
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

        if ($request->wantsJson()) {
            return response()->json([
                'queue_number' => $queueNumber,
                'donor_name' => $donor->full_name,
                'event_name' => $event->name,
            ]);
        }

        return redirect()->route('staff.events.queue', $event)
            ->with('success', "Donor checked in. Queue number: {$queueNumber}")
            ->with('last_checked_in', [
                'queue_number' => $queueNumber,
                'donor_name' => $donor->full_name,
                'event_name' => $event->name,
            ]);
    }

    public function next(EventRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'in_progress',
            'called_at' => now(),
        ]);

        $registration->donor->update(['status' => 'in_progress']);

        // Mail::to($registration->donor->email)->queue(new QueueCalledMail($registration));

        return back()->with('success', 'Donor called.');
    }

    public function complete(EventRegistration $registration): RedirectResponse
    {
        $registration->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);

        $registration->donor->update([
            'status' => 'completed',
            'outcome_status' => DonorOutcomeStatus::Completed,
        ]);

        return back()->with('success', 'Donor marked as completed.');
    }

    public function skip(EventRegistration $registration): RedirectResponse
    {
        $registration->update(['status' => 'skipped']);

        $registration->donor->update([
            'status' => 'skipped',
            'outcome_status' => DonorOutcomeStatus::Rescheduled,
        ]);

        return back()->with('success', 'Donor skipped.');
    }
}
