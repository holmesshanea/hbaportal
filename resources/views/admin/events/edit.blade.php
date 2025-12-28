@extends('layouts.app')

@section('title', 'Edit event')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Edit event</h1>

            @if ($errors->any())
                <div class="mb-4 border border-red-300 bg-red-50 text-red-800 text-xs p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST"
                  action="{{ route('admin.events.update', $event) }}"
                  enctype="multipart/form-data"
                  class="space-y-6">


            @csrf
                @method('PUT')

                {{-- EVENT TYPE --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="event_type">Event Type</label>
                    <select id="event_type" name="event_type"
                            class="w-full border rounded px-3 py-2 text-xs"
                            required>
                        <option value="retreat" {{ old('event_type', $event->event_type ?? 'retreat') === 'retreat' ? 'selected' : '' }}>Retreat</option>
                        <option value="event" {{ old('event_type', $event->event_type ?? 'retreat') === 'event' ? 'selected' : '' }}>Event</option>
                    </select>
                </div>

                {{-- TITLE --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="title">Title</label>
                    <input id="title" name="title" type="text"
                           value="{{ old('title', $event->title) }}"
                           class="w-full border rounded px-3 py-2 text-xs"
                           required>
                </div>

                {{-- SHORT DESCRIPTION --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="short_description">
                        Short Description
                    </label>
                    <textarea id="short_description"
                              name="short_description"
                              rows="2"
                              class="w-full border rounded px-3 py-2 text-xs">{{ old('short_description', $event->short_description) }}</textarea>
                </div>

                {{-- DESCRIPTION --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="description">Description</label>
                    <textarea id="description" name="description"
                              rows="4"
                              class="w-full border rounded px-3 py-2 text-xs">{{ old('description', $event->description) }}</textarea>
                </div>

                {{-- LOCATION --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="location">Location</label>
                    <input id="location" name="location" type="text"
                           value="{{ old('location', $event->location) }}"
                           class="w-full border rounded px-3 py-2 text-xs">
                </div>

                {{-- DATES / TIMES --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="start_date">Start Date</label>
                        <input id="start_date" name="start_date" type="date"
                               value="{{ old('start_date', $event->start_date) }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="start_time">Start Time</label>
                        <input id="start_time" name="start_time" type="time"
                               value="{{ old('start_time', $event->start_time) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="end_date">End Date</label>
                        <input id="end_date" name="end_date" type="date"
                               value="{{ old('end_date', $event->end_date) }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="end_time">End Time</label>
                        <input id="end_time" name="end_time" type="time"
                               value="{{ old('end_time', $event->end_time) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                {{-- CAPACITY --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="capacity">Capacity</label>
                    <input id="capacity" name="capacity" type="number" min="0"
                           value="{{ old('capacity', $event->capacity) }}"
                           class="w-full border rounded px-3 py-2 text-xs">
                </div>

                {{-- CURRENT IMAGE (optional preview) --}}
                @if ($event->image)
                    <div>
                        <span class="block text-xs font-semibold mb-1">Current Image</span>
                        <img src="{{ asset('storage/' . $event->image) }}"
                             alt="Current event image"
                             class="h-20 border rounded mb-1">
                        <div class="text-[11px] text-gray-500 break-all">
                            {{ $event->image }}
                        </div>
                    </div>
                @endif

                {{-- IMAGE (UPLOAD NEW) --}}
                <div>
                    <label class="block text-xs font-semibold mb-1" for="image">Replace Image</label>
                    <input id="image" name="image" type="file"
                           accept="image/*"
                           class="w-full border rounded px-3 py-2 text-xs">
                    <p class="text-[11px] text-gray-500 mt-1">
                        Leave this empty to keep the current image.
                    </p>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <button type="submit"
                            class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                        Update
                    </button>

                    <a href="{{ route('admin.events.index') }}"
                       class="text-xs underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
