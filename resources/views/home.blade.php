@extends('layouts.app')
@section('title', 'Welcome')

@section('content')
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
            This portal connects veterans to HBA’ Nature Retreats and Peer-to-Peer events, made possible through
            the Staff Sergeant Parker Gordon Fox Suicide Prevention Grant Program and the New York State Joseph P.
            Dwyer Veterans Peer Support Project respectively. To attend any HBA retreat or event, veterans must be registered,
            verified, screened, and approved through our four-step process. All information collected through this portal is
            used solely to verify veteran status for participation in these programs and is not shared or applied
            for any other purpose. For additional details regarding site usage and data collection, please review
            our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a>.
        </p>

        @php
            /**
             * Build RSVP status lookups ONCE (important!)
             * - Keyed by the related model id
             * - Value is pivot status (going, waitlist, cancelled, etc)
             */
            $retreatRsvpStatuses = [];
            $eventRsvpStatuses = [];

            if (auth()->check()) {
                // Retreat RSVPs for this user: [retreat_id => status]
                $retreatRsvpStatuses = auth()->user()
                    ->retreats()
                    ->pluck('retreat_user.status', 'retreats.id')
                    ->toArray();

                // Event RSVPs for this user: [event_id => status]
                $eventRsvpStatuses = auth()->user()
                    ->events()
                    ->pluck('event_user.status', 'events.id')
                    ->toArray();
            }
        @endphp

        {{-- Single-column layout: Retreats then Events --}}
        <div class="mt-8 space-y-10">

            {{-- Retreats --}}
            <div>
                <h2 class="mb-4 text-sm font-semibold tracking-wide text-[#3b3a37] dark:text-[#EDEDE5]">
                    Retreats
                </h2>

                @forelse($retreats as $retreat)
                    <div class="mb-4 w-full rounded-lg border border-[#e4e3df] dark:border-[#2b2b28] bg-[#f9f8f4] dark:bg-[#1e1e1c] p-4 flex flex-col sm:flex-row gap-4">

                        {{-- Retreat image (left) --}}
                        @if($retreat->image)
                            <div class="w-full sm:w-24 h-40 sm:h-24 flex-shrink-0 overflow-hidden rounded-md bg-[#ddd]">
                                <img
                                    src="{{ asset('storage/' . $retreat->image) }}"
                                    alt="{{ $retreat->title }}"
                                    class="w-full h-full object-cover"
                                >
                            </div>
                        @else
                            <div class="w-full sm:w-24 h-40 sm:h-24 flex-shrink-0 rounded-md bg-[#e4e3df] dark:bg-[#2b2b28] flex items-center justify-center text-[11px] text-[#706f6c]">
                                No image
                            </div>
                        @endif

                        {{-- Retreat info (right) --}}
                        <div class="flex-1 min-w-0 flex flex-col">
                            <div class="font-semibold text-[13px] mb-1">
                                <a
                                    href="{{ route('retreats.show', $retreat) }}"
                                    class="hover:underline text-[#1b1b18] dark:text-[#EDEDEC]"
                                >
                                    {{ $retreat->title }}
                                </a>
                            </div>

                            @if($retreat->short_description)
                                <div class="text-[12px] leading-4 break-words text-[#4b4a47] dark:text-[#C9C9C3]">
                                    {{ $retreat->short_description }}
                                </div>
                            @endif

                            <div class="mt-2 text-[12px] leading-5 text-[#706f6c] dark:text-[#A1A09A] space-y-0.5">
                                @if($retreat->start_date)
                                    <div class="meta-row">
                                        <span class="label font-medium">Start Date / Time:</span>
                                        <span class="value">
                                            {{ \Carbon\Carbon::parse($retreat->start_date)->format('M j, Y') }}
                                            @if($retreat->start_time)
                                                · {{ \Carbon\Carbon::parse($retreat->start_time)->format('g:i A') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                @if($retreat->end_date)
                                    <div class="meta-row">
                                        <span class="label font-medium">End Date / Time:</span>
                                        <span class="value">
                                            {{ \Carbon\Carbon::parse($retreat->end_date)->format('M j, Y') }}
                                            @if($retreat->end_time)
                                                · {{ \Carbon\Carbon::parse($retreat->end_time)->format('g:i A') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                @if($retreat->location)
                                    <div class="meta-row">
                                        <span class="label font-medium">Location:</span>
                                        <span class="value">{{ $retreat->location }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-3 flex justify-end gap-2">

                                {{-- View --}}
                                <a
                                    href="{{ route('retreats.show', $retreat) }}"
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
                                        $status = $retreatRsvpStatuses[$retreat->id] ?? null;
                                        $hasActiveRsvp = in_array($status, ['going', 'waitlist']);
                                    @endphp

                                    @if($hasActiveRsvp)
                                        <button
                                            type="button"
                                            disabled
                                            class="inline-flex items-center justify-center rounded-md border border-gray-300
                                                   bg-gray-300 px-3 py-1.5 text-[11px] font-medium text-gray-700
                                                   cursor-not-allowed"
                                        >
                                            RSVP’d ({{ ucfirst($status) }})
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('retreats.rsvp.store', $retreat) }}">
                                            @csrf
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
                        There are currently no retreats scheduled.
                    </p>
                @endforelse
            </div>

            {{-- Events --}}
            <div>
                <h2 class="mb-4 text-sm font-semibold tracking-wide text-[#3b3a37] dark:text-[#EDEDE5]">
                    Events
                </h2>

                @forelse($events as $event)
                    <div class="mb-4 w-full rounded-lg border border-[#e4e3df] dark:border-[#2b2b28] bg-[#f9f8f4] dark:bg-[#1e1e1c] p-4 flex flex-col sm:flex-row gap-4">

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
                            <div class="font-semibold text-[13px] mb-1">
                                <a
                                    href="{{ route('events.show', $event) }}"
                                    class="hover:underline text-[#1b1b18] dark:text-[#EDEDEC]"
                                >
                                    {{ $event->title }}
                                </a>
                            </div>

                            @if($event->short_description)
                                <div class="text-[12px] leading-4 break-words text-[#4b4a47] dark:text-[#C9C9C3]">
                                    {{ $event->short_description }}
                                </div>
                            @endif

                            <div class="mt-2 text-[12px] leading-5 text-[#706f6c] dark:text-[#A1A09A] space-y-0.5">
                                @if($event->date)
                                    <div class="meta-row">
                                        <span class="label font-medium">Start Date:</span>
                                        <span class="value">{{ \Carbon\Carbon::parse($event->date)->format('M j, Y') }}</span>
                                    </div>
                                @endif

                                @if($event->start_time)
                                    <div class="meta-row">
                                        <span class="label font-medium">Start Time:</span>
                                        <span class="value">{{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}</span>
                                    </div>
                                @endif

                                @if($event->location)
                                    <div class="meta-row">
                                        <span class="label font-medium">Location:</span>
                                        <span class="value">{{ $event->location }}</span>
                                    </div>
                                @endif
                            </div>

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
                                        $hasActiveRsvp = in_array($status, ['going', 'waitlist']);
                                    @endphp

                                    @if($hasActiveRsvp)
                                        <button
                                            type="button"
                                            disabled
                                            class="inline-flex items-center justify-center rounded-md border border-gray-300
                                                   bg-gray-300 px-3 py-1.5 text-[11px] font-medium text-gray-700
                                                   cursor-not-allowed"
                                        >
                                            RSVP’d ({{ ucfirst($status) }})
                                        </button>
                                    @else
                                        <form method="POST" action="{{ route('events.rsvp.store', $event) }}">
                                            @csrf
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
            </div>

        </div>
    </section>
@endsection
