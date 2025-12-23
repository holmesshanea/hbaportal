@extends('layouts.app')

@section('title', 'User Details')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-base font-semibold mb-4">User Details</h1>

            <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs">
                <table class="min-w-full">
                    <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold w-40">ID</th>
                        <td class="px-3 py-2">{{ $user->id }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Name</th>
                        <td class="px-3 py-2">{{ $user->name }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Email</th>
                        <td class="px-3 py-2">{{ $user->email }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Email Verified At</th>
                        <td class="px-3 py-2">{{ $user->email_verified_at }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Role</th>
                        <td class="px-3 py-2">{{ $user->role }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Status</th>
                        <td class="px-3 py-2">{{ $user->status }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Gender</th>
                        <td class="px-3 py-2">{{ $user->gender }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Branch</th>
                        <td class="px-3 py-2">{{ $user->branch }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Phone</th>
                        <td class="px-3 py-2">{{ $user->phone }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Emergency Contact Name</th>
                        <td class="px-3 py-2">{{ $user->emergency_contact_name }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Emergency Contact Phone</th>
                        <td class="px-3 py-2">{{ $user->emergency_contact_phone }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Town</th>
                        <td class="px-3 py-2">{{ $user->town }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">State</th>
                        <td class="px-3 py-2">{{ $user->state }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Zip Code</th>
                        <td class="px-3 py-2">{{ $user->zipcode }}</td>
                    </tr>

                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Verification Image</th>
                        <td class="px-3 py-2">
                            @if ($user->image)
                                <a href="{{ asset('storage/' . $user->image) }}" target="_blank" class="inline-flex items-center gap-3">
                                    <img
                                        src="{{ asset('storage/' . $user->image) }}"
                                        alt="Verification Image"
                                        class="h-16 w-16 rounded-md object-cover border border-gray-300 dark:border-gray-700"
                                    />
                                    <span class="underline text-xs">View full size</span>
                                </a>
                            @else
                                <span class="text-gray-500">No image uploaded</span>
                            @endif
                        </td>
                    </tr>



                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="px-3 py-2 text-left font-semibold">Created At</th>
                        <td class="px-3 py-2">{{ $user->created_at }}</td>
                    </tr>

                    <tr>
                        <th class="px-3 py-2 text-left font-semibold">Updated At</th>
                        <td class="px-3 py-2">{{ $user->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                    Edit User
                </a>

                <a href="{{ route('admin.users.index') }}" class="text-xs underline">
                    Back to Users
                </a>
            </div>
        </div>
    </section>
@endsection
