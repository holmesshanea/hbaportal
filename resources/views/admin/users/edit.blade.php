@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-3xl mx-auto">
            <h1 class="text-base font-semibold mb-4">Edit User</h1>

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
                  action="{{ route('admin.users.update', $user) }}"
                  class="space-y-6"
                  enctype="multipart/form-data">

            @csrf
                @method('PUT')

                {{-- BASIC INFO --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="name">Name</label>
                        <input id="name" name="name" type="text"
                               value="{{ old('name', $user->name) }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="email">Email</label>
                        <input id="email" name="email" type="email"
                               value="{{ old('email', $user->email) }}"
                               class="w-full border rounded px-3 py-2 text-xs"
                               required>
                    </div>
                </div>

                {{-- PASSWORD (OPTIONAL) --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="password">
                            New Password
                            <span class="font-normal text-gray-500">(leave blank to keep current)</span>
                        </label>
                        <input id="password" name="password"  type="password"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="password_confirmation">
                            Confirm New Password
                        </label>
                        <input id="password_confirmation" name="password_confirmation"  type="password"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                {{-- ROLE / STATUS / BRANCH --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    {{-- ROLE --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="role">Role</label>
                        <select id="role" name="role" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option>
                            <option value="Admin" {{ $user->role == 'Admin' ? 'selected' : '' }}>Admin</option>
                            <option value="Super" {{ $user->role == 'Super' ? 'selected' : '' }}>Super</option>
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="status">Status</label>
                        <select id="status" name="status" class="w-full border rounded px-3 py-2 text-xs">
                            <option value="Veteran" {{ $user->status == 'Veteran' ? 'selected' : '' }}>Veteran</option>
                            <option value="Staff" {{ $user->status == 'Staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                    </div>

                    {{-- BRANCH --}}
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="branch">Branch</label>
                        <select id="branch" name="branch" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="" {{ $user->branch == '' ? 'selected' : '' }}>Select a branch</option>
                            <option value="Airforce" {{ $user->branch == 'Airforce' ? 'selected' : '' }}>Airforce</option>
                            <option value="Airforce Reserve" {{ $user->branch == 'Airforce Reserve' ? 'selected' : '' }}>Airforce Reserve</option>
                            <option value="Army" {{ $user->branch == 'Army' ? 'selected' : '' }}>Army</option>
                            <option value="Army National Guard" {{ $user->branch == 'Army National Guard' ? 'selected' : '' }}>Army National Guard</option>
                            <option value="Army Reserve" {{ $user->branch == 'Army Reserve' ? 'selected' : '' }}>Army Reserve</option>
                            <option value="Coast Guard" {{ $user->branch == 'Coast Guard' ? 'selected' : '' }}>Coast Guard</option>
                            <option value="Coast Guard Reserve" {{ $user->branch == 'Coast Guard Reserve' ? 'selected' : '' }}>Coast Guard Reserve</option>
                            <option value="Marine Corps" {{ $user->branch == 'Marine Corps' ? 'selected' : '' }}>Marine Corps</option>
                            <option value="Marine Corps Reserve" {{ $user->branch == 'Marine Corps Reserve' ? 'selected' : '' }}>Marine Corps Reserve</option>
                            <option value="Navy" {{ $user->branch == 'Navy' ? 'selected' : '' }}>Navy</option>
                            <option value="Navy Reserve" {{ $user->branch == 'Navy Reserve' ? 'selected' : '' }}>Navy Reserve</option>
                            <option value="Other" {{ $user->branch == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                </div>

                {{-- GENDER --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="gender">Gender</label>
                        <select id="gender" name="gender" class="w-full border rounded px-3 py-2 text-xs" required>
                            <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                </div>


                {{-- CONTACT --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="phone">Phone</label>
                        <input id="phone" name="phone" required type="text"
                               value="{{ old('phone', $user->phone) }}"
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
                               value="{{ old('emergency_contact_name', $user->emergency_contact_name) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="emergency_contact_phone">
                            Emergency Contact Phone
                        </label>
                        <input id="emergency_contact_phone" name="emergency_contact_phone" required type="text"
                               value="{{ old('emergency_contact_phone', $user->emergency_contact_phone) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                {{-- ADDRESS --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold mb-1" for="town">Town</label>
                        <input id="town" name="town" required type="text"
                               value="{{ old('town', $user->town) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="state">State</label>
                        <input id="state" name="state" required type="text"
                               value="{{ old('state', $user->state) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold mb-1" for="zipcode">Zip Code</label>
                        <input id="zipcode" name="zipcode" required type="text"
                               value="{{ old('zipcode', $user->zipcode) }}"
                               class="w-full border rounded px-3 py-2 text-xs">
                    </div>
                </div>

                {{-- VERIFICATION IMAGE --}}
                <div class="mt-4">
                    <label class="block text-xs font-semibold mb-1" for="image">
                        Verification Image
                    </label>

                    @if ($user->image)
                        <div class="mt-2 flex items-center gap-4">
                            <a href="{{ asset('storage/' . $user->image) }}" target="_blank">
                                <img
                                    src="{{ asset('storage/' . $user->image) }}"
                                    alt="Verification Image"
                                    class="h-16 w-16 rounded-md object-cover border border-gray-300 dark:border-gray-700"
                                />
                            </a>

                            <label class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 dark:border-gray-700">
                                Remove current image
                            </label>
                        </div>
                    @endif

                    <input
                        id="image"
                        name="image"
                        type="file"
                        accept="image/*"
                        class="mt-2 block w-full text-xs"
                    />

                    @error('image')
                    <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                    @enderror
                </div>




                <div class="flex items-center gap-2 mt-4">
                    <button type="submit"
                            class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                        Update
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
