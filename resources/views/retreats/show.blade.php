@extends('layouts.app')

@section('title', 'Retreat Details')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Retreat Details</h1>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs">
                <table class="min-w-full">
                    <tbody>

                    @if ($retreat->image)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">Image</th>
                            <td class="px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <img src="{{ asset('storage/' . $retreat->image) }}"
                                         alt="Retreat image"
                                         class="max-w-xs rounded border">
                                </div>
                            </td>
                        </tr>
                    @endif

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Title</th>
                        <td class="px-3 py-2">{{ $retreat->title }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Description</th>
                        <td class="px-3 py-2 whitespace-pre-line">{{ $retreat->description }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Location</th>
                        <td class="px-3 py-2">{{ $retreat->location }}</td>
                    </tr>

                    @php
                        $q = urlencode($retreat->location);
                        $src = "https://www.google.com/maps?q={$q}&output=embed";
                    @endphp

                    <tr>
                        <td colspan="2" class="px-3 py-3">
                            <div class="w-full aspect-video rounded-lg overflow-hidden border">
                                <iframe
                                    src="{{ $src }}"
                                    width="100%"
                                    height="100%"
                                    style="border:0;"
                                    loading="lazy"
                                    referrerpolicy="no-referrer-when-downgrade"
                                    allowfullscreen
                                    title="Map for {{ $retreat->location }}"
                                ></iframe>
                            </div>
                        </td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Start Date</th>
                        <td class="px-3 py-2">{{ $retreat->start_date }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Start Time</th>
                        <td class="px-3 py-2">{{ $retreat->start_time }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">End Date</th>
                        <td class="px-3 py-2">{{ $retreat->end_date }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">End Time</th>
                        <td class="px-3 py-2">{{ $retreat->end_time }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Capacity</th>
                        <td class="px-3 py-2">{{ $retreat->capacity }}</td>
                    </tr>

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
                    OK / Return Home
                </a>

                {{-- RSVP (only if profile confirmed) --}}
                @if(auth()->check() && auth()->user()->profile_confirmed)

                    @php
                        // Look up THIS user's RSVP status for THIS retreat
                        $rsvpStatus = auth()->user()
                            ->retreats()
                            ->where('retreats.id', $retreat->id)
                            ->first()
                            ?->pivot
                            ?->status;

                        // Consider these as "already RSVP’d" (button should be disabled)
                        $hasActiveRsvp = in_array($rsvpStatus, ['going', 'waitlist']);
                    @endphp

                    @if($hasActiveRsvp)
                        <button
                            type="button"
                            disabled
                            class="inline-flex items-center px-4 py-2 rounded
               bg-gray-300 text-gray-700 border border-gray-300
               cursor-not-allowed"
                        >
                            RSVP’d ({{ ucfirst($rsvpStatus) }})
                        </button>
                    @else
                        <form method="POST" action="{{ route('retreats.rsvp.store', $retreat) }}">
                            @csrf
                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2 rounded
               bg-green-600 text-white border border-green-600
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
