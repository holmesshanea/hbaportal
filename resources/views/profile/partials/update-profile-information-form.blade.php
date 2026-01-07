<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.resend') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required autofocus autocomplete="given-name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>

            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autocomplete="family-name" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $user->phone)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="emergency_contact_name" :value="__('Emergency Contact Name')" />
            <x-text-input id="emergency_contact_name" name="emergency_contact_name" type="text" class="mt-1 block w-full" :value="old('emergency_contact_name', $user->emergency_contact_name)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_name')" />
        </div>

        <div>
            <x-input-label for="emergency_contact_phone" :value="__('Emergency Contact Phone')" />
            <x-text-input id="emergency_contact_phone" name="emergency_contact_phone" type="tel" class="mt-1 block w-full" :value="old('emergency_contact_phone', $user->emergency_contact_phone)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('emergency_contact_phone')" />
        </div>

        <div>
            <x-input-label for="town" :value="__('Town')" />
            <x-text-input id="town" name="town" type="text" class="mt-1 block w-full" :value="old('town', $user->town)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('town')" />
        </div>

        <div>
            <x-input-label for="state" :value="__('State')" />
            <x-text-input id="state" name="state" type="text" class="mt-1 block w-full" :value="old('state', $user->state)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('state')" />
        </div>

        <div>
            <x-input-label for="zipcode" :value="__('Zipcode')" />
            <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full" :value="old('zipcode', $user->zipcode)"  required />
            <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <select id="gender" name="gender" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm" required>
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $user->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $user->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                <option value="Other" {{ old('gender', $user->gender) === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('gender')" />
        </div>

        <div>
            <x-input-label for="status" :value="__('Status')" />
            <select id="status" name="status" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm" required>
                <option value="">Select Status</option>
                <option value="Veteran" {{ old('status', $user->status) === 'Veteran' ? 'selected' : '' }}>Veteran</option>
                <option value="Staff" {{ old('status', $user->status) === 'Staff' ? 'selected' : '' }}>Staff</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('status')" />
        </div>

        <div>
            <x-input-label for="branch" :value="__('Military Branch')" />
            <select id="branch" name="branch" required class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-600 focus:ring-orange-500 dark:focus:ring-orange-600 rounded-md shadow-sm" required>
                <option value="">Select Branch</option>
                <option value="Airforce" {{ old('branch', $user->branch) === 'Airforce' ? 'selected' : '' }}>Airforce</option>
                <option value="Airforce Reserve" {{ old('branch', $user->branch) === 'Airforce Reserve' ? 'selected' : '' }}>Airforce Reserve</option>
                <option value="Army" {{ old('branch', $user->branch) === 'Army' ? 'selected' : '' }}>Army</option>
                <option value="Army National Guard" {{ old('branch', $user->branch) === 'Army National Guard' ? 'selected' : '' }}>Army National Guard</option>
                <option value="Army Reserve" {{ old('branch', $user->branch) === 'Army Reserve' ? 'selected' : '' }}>Army Reserve</option>
                <option value="Coast Guard" {{ old('branch', $user->branch) === 'Coast Guard' ? 'selected' : '' }}>Coast Guard</option>
                <option value="Coast Guard Reserve" {{ old('branch', $user->branch) === 'Coast Guard Reserve' ? 'selected' : '' }}>Coast Guard Reserve</option>
                <option value="Marine Corps" {{ old('branch', $user->branch) === 'Marine Corps' ? 'selected' : '' }}>Marine Corps</option>
                <option value="Marine Corps Reserve" {{ old('branch', $user->branch) === 'Marine Corps Reserve' ? 'selected' : '' }}>Marine Corps Reserve</option>
                <option value="Navy" {{ old('branch', $user->branch) === 'Navy' ? 'selected' : '' }}>Navy</option>
                <option value="Navy Reserve" {{ old('branch', $user->branch) === 'Navy Reserve' ? 'selected' : '' }}>Navy Reserve</option>
                <option value="Other" {{ old('branch', $user->branch) === 'Other' ? 'selected' : '' }}>Other</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('branch')" />
        </div>

        <div>
            <x-input-label for="image" :value="__('Verification Image')" />

            @if ($user->image)
                <div class="mt-2 flex items-center gap-4">
                    <img
                        src="{{ asset('storage/' . $user->image) }}"
                        alt="Profile Image"
                        class="h-16 w-16 rounded-full object-cover border border-gray-300 dark:border-gray-700"
                    />

                    <label class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <input type="checkbox" name="remove_image" value="1"
                               class="rounded border-gray-300 dark:border-gray-700">
                        {{ __('Remove current image') }}
                    </label>
                </div>
            @endif

            <input
                id="image"
                name="image"
                type="file"
                accept="image/*"
                class="mt-1 block w-full text-sm text-gray-900 dark:text-gray-100
               file:mr-4 file:py-2 file:px-4
               file:rounded-md file:border-0
               file:text-sm file:font-semibold
               file:bg-gray-100 file:text-gray-700
               dark:file:bg-gray-800 dark:file:text-gray-200"
            />

            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div class="mt-2 text-sm text-gray-600">
            Please upload an image of an official document showing proof of your veteran status.
            More information on valid documents can be found here:
            <a
                href="https://www.va.gov/records/get-veteran-id-cards/"
                target="_blank"
                rel="noopener noreferrer"
                class="text-indigo-600 hover:text-indigo-800 underline"
            >
                https://www.va.gov/records/get-veteran-id-cards/
            </a>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
