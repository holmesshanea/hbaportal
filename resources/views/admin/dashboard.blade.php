@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row gap-6">
                {{-- LEFT SIDEBAR --}}
                <aside class="w-full md:w-56">
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700 text-sm font-semibold">
                            Admin Menu
                        </div>

                        <nav class="flex flex-col text-sm">
                            <a href="{{ route('admin.users.index') }}"
                               class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 {{ ($section ?? 'users') === 'users' ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
                                Users
                            </a>


                            <a href="{{ route('admin.events.index') }}"
                               class="px-4 py-2 border-b border-gray-200 dark:border-gray-700 {{ ($section ?? '') === 'events' ? 'bg-gray-100 dark:bg-gray-800 font-semibold' : '' }}">
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
                                <div class="text-sm font-semibold">Admin Dashboard</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                    Manage Users and Events
                                </div>
                            </div>

                            {{-- ACTION BUTTONS --}}
                            <div>
                                @if(($section ?? 'users') === 'users')
                                    <a href="{{ route('admin.users.create') }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs border rounded bg-blue-600 text-white hover:bg-blue-700">
                                        + Add User
                                    </a>
                                @elseif(($section ?? '') === 'events')
                                    <a href="{{ route('admin.events.create') }}"
                                       class="inline-flex items-center px-3 py-1.5 text-xs border rounded bg-blue-600 text-white hover:bg-blue-700">
                                        + Add Event
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- FLASH MESSAGE --}}
                        @if(session('status'))
                            <div class="px-4 py-2 bg-green-50 text-green-800 text-xs border-b border-green-200">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="p-4">
                            {{-- USERS TABLE --}}
                            @if(($section ?? 'users') === 'users')
                                <h2 class="text-sm font-semibold mb-2">Users</h2>

                                <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded">
                                    <table class="min-w-full text-xs border-collapse">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-2 py-1 border">Name</th>
                                            <th class="px-2 py-1 border">Email</th>
                                            <th class="px-2 py-1 border">Role</th>
                                            <th class="px-2 py-1 border">Status</th>
                                            <th class="px-2 py-1 border">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse(($users ?? []) as $user)
                                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-[#161615] dark:even:bg-gray-800">
                                                <td class="px-2 py-1 border">
                                                    <a href="{{ route('admin.users.show', $user) }}" class="underline">
                                                        {{ $user->last_name }} {{ $user->first_name }}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-1 border">{{ $user->email }}</td>
                                                <td class="px-2 py-1 border">{{ $user->role ?? '—' }}</td>
                                                <td class="px-2 py-1 border">{{ $user->status ?? '—' }}</td>
                                                <td class="px-2 py-1 border">
                                                    <div class="flex flex-wrap gap-1">
                                                        <a href="{{ route('admin.users.edit', $user) }}"
                                                           class="px-2 py-0.5 border rounded text-[11px]">Edit</a>
                                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                              onsubmit="return confirm('Are you sure you want to delete this user?');"
                                                              class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                    class="px-2 py-0.5 border rounded text-[11px] text-red-600">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-2 py-2 text-center text-gray-500">No users found.</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if(isset($users) && method_exists($users, 'links'))
                                    <div class="mt-3">{{ $users->links() }}</div>
                                @endif
                            @endif


                            {{-- EVENTS TABLE --}}
                            @if(($section ?? '') === 'events')
                                <h2 class="text-sm font-semibold mb-2">Events</h2>

                                <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded">
                                    <table class="min-w-full text-xs border-collapse">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-2 py-1 border">Title</th>
                                            <th class="px-2 py-1 border">Date</th>
                                            <th class="px-2 py-1 border">Start Time</th>
                                            <th class="px-2 py-1 border">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse(($events ?? []) as $event)
                                            <tr class="odd:bg-white even:bg-gray-50 dark:odd:bg-[#161615] dark:even:bg-gray-800">
                                                <td class="px-2 py-1 border">
                                                    <a href="{{ route('admin.events.show', $event) }}" class="underline">
                                                        {{ $event->title }}
                                                    </a>
                                                </td>
                                                <td class="px-2 py-1 border">{{ $event->date }}</td>
                                                <td class="px-2 py-1 border">
                                                    {{ $event->start_time ?? '—' }}
                                                </td>
                                                <td class="px-2 py-1 border">
                                                    <div class="flex flex-wrap gap-1">
                                                        <a href="{{ route('admin.events.edit', $event) }}"
                                                           class="px-2 py-0.5 border rounded text-[11px]">Edit</a>
                                                        <form method="POST" action="{{ route('admin.events.destroy', $event) }}"
                                                              onsubmit="return confirm('Delete this event?');"
                                                              class="inline">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                    class="px-2 py-0.5 border rounded text-[11px] text-red-600">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-2 py-2 text-center text-gray-500">
                                                    No events found.
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if(isset($events) && method_exists($events, 'links'))
                                    <div class="mt-3">{{ $events->links() }}</div>
                                @endif
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection
