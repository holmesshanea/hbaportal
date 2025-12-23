{{-- resources/views/user/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row gap-6">

                {{-- LEFT SIDEBAR --}}
                <aside class="w-full md:w-56">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold">
                            User Menu
                        </div>

                        <nav class="flex flex-col text-sm">
                            {{-- Retreats tab --}}
                            <a href="{{ route('dashboard.retreats') }}"
                               class="px-4 py-2 border-b border-gray-200 dark:border-gray-700
                                      {{ (($section ?? 'retreats') === 'retreats') ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                                Retreats
                            </a>

                            {{-- Events tab --}}
                            <a href="{{ route('dashboard.events') }}"
                               class="px-4 py-2 border-b border-gray-200 dark:border-gray-700
                                      {{ (($section ?? '') === 'events') ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                                Events
                            </a>
                        </nav>
                    </div>
                </aside>

                {{-- MAIN CONTENT --}}
                <main class="flex-1">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center justify-between">
                            <div class="space-y-1">
                                <div class="text-sm font-semibold">
                                    @if(($section ?? 'retreats') === 'retreats')
                                        My Retreats
                                    @elseif(($section ?? '') === 'events')
                                        My Events
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    View and manage your registrations.
                                </div>
                            </div>

                            {{-- Optional: a button that changes depending on section --}}
                            {{-- For users you might not need this; you can remove it entirely. --}}
                        </div>

                        <div class="p-4">
                            {{-- RETREATS SECTION --}}
                            @if(($section ?? 'retreats') === 'retreats')
                                @if(isset($retreats) && count($retreats))
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-xs">
                                            <thead>
                                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                                <th class="py-2 pr-4">Title</th>
                                                <th class="py-2 pr-4">Start Date</th>
                                                <th class="py-2 pr-4">End Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($retreats as $retreat)
                                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                                    <td class="py-2 pr-4">
                                                        {{ $retreat->title }}
                                                    </td>
                                                    <td class="py-2 pr-4">
                                                        {{ optional($retreat->start_date)->format('M d, Y') }}
                                                    </td>
                                                    <td class="py-2 pr-4">
                                                        {{ optional($retreat->end_date)->format('M d, Y') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if(method_exists($retreats, 'links'))
                                        <div class="mt-3">
                                            {{ $retreats->links() }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        You are not registered for any retreats yet.
                                    </p>
                                @endif
                            @endif

                            {{-- EVENTS SECTION --}}
                            @if(($section ?? '') === 'events')
                                @if(isset($events) && count($events))
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full text-xs">
                                            <thead>
                                            <tr class="border-b border-gray-200 dark:border-gray-700 text-left">
                                                <th class="py-2 pr-4">Title</th>
                                                <th class="py-2 pr-4">Date</th>
                                                <th class="py-2 pr-4">Location</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($events as $event)
                                                <tr class="border-b border-gray-100 dark:border-gray-800">
                                                    <td class="py-2 pr-4">
                                                        {{ $event->title }}
                                                    </td>
                                                    <td class="py-2 pr-4">
                                                        {{ optional($event->date)->format('M d, Y') }}
                                                    </td>
                                                    <td class="py-2 pr-4">
                                                        {{ $event->location ?? 'TBD' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    @if(method_exists($events, 'links'))
                                        <div class="mt-3">
                                            {{ $events->links() }}
                                        </div>
                                    @endif
                                @else
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        You are not registered for any events yet.
                                    </p>
                                @endif
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
