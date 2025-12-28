@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Add User</h1>

            @if ($errors->any())
                <div class="mb-4 border border-red-300 bg-red-50 text-red-800 text-xs p-3 rounded">
                    <ul class="list-disc list-inside">
                        @if ($errors->any())
                            <div class="mb-4 border border-red-300 bg-red-50 text-red-800 text-xs p-3 rounded">
                                <ul class="list-disc list-inside">
                                    @php
                                        $fieldOrder = [
                                            'name',
                                            'email',
                                            'password',
                                            'password_confirmation',
                                            'role',
                                            'status',
                                            'branch',
                                            'gender',
                                            'phone',
                                            'emergency_contact_name',
                                            'emergency_contact_phone',
                                            'town',
                                            'state',
                                            'zipcode',
                                        ];
                                    @endphp

                                    @foreach ($fieldOrder as $field)
                                        @foreach ($errors->get($field) as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
                @csrf

                {{-- BASIC INFO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="name">Name</label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name') }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="email">Email</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email') }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="password">Password</label>
                        <input id="password" name="password" type="password"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>
                </div>

                {{-- ROLE / STATUS / BRANCH --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- ROLE --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="role">Role</label>
                        <select id="role" name="role" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="User" {{ old('role', 'User') === 'User' ? 'selected' : '' }}>User</option>
                            <option value="Admin" {{ old('role') === 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Super" {{ old('role') === 'Super' ? 'selected' : '' }}>Super</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="status">Status</label>
                        <select id="status" name="status" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="Veteran" {{ old('status', 'Veteran') === 'Veteran' ? 'selected' : '' }}>Veteran</option>
                            <option value="Staff" {{ old('status') === 'Staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    {{-- BRANCH --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="branch">Branch</label>
                        <select id="branch" name="branch" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="" {{ old('branch') === '' ? 'selected' : '' }}>Select a branch</option>
                            <option value="Airforce" {{ old('branch') === 'Airforce' ? 'selected' : '' }}>Airforce</option>
                            <option value="Airforce Reserve" {{ old('branch') === 'Airforce Reserve' ? 'selected' : '' }}>Airforce Reserve</option>
                            <option value="Army" {{ old('branch', 'Army') === 'Army' ? 'selected' : '' }}>Army</option>
                            <option value="Army National Guard" {{ old('branch') === 'Army National Guard' ? 'selected' : '' }}>Army National Guard</option>
                            <option value="Army Reserve" {{ old('branch') === 'Army Reserve' ? 'selected' : '' }}>Army Reserve</option>
                            <option value="Coast Guard" {{ old('branch') === 'Coast Guard' ? 'selected' : '' }}>Coast Guard</option>
                            <option value="Coast Guard Reserve" {{ old('branch') === 'Coast Guard Reserve' ? 'selected' : '' }}>Coast Guard Reserve</option>
                            <option value="Marine Corps" {{ old('branch') === 'Marine Corps' ? 'selected' : '' }}>Marine Corps</option>
                            <option value="Marine Corps Reserve" {{ old('branch') === 'Marine Corps Reserve' ? 'selected' : '' }}>Marine Corps Reserve</option>
                            <option value="Navy" {{ old('branch') === 'Navy' ? 'selected' : '' }}>Navy</option>
                            <option value="Navy Reserve" {{ old('branch') === 'Navy Reserve' ? 'selected' : '' }}>Navy Reserve</option>
                            <option value="Other" {{ old('branch') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- COMBAT (required boolean) --}}
                    <div class="mt-4">
                        <label class="block text-xs font-semibold mb-1">Combat Veteran</label>

                        {{-- Hidden input ensures value is always submitted (0 if unchecked) --}}
                        <input type="hidden" name="combat" value="0">

                        <label class="inline-flex items-center gap-2">
                            <input
                                type="checkbox"
                                name="combat"
                                value="1"
                                {{ old('combat', 0) ? 'checked' : '' }}
                                class="rounded border-gray-300"
                            >
                            <span class="text-xs">Yes (Combat Veteran)</span>
                        </label>
                    </div>

                </div>

                {{-- GENDER + PHONE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">

                    {{-- GENDER --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="gender">Gender</label>
                        <select id="gender" name="gender" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="Male" {{ old('gender', 'Male') === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="phone">Phone</label>
                        <input id="phone" name="phone" type="text"
                               value="{{ old('phone') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                </div>

                {{-- EMERGENCY CONTACT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="emergency_contact_name">
                            Emergency Contact Name
                        </label>
                        <input id="emergency_contact_name" name="emergency_contact_name" required type="text"
                               value="{{ old('emergency_contact_name') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="emergency_contact_phone">
                            Emergency Contact Phone
                        </label>
                        <input id="emergency_contact_phone" name="emergency_contact_phone" required type="text"
                               value="{{ old('emergency_contact_phone') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="town">Town</label>
                        <input id="town" name="town" required type="text"
                               value="{{ old('town') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="state">State</label>
                        <input id="state" name="state" required type="text"
                               value="{{ old('state') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="zipcode">Zip Code</label>
                        <input id="zipcode" name="zipcode" required type="text"
                               value="{{ old('zipcode') }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <button type="submit"
                            class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                        Save
                    </button>

                    <a href="{{ route('admin.users.index') }}"
                       class="text-xs underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection
