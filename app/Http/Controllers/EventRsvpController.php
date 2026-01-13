<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Question;
use Illuminate\Http\Request;

class EventRsvpController extends Controller
{
    /**
     * Show the RSVP questions form (one set of answers per user + event).
     */
    public function createQuestions(Request $request, Event $event)
    {
        $user = $request->user();
        if (! $user->profile_confirmed && ! $user->isAdminOrSuper()) {
            abort(403, 'Your profile must be confirmed before you can RSVP.');
        }

        if ($event->status === Event::STATUS_CLOSED) {
            return redirect()
                ->route('home')
                ->withErrors(['status' => 'This event is closed.']);
        }

        // If you’re passing a desired status via querystring (optional)
        $status = $request->query('status', 'going');

        return view('events.rsvp-questions', compact('event', 'status'));
    }

    public function store(Request $request, Event $event)
    {
        $user = $request->user();
        $userId = $user->id;

        if (! $user->profile_confirmed && ! $user->isAdminOrSuper()) {
            abort(403, 'Your profile must be confirmed before you can RSVP.');
        }

        if ($event->status === Event::STATUS_CLOSED) {
            return redirect()
                ->route('home')
                ->withErrors(['status' => 'This event is closed.']);
        }

        // RSVP questions validation

        $data = $request->validate(
            [
                'expect'    => ['required', 'string'],
                'suffer'    => ['nullable', 'string'],
                'allergies' => ['nullable', 'string'],
                'concerns'  => ['nullable', 'string'],
                'conduct'   => ['required', 'in:Agree'],
            ],
            [
                'conduct.in' => 'You must enter "Agree" exactly to RSVP.',
            ]
        );


        // Normalize defaults for optional fields
        foreach (['suffer', 'allergies', 'concerns'] as $field) {
            $data[$field] = filled($data[$field] ?? null) ? $data[$field] : 'None';
        }

        // Count how many are "going"
        $goingCount = $event->users()
            ->wherePivot('status', 'going')
            ->count();

        // If you have capacity + waitlist later, you’ll decide $status here.
        $status = 'going';

        if (!is_null($event->capacity) && $goingCount >= $event->capacity) {
            $status = 'waitlist';
        }

        // Save questions (unique per user+event)
        Question::updateOrCreate(
            ['user_id' => $userId, 'event_id' => $event->id],
            [
                'expect'    => $data['expect'],
                'suffer'    => $data['suffer'],
                'allergies' => $data['allergies'],
                'concerns'  => $data['concerns'],
                'conduct'   => $data['conduct'],
            ]
        );

        // Create or update RSVP without duplicating pivot rows
        $event->users()->syncWithoutDetaching([
            $userId => [
                'status'    => $status,
                'rsvped_at' => now(),
            ],
        ]);

        $event->closeIfFull();

        return redirect()
            ->route('home')
            ->with('success', 'You are RSVP’d for this event.');
    }

    public function update(Request $request, Event $event)
    {
        $user = $request->user();
        $userId = $user->id;

        if (! $user->profile_confirmed && ! $user->isAdminOrSuper()) {
            abort(403, 'Your profile must be confirmed before you can RSVP.');
        }

        // Validate allowed status changes
        $data = $request->validate([
            'status' => 'required|in:going,not_going,waitlist,cancelled',
        ]);

        if (
            $event->status === Event::STATUS_CLOSED
            && in_array($data['status'], ['going', 'waitlist'], true)
        ) {
            return back()->withErrors(['status' => 'This event is closed.']);
        }

        // Make sure the user already has an RSVP
        if (! $event->users()->where('user_id', $userId)->exists()) {
            abort(403, 'You have not RSVP’d for this event.');
        }
        $currentPivot = $event->users()->where('user_id', $userId)->first()->pivot;

        // Enforce capacity when trying to switch to "going"
        if ($data['status'] === 'going' && ! is_null($event->capacity)) {
            $currentGoingCount = $event->users()
                ->wherePivot('status', 'going')
                ->count();

            // If the user is already marked as going, exclude them from the count
            if ($currentPivot->status === 'going') {
                $currentGoingCount -= 1;
            }

            if ($currentGoingCount >= $event->capacity) {
                return back()->withErrors([
                    'status' => 'This event is currently full. You remain on the waitlist.',
                ]);
            }
        }

        $event->users()->updateExistingPivot($userId, [
            'status'    => $data['status'],
            'rsvped_at' => now(),
        ]);

        if ($data['status'] === 'going') {
            $event->closeIfFull();
        }

        return back()->with('success', 'Your RSVP has been updated.');
    }
}
