<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</head>

<body
    class="min-h-screen flex flex-col bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#E4E4E7] antialiased"
>

{{-- HEADER / NAV --}}
{{-- HEADER / NAV --}}
<header
    x-data="{ mobileOpen: false }"
    class="border-b border-[#E4E4E7]/70 dark:border-[#27272a] bg-[#fdfcfa]/80 dark:bg-[#050505]/80 backdrop-blur"
>
    <div class="mx-auto w-full max-w-4xl px-4 py-3 flex items-center justify-between gap-4">

        {{-- LEFT: LOGO --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-2 font-semibold text-lg tracking-tight">
            <x-application-logo class="h-8 w-8" />
            <span>{{ config('app.name') }}</span>
        </a>

        @if (Route::has('login'))
            @auth
                @php
                    $user = auth()->user();

                    $isAdminRole = false;
                    if (method_exists($user, 'hasAnyRole')) {
                        $isAdminRole = $user->hasAnyRole(['admin', 'super', 'Admin', 'Super', 'super user', 'Super User']);
                    } elseif (method_exists($user, 'hasRole')) {
                        $isAdminRole = $user->hasRole('admin') || $user->hasRole('super') || $user->hasRole('Admin') || $user->hasRole('Super');
                    } else {
                        $roleValue = strtolower((string) ($user->role ?? ''));
                        $isAdminRole = in_array($roleValue, ['admin', 'super', 'super user'], true);
                    }

                    $dashboardRouteName = $isAdminRole ? 'admin.dashboard' : 'dashboard';
                    $dashboardRoute = route($dashboardRouteName);

                    // convenience flags
                    $onHome = request()->routeIs('home') || request()->is('/');
                    $onProfile = request()->routeIs('profile.edit');
                    $onDashboard = request()->routeIs($dashboardRouteName);
                @endphp
            @endauth

            {{-- RIGHT SIDE --}}
            <div class="flex items-center gap-3">

                {{-- DESKTOP NAV (sm and up) --}}
                <nav class="hidden sm:flex items-center gap-3 text-sm">
                    @auth
                        {{-- USER NAME + CONFIRMATION ICON --}}
                        <span class="flex items-center gap-2 text-sm text-[#52525B] dark:text-[#E4E4E7]">
                            @if($user->profile_confirmed)
                                <span title="Profile confirmed" class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-green-600">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M9 12.75 11.25 15 15 9.75m-3-7.036
                                              A11.959 11.959 0 0 1 3.598 6
                                              A11.99 11.99 0 0 0 3 9.749
                                              c0 5.592 3.824 10.29 9 11.623
                                              c5.176-1.332 9-6.03 9-11.622
                                              c0-1.31-.21-2.571-.598-3.751
                                              h-.152
                                              c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                                    </svg>
                                </span>
                            @else
                                <span title="Profile not confirmed" class="inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                         stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-yellow-500">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 9v3.75m0 3.75h.008
                                              M21.75 12a9.75 9.75 0 1 1-19.5 0
                                              a9.75 9.75 0 0 1 19.5 0Z"/>
                                    </svg>
                                </span>
                            @endif

                            {{ $user->name }}
                        </span>

                        @unless($onHome)
                            <a href="{{ url('/') }}" class="px-4 py-1.5 rounded-sm border transition-colors">Home</a>
                        @endunless

                        @unless($onProfile)
                            <a href="{{ route('profile.edit') }}" class="px-4 py-1.5 rounded-sm border transition-colors">Profile</a>
                        @endunless

                        @unless($onDashboard)
                            <a href="{{ $dashboardRoute }}" class="px-4 py-1.5 rounded-sm border transition-colors">Dashboard</a>
                        @endunless

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-4 py-1.5 text-[#f97316] hover:text-[#ea580c] transition-colors">
                                Logout
                            </button>
                        </form>
                    @endauth

                    @guest
                        <a href="{{ route('login') }}" class="px-4 py-1.5 border rounded-sm">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-1.5 text-[#f97316] hover:text-[#ea580c]">
                                Register
                            </a>
                        @endif
                    @endguest
                </nav>

                {{-- HAMBURGER BUTTON (mobile only) --}}
                <button
                    type="button"
                    class="sm:hidden inline-flex items-center justify-center rounded-md border px-3 py-2"
                    @click="mobileOpen = !mobileOpen"
                    :aria-expanded="mobileOpen.toString()"
                    aria-controls="mobile-menu"
                    aria-label="Toggle menu"
                >
                    {{-- icon: hamburger / X --}}
                    <svg x-show="!mobileOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif
    </div>

    {{-- MOBILE MENU PANEL --}}
    @if (Route::has('login'))
        <div
            id="mobile-menu"
            class="sm:hidden px-4 pb-3"
            x-show="mobileOpen"
            x-transition
            x-cloak
            @click.outside="mobileOpen = false"
        >
            <div class="mt-2 rounded-lg border border-[#E4E4E7]/70 dark:border-[#27272a] bg-white/90 dark:bg-[#050505]/90 backdrop-blur p-3 space-y-2 text-sm">

                @auth
                    <div class="flex items-center gap-2 text-sm text-[#52525B] dark:text-[#E4E4E7] pb-2 border-b border-[#E4E4E7]/60 dark:border-[#27272a]">
                        @if($user->profile_confirmed)
                            <span title="Profile confirmed" class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-green-600">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12.75 11.25 15 15 9.75m-3-7.036
                                          A11.959 11.959 0 0 1 3.598 6
                                          A11.99 11.99 0 0 0 3 9.749
                                          c0 5.592 3.824 10.29 9 11.623
                                          c5.176-1.332 9-6.03 9-11.622
                                          c0-1.31-.21-2.571-.598-3.751
                                          h-.152
                                          c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                                </svg>
                            </span>
                        @else
                            <span title="Profile not confirmed" class="inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-yellow-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v3.75m0 3.75h.008
                                          M21.75 12a9.75 9.75 0 1 1-19.5 0
                                          a9.75 9.75 0 0 1 19.5 0Z"/>
                                </svg>
                            </span>
                        @endif
                        <span class="font-medium">{{ $user->name }}</span>
                    </div>

                    @unless($onHome)
                        <a @click="mobileOpen=false" href="{{ url('/') }}" class="block w-full px-3 py-2 rounded-md border">Home</a>
                    @endunless

                    @unless($onProfile)
                        <a @click="mobileOpen=false" href="{{ route('profile.edit') }}" class="block w-full px-3 py-2 rounded-md border">Profile</a>
                    @endunless

                    @unless($onDashboard)
                        <a @click="mobileOpen=false" href="{{ $dashboardRoute }}" class="block w-full px-3 py-2 rounded-md border">Dashboard</a>
                    @endunless

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-3 py-2 rounded-md border text-[#f97316] hover:text-[#ea580c] transition-colors">
                            Logout
                        </button>
                    </form>
                @endauth

                @guest
                    <a @click="mobileOpen=false" href="{{ route('login') }}" class="block w-full px-3 py-2 rounded-md border">Login</a>

                    @if (Route::has('register'))
                        <a @click="mobileOpen=false" href="{{ route('register') }}" class="block w-full px-3 py-2 rounded-md border text-[#f97316] hover:text-[#ea580c]">
                            Register
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-4 rounded border border-green-300 bg-green-50 px-4 py-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded border border-red-300 bg-red-50 px-4 py-3 text-red-800">
            {{ session('error') }}
        </div>
    @endif
</header>


{{-- MAIN --}}
<main class="flex-1">
    <div class="mx-auto w-full max-w-4xl px-4 py-8">
        @yield('content')
    </div>
</main>

{{-- Footer --}}
<footer class="border-t border-[#E4E4E7]/70 dark:border-[#27272a]">
    <div class="mx-auto max-w-4xl px-4 py-4 text-xs text-center">
        <div>
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>

        <nav aria-label="Footer" class="mt-2">
            <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">
                <li>
                    <a href="{{ route('terms') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Terms of Use
                    </a>
                </li>
                <li>
                    <a href="{{ route('privacy') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Privacy Policy
                    </a>
                </li>
                <li>
                    <a href="{{ route('faq') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        FAQ
                    </a>
                </li>
                <li>
                    <a href="{{ route('contact.show') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Contact Us
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</footer>
</body>
</html>
