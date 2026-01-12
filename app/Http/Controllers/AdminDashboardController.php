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

    private const EVENT_TYPES = ['retreat', 'event'];
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
    public function usersIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $filter = trim((string) $request->query('filter', '')); // role

        // Dropdown options (unique roles)
        $roleOptions = User::query()
            ->select('role')
            ->whereNotNull('role')
            ->where('role', '!=', '')
            ->distinct()
            ->orderBy('role')
            ->pluck('role');

        $users = User::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('first_name', 'like', "%{$q}%")
                        ->orWhere('last_name', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('role', 'like', "%{$q}%")
                        ->orWhere('status', 'like', "%{$q}%");
                });
            })
            ->when($filter !== '', fn ($query) => $query->where('role', $filter))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard', [
            'section' => 'users',
            'users' => $users,
            'events' => null,
            'retreats' => null,

            // pass dropdown options
            'roleOptions' => $roleOptions,
            'eventTypeOptions' => collect(), // keep defined for blade simplicity
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
            'first_name'  => ['required', 'string', 'min:3', 'max:255'],
            'last_name'  => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],

            // Password is hashed automatically via the cast on the User model.
            'password'              => ['required', 'string', 'min:8', 'confirmed'],

            'role'   => ['required', 'string', Rule::in(self::USER_ROLES)],
            'status' => ['required', 'string', Rule::in(self::USER_STATUSES)],
            'profile_confirmed' => ['required', 'boolean'],
            'branch' => ['required', 'string', Rule::in(self::USER_BRANCHES)],
            'combat' => ['required', 'boolean'],
            'gender' => ['required', 'string', Rule::in(self::USER_GENDERS)],

            'phone'                   => ['required', 'string', 'max:12'],
            'emergency_contact_name'  => ['required', 'string', 'max:255'],
            'emergency_contact_phone' => ['required', 'string', 'max:255'],

            'town'    => ['required', 'string', 'max:255'],
            'state'   => ['required', 'string', 'max:2', 'alpha'],
            'zipcode' => ['required', 'string', 'digits:5'],
        ]);

        $data['email_verified_at'] = now();

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
        $user->load([
            'events' => fn ($query) => $query
                ->orderBy('start_date', 'desc')
                ->orderBy('title'),
        ]);
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
            'first_name'  => ['required', 'string', 'min:3', 'max:255'],
            'last_name'  => ['required', 'string', 'min:3', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role'   => ['nullable', 'string', Rule::in(self::USER_ROLES)],
            'status' => ['nullable', 'string', Rule::in(self::USER_STATUSES)],
            'profile_confirmed' => ['required', 'boolean'],
            'branch' => ['nullable', 'string', Rule::in(self::USER_BRANCHES)],
            'combat' => ['required', 'boolean'],
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

        if ($request->filled('email') && $request->input('email') !== $user->email) {
            $data['email_verified_at'] = now();
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
     * EVENTS CRUD
     * Event model fields: title, description, location,
     * date, start_time, end_time, capacity
     * =======================================================*/

    /**
     * Show Events list.
     * Route: GET /admin/events → name: admin.events.index
     */
    public function eventsIndex(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $filter = trim((string) $request->query('filter', '')); // event_type

        // Dropdown options (unique event types)
        $eventTypeOptions = Event::query()
            ->select('event_type')
            ->whereNotNull('event_type')
            ->where('event_type', '!=', '')
            ->distinct()
            ->orderBy('event_type')
            ->pluck('event_type');

        $events = Event::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('start_date', 'like', "%{$q}%")
                        ->orWhere('start_time', 'like', "%{$q}%")
                        ->orWhere('location', 'like', "%{$q}%")
                        ->orWhere('short_description', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%")
                        ->orWhere('event_type', 'like', "%{$q}%");
                });
            })
            ->when($filter !== '', fn ($query) => $query->where('event_type', $filter))
            ->orderBy('start_date', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.dashboard', [
            'section' => 'events',
            'users' => null,
            'events' => $events,
            'retreats' => null,

            // pass dropdown options
            'roleOptions' => collect(),
            'eventTypeOptions' => $eventTypeOptions,
        ]);
    }



    /**
     * Show create Event form.
     * Route: GET /admin/events/create → name: admin.events.create
     */
    public function eventsCreate()
    {
        return view('admin.events.create', [
            'event' => new \App\Models\Event(),
        ]);
    }

    /**
     * Store a new Event.
     * Route: POST /admin/events → name: admin.events.store
     */
    public function eventsStore(Request $request)
    {
        $data = $request->validate([
            'event_type' => ['required', Rule::in(self::EVENT_TYPES)],
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'start_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],

            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'end_time' => ['nullable', 'date_format:H:i'],

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
        $event->load([
            'users' => fn ($query) => $query
                ->orderBy('last_name')
                ->orderBy('first_name'),
        ]);
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
            'event_type' => ['required', Rule::in(self::EVENT_TYPES)],
            'title'       => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'location'    => ['nullable', 'string', 'max:255'],

            'start_date' => ['required', 'date'],
            'start_time' => ['nullable', 'date_format:H:i'],

            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'end_time' => ['nullable', 'date_format:H:i'],

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
