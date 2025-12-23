@extends('layouts.app')

@section('title', 'Retreat Details')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Retreat Details</h1>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs">
                <table class="min-w-full">
                    <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold w-32">ID</th>
                        <td class="px-3 py-2">{{ $retreat->id }}</td>
                    </tr>

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

                    @if ($retreat->image)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="px-3 py-2 text-left font-semibold">Image</th>
                            <td class="px-3 py-2">
                                <div class="flex flex-col gap-2">
                                    <img src="{{ asset('storage/' . $retreat->image) }}"
                                         alt="Retreat image"
                                         class="max-w-xs rounded border">

                                    <span class="text-[11px] text-gray-500 break-all">
                    {{ $retreat->image }}
                </span>
                                </div>
                            </td>
                        </tr>
                    @endif

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Created At</th>
                        <td class="px-3 py-2">{{ $retreat->created_at }}</td>
                    </tr>

                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Updated At</th>
                        <td class="px-3 py-2">{{ $retreat->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('admin.retreats.edit', $retreat) }}"
                   class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                    Edit Retreat
                </a>

                <a href="{{ route('admin.retreats.index') }}" class="text-xs underline">
                    Back to Retreats
                </a>
            </div>
        </div>
    </section>
@endsection
