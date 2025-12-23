@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE7] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px] max-w-xl mx-auto">

        <h1 class="mb-4 text-xl font-semibold">General Inquiries</h1>

        {{-- Success message --}}
        @if(session('success'))
            <div class="mb-4 rounded-md bg-green-100 border border-green-300 text-green-800 px-4 py-2 text-sm">
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="mb-4 rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-2 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-xs font-semibold mb-1">Name *</label>
                <input type="text" id="name" name="name"
                       value="{{ old('name') }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Phone --}}
            <div>
                <label for="phone" class="block text-xs font-semibold mb-1">Phone</label>
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone') }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-semibold mb-1">Email *</label>
                <input type="email" id="email" name="email"
                       value="{{ old('email') }}"
                       class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
            </div>

            {{-- Preferred Contact Method & Time --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="preferred_contact_method" class="block text-xs font-semibold mb-1">
                        Preferred Contact Method *
                    </label>
                    <select id="preferred_contact_method" name="preferred_contact_method"
                            class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                        <option value="">Select...</option>
                        <option value="Phone" {{ old('preferred_contact_method') == 'Phone' ? 'selected' : '' }}>Phone</option>
                        <option value="Email" {{ old('preferred_contact_method') == 'Email' ? 'selected' : '' }}>Email</option>
                    </select>
                </div>

                <div>
                    <label for="preferred_time" class="block text-xs font-semibold mb-1">
                        Preferred Time to Contact
                    </label>
                    <input type="text" id="preferred_time" name="preferred_time"
                           value="{{ old('preferred_time') }}"
                           class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">
                </div>
            </div>

            {{-- Comments --}}
            <div>
                <label for="comments" class="block text-xs font-semibold mb-1">Comments *</label>
                <textarea id="comments" name="comments" rows="5"
                          class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300">{{ old('comments') }}</textarea>
            </div>

            {{-- reCAPTCHA --}}
            <div>
                <label class="block text-xs font-semibold mb-1">Captcha *</label>
                <div class="g-recaptcha"
                     data-sitekey="{{ config('services.recaptcha.site_key') }}">
                </div>
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-full px-6 py-2 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">
                    SUBMIT
                </button>
            </div>
        </form>
    </section>

    {{-- reCAPTCHA script --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

