<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventRsvpController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $userId = $request->user()->id;

        // Count how many are "going"
        $goingCount = $event->users()
            ->wherePivot('status', 'going')
            ->count();


        // If you have capacity + waitlist later, you’ll decide $status here.
        $status = 'going';

        if (!is_null($event->capacity) && $goingCount >= $event->capacity) {
            $status = 'waitlist';
        }

        // Create or update RSVP without duplicating pivot rows
        $event->users()->syncWithoutDetaching([
            $userId => [
                'status'   => $status,
                'rsvped_at'=> now(),
            ],
        ]);

        return back()->with('success', 'You are RSVP’d for this event.');
    }

    public function update(Request $request, Event $event)
    {
        $userId = $request->user()->id;

        // Validate allowed status changes
        $data = $request->validate([
            'status' => 'required|in:going,not_going,waitlist,cancelled',
        ]);

        // Make sure the user already has an RSVP
        if (! $event->users()->where('user_id', $userId)->exists()) {
            abort(403, 'You have not RSVP’d for this event.');
        }

        // 🔑 THIS IS THE LINE YOU ASKED ABOUT
        $event->users()->updateExistingPivot($userId, [
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Your RSVP has been updated.');
    }
}
