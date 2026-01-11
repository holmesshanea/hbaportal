<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function show(Event $event)
    {
        if (auth()->check() && ! auth()->user()->profile_confirmed) {
            session()->flash(
                'profile-incomplete',
                'In order to RSVP to an Event or Retreat, you must complete your profile. Click the profile link in the main menu to complete your profile.'
            );
        }

        return view('events.show', compact('event'));
    }
}
