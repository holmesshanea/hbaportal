<?php

namespace App\Http\Controllers;

use App\Models\Retreat;
use App\Models\Event;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Require authentication for all dashboard routes.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Root user dashboard.
     *
     * Route: GET /dashboard → name: dashboard
     * Just redirect to the default section (retreats), like AdminController@index.
     */
    public function index()
    {
        return redirect()->route('dashboard.retreats');
    }

    /**
     * Show the dashboard with the Retreats section active.
     *
     * Route: GET /dashboard/retreats → name: dashboard.retreats
     */
    public function retreatsIndex()
    {
        // TODO: adjust this query to match how you relate users to retreats.
        // For now, this is the same pattern as admin: just list all retreats.
        $retreats = Retreat::orderBy('start_date', 'desc')->paginate(10);

        return view('user.dashboard', [
            'section'  => 'retreats',
            'retreats' => $retreats,
            'events'   => null,
        ]);
    }

    /**
     * Show the dashboard with the Events section active.
     *
     * Route: GET /dashboard/events → name: dashboard.events
     */
    public function eventsIndex()
    {
        // TODO: adjust this query to only show events relevant to the logged-in user.
        $events = Event::orderBy('date', 'desc')->paginate(10);

        return view('user.dashboard', [
            'section'  => 'events',
            'retreats' => null,
            'events'   => $events,
        ]);
    }
}
