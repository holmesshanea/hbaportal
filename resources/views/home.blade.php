@extends('layouts.app')
@section('title', 'Welcome')

@section('content')

    @if (session('status') === 'email-verified')
        <div class="w-full bg-emerald-100 border-b-4 border-emerald-500 text-emerald-900 px-6 py-4 text-center">
            <div class="text-lg font-semibold flex items-center justify-center gap-2">
                <span aria-hidden="true">✅</span>
                <span>Your email address has been successfully verified.</span>
            </div>

            <div class="mt-1 text-sm font-normal text-emerald-800">
                You now have full access to the HBA Portal.
            </div>
        </div>
    @endif


    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm ring-1 ring-black/5 dark:ring-white/5 rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">

        <style>
            /* Mobile-only: stack labels above values */
            @media (max-width: 640px) {
                .meta-row { display: flex; flex-direction: column; gap: 0.125rem; }
                .meta-row .label { display: block; }
                .meta-row .value { display: block; }
            }
        </style>


        <h1 class="mb-4 text-base font-medium">Welcome!</h1>

        <p class="mb-2 text-[#706f6c] dark:text-[#A1A09A]">
            This portal connects veterans to HBA’ events, made possible through both the Staff Sergeant Parker Gordon Fox Suicide Prevention Grant Program and the New York State Joseph P.
            Dwyer Veterans Peer Support Project. To attend any HBA event, veterans must be verified ND approved. All information collected through this portal is
            used solely to verify veteran status for participation in these events and is not shared or applied
            for any other purpose. For additional details regarding site usage and data collection, please review
            our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.
        </p>

        @if(session('success'))
            <div class="mb-4 inline-flex items-center rounded border border-green-200 bg-green-50 px-4 py-2 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->has('status'))
            <div class="mb-4 inline-flex items-center rounded border border-red-200 bg-red-50 px-4 py-2 text-red-800 text-sm">
                {{ $errors->first('status') }}
            </div>
        @endif

        @php
            /**
             * Build RSVP status lookups ONCE (important!)
             * - Keyed by the related model id
             * - Value is pivot status (going, waitlist, cancelled, etc)
             */
            $eventRsvpStatuses = [];

            if (auth()->check()) {
                // Event RSVPs for this user: [event_id => status]
                $eventRsvpStatuses = auth()->user()
                    ->events()
                    ->pluck('event_user.status', 'events.id')
                    ->toArray();
            }

            /**
             * Event type presentation map
             * - Color coding (badge + left accent)
             * - Iconography (emoji, but you can swap with SVG later)
             * - Small header/badge text
             *
             * Add more types later by extending this array.
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
        @endphp

        {{-- Single-column layout of Events --}}
        <div class="mt-8 space-y-10">

            {{-- Events --}}
            <div>
                <h2 class="mb-4 text-sm font-semibold tracking-wide text-[#3b3a37] dark:text-[#EDEDE5]">
                    Events
                </h2>

                @forelse($events as $event)
                    @php
                        $typeKey = strtolower($event->event_type ?? 'event');
                        $typeMeta = $eventTypeStyles[$typeKey] ?? $eventTypeStyles['default'];

                        // Prefer start_date if your model has it, otherwise fall back to date
                        $displayDate = $event->start_date ?? $event->date ?? null;
                    @endphp

                    <div class="mb-4 w-full rounded-lg border border-[#e4e3df] dark:border-[#2b2b28] bg-[#f9f8f4] dark:bg-[#1e1e1c] p-4 flex flex-col sm:flex-row gap-4 border-l-4 {{ $typeMeta['accent'] }}">

                        {{-- Event image (left) --}}
                        @if($event->image)
                            <div class="w-full sm:w-24 h-40 sm:h-24 flex-shrink-0 overflow-hidden rounded-md bg-[#ddd]">
                                <img
                                    src="{{ asset('storage/' . $event->image) }}"
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        @else
                            <div class="w-full sm:w-24 h-40 sm:h-24 flex-shrink-0 rounded-md bg-[#e4e3df] dark:bg-[#2b2b28] flex items-center justify-center text-[11px] text-[#706f6c]">
                                No image
                            </div>
                        @endif

                        {{-- Event info (right) --}}
                        <div class="flex-1 min-w-0 flex flex-col">

                            {{-- Type badge (small header/badge text + icon) --}}
                            <div class="mb-2 flex items-center gap-2">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-1 text-[10px] font-semibold uppercase tracking-wide {{ $typeMeta['badge'] }}"
                                    role="note"
                                    aria-label="Type: {{ $typeMeta['label'] }}"
                                    title="{{ $typeMeta['label'] }}"
                                >
                                    <span aria-hidden="true">{{ $typeMeta['icon'] }}</span>
                                    <span>{{ $typeMeta['label'] }}</span>
                                </span>

                                {{-- Optional subtle helper text for screen readers (keeps accessibility strong even without color) --}}
                                <span class="sr-only">This item is a {{ $typeMeta['label'] }}.</span>
                            </div>

                            {{-- Date (bold, left) + Start Time (right) --}}
                            @if($displayDate || $event->start_time)
                                <div class="flex items-start justify-between gap-3 mb-1">
                                    <div class="text-[13px] font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">
                                        @if($displayDate)
                                            {{ \Carbon\Carbon::parse($displayDate)->format('j F, Y') }}
                                        @endif
                                    </div>

                                    @if($event->start_time)
                                        <div class="text-[12px] text-[#706f6c] dark:text-[#A1A09A] whitespace-nowrap">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            {{-- Title --}}
                            <div class="font-semibold text-[13px] mb-1">
                                <a
                                    href="{{ route('events.show', $event) }}"
                                    class="hover:underline text-[#1b1b18] dark:text-[#EDEDEC]"
                                >
                                    {{ $event->title }}
                                </a>
                            </div>

                            {{-- Short Description --}}
                            @if($event->short_description)
                                <div class="text-[12px] leading-4 break-words text-[#4b4a47] dark:text-[#C9C9C3]">
                                    {{ $event->short_description }}
                                </div>
                            @endif

                            {{-- Location --}}
                            @if($event->location)
                                <div class="mt-2 text-[12px] leading-5 text-[#706f6c] dark:text-[#A1A09A] break-words">
                                    {{ $event->location }}
                                </div>
                            @endif

                            <div class="mt-3 flex justify-end gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('events.show', $event) }}"
                                    class="inline-flex items-center justify-center rounded-md border
                                           bg-[oklch(58.8%_0.158_241.966)]
                                           border-[oklch(58.8%_0.158_241.966)]
                                           px-3 py-1.5 text-[11px] font-medium text-white
                                           hover:bg-[oklch(52%_0.158_241.966)]
                                           hover:border-[oklch(52%_0.158_241.966)]
                                           transition"
                                >
                                    View
                                </a>

                                {{-- RSVP (only if profile confirmed) --}}
                                @if(auth()->check() && auth()->user()->profile_confirmed)
                                    @php
                                        $status = $eventRsvpStatuses[$event->id] ?? null;
                                        $goingCount = $event->users()
                                            ->wherePivot('status', 'going')
                                            ->count();
                                        $hasCapacity = is_null($event->capacity) || $goingCount < $event->capacity;
                                    @endphp

                                    @if($status === 'going')
                                        <span class="inline-flex items-center justify-center rounded-md border border-green-200 bg-green-100 px-3 py-1.5 text-[11px] font-medium text-green-800">
                                            RSVP’d (Going)
                                        </span>
                                        <form method="POST" action="{{ route('events.rsvp.update', $event) }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button
                                                type="submit"
                                                class="inline-flex items-center justify-center rounded-md border border-red-600
                                                       bg-red-600 px-3 py-1.5 text-[11px] font-medium text-white
                                                       hover:bg-red-700 hover:border-red-700 transition"
                                            >
                                                Cancel
                                            </button>
                                        </form>

                                    @elseif($status === 'waitlist')
                                        <span class="inline-flex items-center justify-center rounded-md border border-amber-200 bg-amber-100 px-3 py-1.5 text-[11px] font-medium text-amber-800">
                                            RSVP’d (Waitlist)
                                        </span>

                                        @if($hasCapacity)
                                            <form method="POST" action="{{ route('events.rsvp.update', $event) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="going">
                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center justify-center rounded-md border border-blue-600
                                                           bg-blue-600 px-3 py-1.5 text-[11px] font-medium text-white
                                                           hover:bg-blue-700 hover:border-blue-700 transition"
                                                >
                                                    Claim Spot
                                                </button>
                                            </form>
                                        @else
                                            <button
                                                type="button"
                                                disabled
                                                class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-gray-200 px-3 py-1.5 text-[11px] font-medium text-gray-700 cursor-not-allowed"
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
                                                class="inline-flex items-center justify-center rounded-md border border-red-600
                                                       bg-red-600 px-3 py-1.5 text-[11px] font-medium text-white
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
                                                class="inline-flex items-center justify-center rounded-md border border-green-600
                                                       bg-green-600 px-3 py-1.5 text-[11px] font-medium text-white
                                                       hover:bg-green-700 hover:border-green-700 transition"
                                            >
                                                RSVP
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <p class="text-[12px] text-[#706f6c] dark:text-[#A1A09A]">
                        There are currently no events scheduled.
                    </p>
                @endforelse

                @if ($events->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $events->links() }}
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
