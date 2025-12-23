<?php

namespace App\Http\Controllers;

use App\Models\Retreat;
use Illuminate\Http\Request;

class RetreatRsvpController extends Controller
{
    public function store(Request $request, Retreat $retreat)
    {
        $userId = $request->user()->id;

        // Count how many are "going"
        $goingCount = $retreat->users()
            ->wherePivot('status', 'going')
            ->count();

        // If you have capacity + waitlist later, you’ll decide $status here.
        $status = 'going';

        if (!is_null($retreat->capacity) && $goingCount >= $retreat->capacity) {
            $status = 'waitlist';
        }

        // Create or update RSVP without duplicating pivot rows
        $retreat->users()->syncWithoutDetaching([
            $userId => [
                'status'   => $status,
                'rsvped_at'=> now(),
            ],
        ]);

        return back()->with('success', 'You are RSVP’d for this retreat.');
    }

    public function update(Request $request, Retreat $retreat)
    {
        $userId = $request->user()->id;

        // Validate allowed status changes
        $data = $request->validate([
            'status' => 'required|in:going,not_going,waitlist,cancelled',
        ]);

        // Make sure the user already has an RSVP
        if (! $retreat->users()->where('user_id', $userId)->exists()) {
            abort(403, 'You have not RSVP’d for this retreat.');
        }

        // 🔑 THIS IS THE LINE YOU ASKED ABOUT
        $retreat->users()->updateExistingPivot($userId, [
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Your RSVP has been updated.');
    }
}
