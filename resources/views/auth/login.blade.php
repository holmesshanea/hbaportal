@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE9]
               border border-[#E4E4E7] dark:border-[#27272a]
               shadow-[0_18px_45px_rgba(15,23,42,0.08)]
               rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]"
    >
        <h1 class="mb-4 text-base font-medium">
            Login
        </h1>

        <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
            Sign in to access your HBA Portal account and manage your information, retreat registrations,
            and peer-to-peer events.
        </p>

        @if (session('status'))
            <div class="mb-4 rounded-md border border-emerald-300 bg-emerald-50 px-3 py-2 text-xs text-emerald-900">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

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
                    autofocus
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
                @error('email')
                <p class="mt-1 text-xs text-red-600">
                    {{ $message }}
                </p>
                @enderror
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
                    autocomplete="current-password"
                    class="mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2
                           text-[13px] text-[#1b1b18] outline-none
                           focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316]
                           dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]"
                >
                @error('password')
                <p class="mt-1 text-xs text-red-600">
                    {{ $message }}
                </p>
                @enderror
            </div>

            {{-- Remember Me + Forgot Password --}}
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <label class="inline-flex items-center gap-2 text-[12px] text-[#52525B] dark:text-[#A1A09A]">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="h-4 w-4 rounded border-[#E4E4E7] text-[#f97316] focus:ring-[#f97316]
                               dark:border-[#27272a] dark:bg-[#09090b]"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <span>{{ __('Remember Me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        class="text-[12px] text-[#f97316] hover:text-[#ea580c] underline underline-offset-4"
                        href="{{ route('password.request') }}"
                    >
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
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
                    {{ __('Login') }}
                </button>
            </div>
        </form>
    </section>
@endsection
