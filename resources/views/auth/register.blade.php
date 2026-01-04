@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE9]
               border border-[#E4E4E7] dark:border-[#27272a]
               shadow-[0_18px_45px_rgba(15,23,42,0.08)]
               rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]"
    >
        <h1 class="mb-4 text-base font-medium">
            Create an Account
        </h1>

        <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
            Register to access your HBA Portal account, RSVP for retreats, and stay connected with veteran support services.
        </p>

        @if ($errors->any())
            <div class="mb-6 rounded-md border border-red-300 bg-red-50 px-3 py-2 text-xs text-red-800">
                <ul class="space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- Name --}}

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label for="last_name" class="block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]">
                        {{ __('Last Name') }}
                    </label>
                    <input
                        id="last_name"
                        type="text"
                        name="last_name"
                        value="{{ old('last_name') }}"
                        required
                        autofocus
                        autocomplete="family-name"
                        class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                               text-[13px] text-[#1b1b18] outline-none
                               focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                               dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                    >
                </div>

                <div>
                    <label for="first_name" class="block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]">
                        {{ __('First Name') }}
                    </label>
                    <input
                        id="first_name"
                        type="text"
                        name="first_name"
                        value="{{ old('first_name') }}"
                        required
                        autocomplete="given-name"
                        class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                               text-[13px] text-[#1b1b18] outline-none
                               focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                               dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                    >
                </div>
                >
            </div>

            {{-- Email --}}
            <div>
                <label for="email" class="block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('Email Address') }}
                </label>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
            </div>

            {{-- Password --}}
            <div>
                <label for="password" class="block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('Password') }}
                </label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
            </div>

            {{-- Confirm Password --}}
            <div>
                <label for="password-confirm" class="block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('Confirm Password') }}
                </label>
                <input
                    id="password-confirm"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-sm border border-transparent
                           bg-[#f97316] px-4 py-2 text-[12px] font-medium tracking-wide text-white
                           hover:bg-[#ea580c] focus:outline-none focus:ring-2 focus:ring-[#fed7aa]
                           focus:ring-offset-1 focus:ring-offset-[#fdfdfc] dark:focus:ring-offset-[#050505]"
                >
                    {{ __('Register') }}
                </button>
            </div>

            {{-- Already have an account? --}}
            <p class="pt-2 text-[12px] text-[#6b7280] dark:text-[#A1A09A]">
                Already registered?
                <a href="{{ route('login') }}" class="text-[#f97316] underline underline-offset-4 hover:text-[#ea580c]">
                    Sign in
                </a>
            </p>
        </form>
    </section>
@endsection
