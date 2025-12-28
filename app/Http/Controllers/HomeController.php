<?php

namespace App\Http\Controllers;

use App\Models\Event;

class HomeController extends Controller
{
    public function index()
    {
                $events = Event::orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('home', compact('events'));
    }
}
