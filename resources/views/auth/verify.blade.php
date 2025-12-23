@extends('layouts.app')

@section('title', 'Verify Email')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE9]
               border border-[#E4E4E7] dark:border-[#27272a]
               shadow-[0_18px_45px_rgba(15,23,42,0.08)]
               rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]"
    >
        <h1 class="mb-4 text-base font-medium">
            Verify Your Email Address
        </h1>

        <p class="mb-4 text-[#706f6c] dark:text-[#A1A09A]">
            Before you can access all features of the HBA Portal, we need to verify your email address.
            We’ve sent a verification link to the address you provided during registration.
        </p>

        <p class="mb-6 text-[#706f6c] dark:text-[#A1A09A]">
            If you didn’t receive the email, you can request another verification link below.
        </p>

        @if (session('resent') || session('status') === 'verification-link-sent')
            <div class="mb-6 rounded-md border border-emerald-300 bg-emerald-50 px-3 py-2 text-xs text-emerald-900">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            {{-- Resend verification link --}}
            <form method="POST" action="{{ route('verification.resend') }}" class="flex items-center gap-3">
                @csrf
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-sm border border-transparent
                           bg-[#f97316] px-4 py-2 text-[12px] font-medium tracking-wide text-white
                           hover:bg-[#ea580c] focus:outline-none focus:ring-2 focus:ring-[#fed7aa]
                           focus:ring-offset-1 focus:ring-offset-[#fdfdfc] dark:focus:ring-offset-[#050505]"
                >
                    Resend Verification Email
                </button>
            </form>

            {{-- Optional: Log out --}}
            <form method="POST" action="{{ route('logout') }}" class="text-right">
                @csrf
                <button
                    type="submit"
                    class="text-[12px] text-[#6b7280] underline underline-offset-4 hover:text-[#4b5563]
                           dark:text-[#A1A09A]"
                >
                    Log out
                </button>
            </form>
        </div>
    </section>
@endsection
