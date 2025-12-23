<?php

namespace App\Http\Controllers;

use App\Models\Retreat;
use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        // Load all retreats and events for the homepage
        $retreats = Retreat::orderBy('start_date')
            ->orderBy('start_time')
            ->get();

        $events = Event::orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('home', compact('retreats', 'events'));
    }
}
