
@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6 flex items-center gap-2">
        {{ __('Profile') }}

        @if(auth()->user()->profile_confirmed)
            {{-- CONFIRMED --}}
            <span title="Profile confirmed" class="inline-flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5 text-green-600"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12.75 11.25 15 15 9.75m-3-7.036
                      A11.959 11.959 0 0 1 3.598 6
                      A11.99 11.99 0 0 0 3 9.749
                      c0 5.592 3.824 10.29 9 11.623
                      c5.176-1.332 9-6.03 9-11.622
                      c0-1.31-.21-2.571-.598-3.751
                      h-.152
                      c-3.196 0-6.1-1.248-8.25-3.285Z"
                />
            </svg>
        </span>
        @else
            {{-- NOT CONFIRMED --}}
            <span title="Profile not confirmed" class="inline-flex items-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.5"
                stroke="currentColor"
                class="h-5 w-5 text-yellow-500"
            >
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 9v3.75m0 3.75h.008
                      M21.75 12a9.75 9.75 0 1 1-19.5 0
                      a9.75 9.75 0 0 1 19.5 0Z"
                />
            </svg>
        </span>
        @endif
    </h2>


    <div class="space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
