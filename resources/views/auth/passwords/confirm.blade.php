@extends('layouts.app')

@section('title', 'Confirm Password')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE9]
               border border-[#E4E4E7] dark:border-[#27272a]
               shadow-[0_18px_45px_rgba(15,23,42,0.08)]
               rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]"
    >
        <h1 class="mb-4 text-base font-medium">
            Confirm Your Password
        </h1>

        <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
            For your security, please confirm your password before continuing.
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

        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
            @csrf

            {{-- Password --}}
            <div>
                <label for="password"
                       class="block text-[11px] font-medium uppercase tracking-[0.08em]
                              text-[#52525B] dark:text-[#A1A09A]">
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
            </div>

            <div class="flex flex-col gap-3 pt-2 sm:flex-row sm:items-center sm:justify-between">
                {{-- Submit --}}
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-sm border border-transparent
                           bg-[#f97316] px-4 py-2 text-[12px] font-medium tracking-wide text-white
                           hover:bg-[#ea580c] focus:outline-none focus:ring-2 focus:ring-[#fed7aa]
                           focus:ring-offset-1 focus:ring-offset-[#fdfdfc] dark:focus:ring-offset-[#050505]"
                >
                    {{ __('Confirm Password') }}
                </button>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-[12px] text-[#f97316] underline underline-offset-4 hover:text-[#ea580c]"
                    >
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </section>
@endsection
