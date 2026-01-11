@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Event Details</h1>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs">
                <table class="min-w-full">
                    <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold w-32">ID</th>
                        <td class="px-3 py-2">{{ $event->id }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Event Type</th>
                        <td class="px-3 py-2">{{ ucfirst($event->event_type ?? 'retreat') }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Title</th>
                        <td class="px-3 py-2">{{ $event->title }}</td>
                    </tr>

                    {{-- Description --}}
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td colspan="2" class="px-3 py-3 whitespace-pre-line">
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
                        <td class="px-3 py-2">{{ $event->location }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Start Date</th>
                        <td class="px-3 py-2">{{ $event->start_date }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Start Time</th>
                        <td class="px-3 py-2">{{ $event->start_time }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">End Date</th>
                        <td class="px-3 py-2">{{ $event->end_date }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">End Time</th>
                        <td class="px-3 py-2">{{ $event->end_time }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Capacity</th>
                        <td class="px-3 py-2">{{ $event->capacity }}</td>
                    </tr>

                    @if ($event->image)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">Image</th>
                            <td class="px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <img src="{{ asset('storage/' . $event->image) }}"
                                         alt="event image"
                                         class="max-w-xs rounded border">

                                    <span class="text-[11px] text-gray-500 break-all">
                    {{ $event->image }}
                </span>
                                </div>
                            </td>
                        </tr>
                    @endif

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Created At</th>
                        <td class="px-3 py-2">{{ $event->created_at }}</td>
                    </tr>

                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Updated At</th>
                        <td class="px-3 py-2">{{ $event->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('admin.events.edit', $event) }}"
                   class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                    Edit event
                </a>

                <a href="{{ route('admin.events.index') }}" class="text-xs underline">
                    Back to events
                </a>
            </div>
        </div>
    </section>
@endsection
