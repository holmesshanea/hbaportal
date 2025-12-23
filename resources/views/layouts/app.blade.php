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

<body class="min-h-screen flex flex-col bg-[#F5F4ED] dark:bg-[#161615] text-[#25241f] dark:text-[#F5F4ED]">

<main class="flex-grow">
    {{ $slot ?? '' }}
    @yield('content')
</main>

<footer class="border-t border-[#DAD9D0] dark:border-[#262522] bg-white dark:bg-[#161615]">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <nav class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-sm">
            <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-2">

                <li>
                    <a href="{{ route('home') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A] hover:text-gray-900 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Home
                    </a>
                </li>

                <li>
                    <a href="{{ route('terms') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A] hover:text-gray-900 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Terms & Conditions
                    </a>
                </li>

                <!-- NEW: Code of Conduct -->
                <li>
                    <a href="{{ route('code') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A] hover:text-gray-900 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Code of Conduct
                    </a>
                </li>

                <li>
                    <a href="{{ route('faq') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A] hover:text-gray-900 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        FAQ
                    </a>
                </li>

                <li>
                    <a href="{{ route('contact.show') }}"
                       class="text-[#706f6c] dark:text-[#A1A09A] hover:text-gray-900 dark:hover:text-gray-200 underline-offset-4 hover:underline">
                        Contact Us
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</footer>

</body>
</html>
