@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">
            @php
                /**
                 * Event type presentation map
                 * - Color coding (badge + left accent)
                 * - Iconography
                 * - Small header/badge text
                 */
                $eventTypeStyles = [
                    'event' => [
                        'label' => 'Event',
                        'icon'  => '📅',
                        'accent' => 'border-l-sky-500 dark:border-l-sky-400',
                        'badge'  => 'bg-sky-100 text-sky-900 border-sky-200 dark:bg-sky-900/30 dark:text-sky-200 dark:border-sky-800',
                    ],
                    'retreat' => [
                        'label' => 'Retreat',
                        'icon'  => '🏕️',
                        'accent' => 'border-l-emerald-600 dark:border-l-emerald-400',
                        'badge'  => 'bg-emerald-100 text-emerald-900 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:border-emerald-800',
                    ],
                    'default' => [
                        'label' => 'Other',
                        'icon'  => '📌',
                        'accent' => 'border-l-zinc-400 dark:border-l-zinc-500',
                        'badge'  => 'bg-zinc-100 text-zinc-900 border-zinc-200 dark:bg-zinc-900/30 dark:text-zinc-200 dark:border-zinc-800',
                    ],
                ];

                $typeKey = strtolower($event->event_type ?? 'event');
                $typeMeta = $eventTypeStyles[$typeKey] ?? $eventTypeStyles['default'];

                // Date handling (supports either start_date/end_date OR date)
                $startDateValue = $event->start_date ?? $event->date ?? null;
                $endDateValue   = $event->end_date ?? null;

                $startDateFormatted = $startDateValue ? \Carbon\Carbon::parse($startDateValue)->format('d F, Y') : null;
                $endDateFormatted   = $endDateValue ? \Carbon\Carbon::parse($endDateValue)->format('d F, Y') : null;

                // Google Maps link + embed
                $mapsQuery = $event->location ? urlencode($event->location) : null;
                $mapsLink = $mapsQuery ? "https://www.google.com/maps?q={$mapsQuery}" : null;
                $mapsEmbed = $mapsQuery ? "https://www.google.com/maps?q={$mapsQuery}&output=embed" : null;
            @endphp

            @if(session('success'))
                <div class="mt-4 inline-flex items-center rounded border border-green-200 bg-green-50 px-4 py-2 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('profile-incomplete'))
                <div class="mt-4 inline-flex items-center rounded border border-amber-200 bg-amber-50 px-4 py-2 text-amber-800 text-sm">
                    {{ session('profile-incomplete') }}
                </div>
            @endif

            @if($errors->has('status'))
                <div class="mt-4 inline-flex items-center rounded border border-red-200 bg-red-50 px-4 py-2 text-red-800 text-sm">
                    {{ $errors->first('status') }}
                </div>
            @endif

            <h1 class="text-base font-semibold mb-4 flex items-center justify-between gap-3">
                <span>Event Details</span>

                {{-- Type badge (icon + text + color) --}}
                <span
                    class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $typeMeta['badge'] }}"
                    role="note"
                    aria-label="Type: {{ $typeMeta['label'] }}"
                    title="{{ $typeMeta['label'] }}"
                >
                    <span aria-hidden="true">{{ $typeMeta['icon'] }}</span>
                    <span>{{ $typeMeta['label'] }}</span>
                </span>
            </h1>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs border-l-4 {{ $typeMeta['accent'] }}">
                <table class="min-w-full">
                    <tbody>

                    @if ($event->image)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">Image</th>
                            <td class="px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <img
                                        src="{{ asset('storage/' . $event->image) }}"
                                        alt="Event image"
                                        class="max-w-xs rounded border"
                                    >
                                </div>
                            </td>
                        </tr>
                    @endif

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Type</th>
                        <td class="px-3 py-2">
                            <span
                                class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $typeMeta['badge'] }}"
                                role="note"
                                aria-label="Type: {{ $typeMeta['label'] }}"
                                title="{{ $typeMeta['label'] }}"
                            >
                                <span aria-hidden="true">{{ $typeMeta['icon'] }}</span>
                                <span>{{ $typeMeta['label'] }}</span>
                            </span>
                        </td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Title</th>
                        <td class="px-3 py-2">{{ $event->title }}</td>
                    </tr>

                    {{-- Short Description REMOVED (per request) --}}

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Description</th>
                        <td class="px-3 py-2">
                            <div class="
                                [&_a]:underline
                                [&_a]:text-blue-600
                                dark:[&_a]:text-blue-400
                                [&_a:hover]:text-blue-800
                                dark:[&_a:hover]:text-blue-300
                                [&_p]:mb-2
                                [&_ul]:list-disc
                                [&_ul]:pl-5
                                [&_ol]:list-decimal
                                [&_ol]:pl-5
                            ">
                                {!! $event->description !!}
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Location</th>
                        <td class="px-3 py-2">
                            @if($mapsLink)
                                <a
                                    href="{{ $mapsLink }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-sky-700 dark:text-sky-300 hover:underline break-words"
                                >
                                    {{ $event->location }}
                                </a>
                                <span class="sr-only">Opens Google Maps in a new tab.</span>
                            @else
                                —
                            @endif
                        </td>
                    </tr>

                    @if($mapsEmbed)
                        <tr>
                            <td colspan="2" class="px-3 py-3">
                                <div class="w-full aspect-video rounded-lg overflow-hidden border">
                                    <iframe
                                        src="{{ $mapsEmbed }}"
                                        width="100%"
                                        height="100%"
                                        style="border:0;"
                                        loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen
                                        title="Map for {{ $event->location }}"
                                    ></iframe>
                                </div>
                            </td>
                        </tr>
                    @endif

                    {{-- Start Date --}}
                    @if($startDateFormatted)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">
                                {{ $event->start_date ? 'Start Date' : 'Date' }}
                            </th>
                            <td class="px-3 py-2">{{ $startDateFormatted }}</td>
                        </tr>
                    @endif

                    {{-- End Date (only if present on model) --}}
                    @if($endDateFormatted)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">End Date</th>
                            <td class="px-3 py-2">{{ $endDateFormatted }}</td>
                        </tr>
                    @endif

                    {{-- Times (leave as-is; only show if present) --}}
                    @if($event->start_time)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">Start Time</th>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</td>
                        </tr>
                    @endif

                    @if($event->end_time)
                        <tr class="border-t border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">End Time</th>
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}</td>
                        </tr>
                    @endif

                    <tr class="border-t border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Capacity</th>
                        <td class="px-3 py-2">{{ $event->capacity ?? 'No limit' }}</td>
                    </tr>

                    {{-- Created At / Updated At REMOVED (per request) --}}

                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center gap-2">
                {{-- OK / Return Home --}}
                <a
                    href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 rounded border
                           bg-[oklch(58.8%_0.158_241.966)]
                           border-[oklch(58.8%_0.158_241.966)]
                           text-white
                           hover:bg-[oklch(52%_0.158_241.966)]
                           hover:border-[oklch(52%_0.158_241.966)]
                           transition"
                >
                    Back
                </a>

                {{-- RSVP (only if profile confirmed) --}}
                @if(auth()->check())
                    @php
                        $user = auth()->user();
                        $isAdminRole = $user->isAdminOrSuper();
                    @endphp
                @endif

                @if(auth()->check() && auth()->user()->profile_confirmed && ! $isAdminRole)
                    @php
                        // Look up THIS user's RSVP status for THIS event
                        $rsvpStatus = auth()->user()
                            ->events()
                            ->where('events.id', $event->id)
                            ->pluck('event_user.status')
                            ->first();

                        $goingCount = $event->users()
                            ->wherePivot('status', 'going')
                            ->count();

                        $hasCapacity = is_null($event->capacity) || $goingCount < $event->capacity;
                    @endphp

                    @if($rsvpStatus === 'going')
                        <span class="inline-flex items-center rounded border border-green-200 bg-green-100 px-3 py-2 text-[11px] font-medium text-green-800">
                            RSVP’d (Going)
                        </span>
                        <form method="POST" action="{{ route('events.rsvp.update', $event) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 rounded border border-red-600
                                       bg-red-600 text-white text-sm
                                       hover:bg-red-700 hover:border-red-700 transition"
                            >
                                Cancel
                            </button>
                        </form>

                    @elseif($rsvpStatus === 'waitlist')
                        <span class="inline-flex items-center rounded border border-amber-200 bg-amber-100 px-3 py-2 text-[11px] font-medium text-amber-800">
                            RSVP’d (Waitlist)
                        </span>

                        @if($hasCapacity)
                            <form method="POST" action="{{ route('events.rsvp.update', $event) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="going">
                                <button
                                    type="submit"
                                    class="inline-flex items-center px-4 py-2 rounded border border-blue-600
                                           bg-blue-600 text-white text-sm
                                           hover:bg-blue-700 hover:border-blue-700 transition"
                                >
                                    Claim Spot
                                </button>
                            </form>
                        @else
                            <button
                                type="button"
                                disabled
                                class="inline-flex items-center px-4 py-2 rounded border border-gray-300 bg-gray-200 text-gray-700 cursor-not-allowed"
                            >
                                Waiting for an open spot
                            </button>
                        @endif

                        <form method="POST" action="{{ route('events.rsvp.update', $event) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 rounded border border-red-600
                                       bg-red-600 text-white text-sm
                                       hover:bg-red-700 hover:border-red-700 transition"
                            >
                                Cancel
                            </button>
                        </form>

                    @else
                        <form method="GET" action="{{ route('events.rsvp.questions', $event) }}">
                            <input type="hidden" name="status" value="going">
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 rounded border border-green-600
                                       bg-green-600 text-white text-sm
                                       hover:bg-green-700 hover:border-green-700 transition"
                            >
                                RSVP
                            </button>
                        </form>
                    @endif
                @endif
            </div>
        </div>
    </section>
@endsection

