<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date')
            ->orderBy('start_time')
            ->paginate(3); // 👈 THIS is the key change

        return view('home', compact('events'));
    }
}

