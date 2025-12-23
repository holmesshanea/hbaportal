<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Retreat;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    /** Allowed constants for dropdown / validation */
    private const USER_ROLES = ['User', 'Admin', 'Super'];

    private const USER_STATUSES = ['Veteran', 'Staff'];

    private const USER_GENDERS = ['Male', 'Female', 'Other'];

    private const USER_BRANCHES = [
        'Airforce',
        'Airforce Reserve',
        'Army',
        'Army National Guard',
        'Army Reserve',
        'Coast Guard',
        'Coast Guard Reserve',
        'Marine Corps',
        'Marine Corps Reserve',
        'Navy',
        'Navy Reserve',
        'Other',
    ];

    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }

    /**
     * If you still call AdminController@index anywhere,
     * this will just redirect to the main Users tab.
     */
    public function index()
    {
        return redirect()->route('admin.users.index');
    }

    /* =========================================================
     * USERS CRUD
     * =======================================================*/

    /**
     * Show the dashboard with the Users table as the active section.
     * Route: GET /admin or /admin/users → name: admin.users.index
     */
    public function usersIndex()
    {
        $users = User::orderBy('name')->paginate(15);

        return view('admin.dashboard', [
            'section' => 'users',
            'users'         => $users,
            // You can optionally pass retreats/events if your view expects them
            'retreats'      => null,
            'events'        => null,
        ]);
    }

    /**
     * Show the "create user" form.
     * Route: GET /admin/users/create → name: admin.users.create
     */
    public function usersCreate()
    {
        return view('admin.users.create');
    }

    /**
     * Store a new User.
     * Route: POST /admin/users → name: admin.users.store
     */
    public function usersStore(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],

            // Password is hashed automatically via the cast on the User model.
            'password'              => ['required', 'string', 'min:8', 'confirmed'],

            'role'   => ['required', 'string', Rule::in(self::USER_ROLES)],
            'status' => ['required', 'string', Rule::in(self::USER_STATUSES)],
            'branch' => ['required', 'string', Rule::in(self::USER_BRANCHES)],
            'gender' => ['required', 'string', Rule::in(self::USER_GENDERS)],

            'phone'                   => ['required', 'string', 'max:12'],
            'emergency_contact_name'  => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:255'],

            'town'    => ['required', 'string', 'max:255'],
            'state'   => ['required', 'string', 'max:2', 'alpha'],
            'zipcode' => ['required', 'string', 'digits:5'],
        ]);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    /**
     * Show a single User.
     * Route: GET /admin/users/{user} → name: admin.users.show
     */
    public function usersShow(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the edit form for a User.
     * Route: GET /admin/users/{user}/edit → name: admin.users.edit
     */
    public function usersEdit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update a User.
     * Route: PUT /admin/users/{user} → name: admin.users.update
     */
    public function usersUpdate(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role'   => ['nullable', 'string', Rule::in(self::USER_ROLES)],
            'status' => ['nullable', 'string', Rule::in(self::USER_STATUSES)],
            'branch' => ['nullable', 'string', Rule::in(self::USER_BRANCHES)],
            'gender' => ['nullable', 'string', Rule::in(self::USER_GENDERS)],

            'phone'                   => ['nullable', 'string', 'max:255'],
            'emergency_contact_name'  => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:255'],

            'town'    => ['nullable', 'string', 'max:255'],
            'state'   => ['nullable', 'string', 'max:255'],
            'zipcode' => ['nullable', 'string', 'max:20'],

            // ✅ add these:
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ]);

        // Handle optional password change separately (keep your current behavior)
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);

            $data['password'] = $request->input('password'); // hashed via cast
        }

        // ✅ REMOVE current image if requested
        if ($request->boolean('remove_image') && $user->image) {
            if (Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            $data['image'] = null;
        }

        // ✅ REPLACE/UPLOAD new image
        if ($request->hasFile('image')) {
            // delete old file first
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            // store in storage/app/public/verification-images
            $data['image'] = $request->file('image')->store('verification-images', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }


    /**
     * Delete a User.
     * Route: DELETE /admin/users/{user} → name: admin.users.destroy
     */
    public function usersDestroy(User $user)
    {
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User deleted successfully.');
    }

    /* =========================================================
     * RETREATS CRUD
     * Retreat model fields: title, description, location,
     * start_date, start_time, end_date, end_time, capacity
     * =======================================================*/

    /**
     * Show Retreats list.
     * Route: GET /admin/retreats → name: admin.retreats.index
     */
    public function retreatsIndex()
    {
        $retreats = Retreat::orderBy('start_date', 'desc')->paginate(15);

        return view('admin.dashboard', [
            'section' => 'retreats',
            'users'         => null,
            'retreats'      => $retreats,
            'events'        => null,
        ]);
    }

    /**
     * Show create Retreat form.
     * Route: GET /admin/retreats/create → name: admin.retreats.create
     */
    public function retreatsCreate()
    {
        return view('admin.retreats.create');
    }

    /**
     * Store a new Retreat.
     * Route: POST /admin/retreats → name: admin.retreats.store
     */
    public function retreatsStore(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'start_date'  => ['required', 'date'],
            'start_time'  => ['nullable', 'date_format:H:i'],

            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'end_time'    => ['nullable', 'date_format:H:i'],

            'capacity'    => ['nullable', 'integer', 'min:0'],

            // image is now a file upload
            'image'       => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            // stores in storage/app/public/retreats
            $data['image'] = $request->file('image')->store('retreats', 'public');
        }

        Retreat::create($data);

        return redirect()
            ->route('admin.retreats.index')
            ->with('status', 'Retreat created successfully.');
    }


    /**
     * Show a single Retreat.
     * Route: GET /admin/retreats/{retreat} → name: admin.retreats.show
     */
    public function retreatsShow(Retreat $retreat)
    {
        return view('admin.retreats.show', compact('retreat'));
    }

    /**
     * Show edit Retreat form.
     * Route: GET /admin/retreats/{retreat}/edit → name: admin.retreats.edit
     */
    public function retreatsEdit(Retreat $retreat)
    {
        return view('admin.retreats.edit', compact('retreat'));
    }

    /**
     * Update a Retreat.
     * Route: PUT /admin/retreats/{retreat} → name: admin.retreats.update
     */
    public function retreatsUpdate(Request $request, Retreat $retreat)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'start_date'  => ['required', 'date'],
            'start_time'  => ['nullable', 'date_format:H:i'],

            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'end_time'    => ['nullable', 'date_format:H:i'],

            'capacity'    => ['nullable', 'integer', 'min:0'],

            'image'       => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            // optional: clean up old file
            if ($retreat->image && Storage::disk('public')->exists($retreat->image)) {
                Storage::disk('public')->delete($retreat->image);
            }

            $data['image'] = $request->file('image')->store('retreats', 'public');
        }

        $retreat->update($data);

        return redirect()
            ->route('admin.retreats.index')
            ->with('status', 'Retreat updated successfully.');
    }


    /**
     * Delete a Retreat.
     * Route: DELETE /admin/retreats/{retreat} → name: admin.retreats.destroy
     */
    public function retreatsDestroy(Retreat $retreat)
    {
        $retreat->delete();

        return redirect()
            ->route('admin.retreats.index')
            ->with('status', 'Retreat deleted successfully.');
    }

    /* =========================================================
     * EVENTS CRUD
     * Event model fields: title, description, location,
     * date, start_time, end_time, capacity
     * =======================================================*/

    /**
     * Show Events list.
     * Route: GET /admin/events → name: admin.events.index
     */
    public function eventsIndex()
    {
        $events = Event::orderBy('date', 'desc')->paginate(15);

        return view('admin.dashboard', [
            'section' => 'events',
            'users'         => null,
            'retreats'      => null,
            'events'        => $events,
        ]);
    }

    /**
     * Show create Event form.
     * Route: GET /admin/events/create → name: admin.events.create
     */
    public function eventsCreate()
    {
        return view('admin.events.create');
    }

    /**
     * Store a new Event.
     * Route: POST /admin/events → name: admin.events.store
     */
    public function eventsStore(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'date'        => ['required', 'date'],
            'start_time'  => ['nullable', 'date_format:H:i'],
            'end_time'    => ['nullable', 'date_format:H:i'],

            'capacity'    => ['nullable', 'integer', 'min:0'],

            'image'       => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('events', 'public');
        }

        Event::create($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event created successfully.');
    }


    /**
     * Show a single Event.
     * Route: GET /admin/events/{event} → name: admin.events.show
     */
    public function eventsShow(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show edit Event form.
     * Route: GET /admin/events/{event}/edit → name: admin.events.edit
     */
    public function eventsEdit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update an Event.
     * Route: PUT /admin/events/{event} → name: admin.events.update
     */
    public function eventsUpdate(Request $request, Event $event)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'date'        => ['required', 'date'],
            'start_time'  => ['nullable', 'date_format:H:i'],
            'end_time'    => ['nullable', 'date_format:H:i'],

            'capacity'    => ['nullable', 'integer', 'min:0'],

            'image'       => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            $data['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event updated successfully.');
    }


    /**
     * Delete an Event.
     * Route: DELETE /admin/events/{event} → name: admin.events.destroy
     */
    public function eventsDestroy(Event $event)
    {
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event deleted successfully.');
    }
}
