@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE9]
               border border-[#E4E4E7] dark:border-[#27272a]
               shadow-[0_18px_45px_rgba(15,23,42,0.08)]
               rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]"
    >
        <h1 class="mb-4 text-base font-medium">
            Reset Your Password
        </h1>

        <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
            Enter a new password for your account. After resetting, you’ll be able to log in normally.
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

        {{-- NOTE: classic auth uses route name "password.update" for the POST --}}
        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf

            {{-- Token --}}
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Email --}}
            <div>
                <label for="email"
                       class="block text-[11px] font-medium uppercase tracking-[0.08em]
                              text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('Email Address') }}
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email', $email ?? null) }}"
                    required
                    autofocus
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
            </div>

            {{-- New Password --}}
            <div>
                <label for="password"
                       class="block text-[11px] font-medium uppercase tracking-[0.08em]
                              text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('New Password') }}
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

            {{-- Confirm New Password --}}
            <div>
                <label for="password_confirmation"
                       class="block text-[11px] font-medium uppercase tracking-[0.08em]
                              text-[#52525B] dark:text-[#A1A09A]">
                    {{ __('Confirm New Password') }}
                </label>

                <input
                    id="password_confirmation"
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
                    Reset Password
                </button>
            </div>
        </form>
    </section>
@endsection
