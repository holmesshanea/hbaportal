@extends('layouts.app')

@section('title', 'RSVP Questions')

@section('content')
    <section
        class="bg-white dark:bg-[#161615] dark:text-[#EDEDE7] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px] max-w-2xl mx-auto">

        <h1 class="mb-2 text-xl font-semibold">RSVP Questions</h1>

        <p class="mb-6 text-sm text-gray-600 dark:text-[#A1A09A]">
            Event: <span class="font-semibold text-gray-800 dark:text-[#EDEDE7]">{{ $event->title ?? 'Event' }}</span>
        </p>


        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-100 border border-red-300 text-red-800 px-4 py-2 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('events.rsvp.store', $event) }}" class="space-y-4">
            @csrf

            {{-- keep status if passed in --}}
            <input type="hidden" name="status" value="{{ old('status', $status ?? 'going') }}">

            {{-- 1) Expect (required) --}}
            <div>
                <label for="expect" class="block text-xs font-semibold mb-1">
                    1) What do you expect to get out of attending this Event? <span class="text-red-600">*</span>
                </label>

                <textarea
                    id="expect"
                    name="expect"
                    rows="4"
                    required
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300
                        @error('expect') border-red-500 @enderror"
                ></textarea>

                @error('expect')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 2) Suffer (default None) --}}
            <div>
                <label for="suffer" class="block text-xs font-semibold mb-1">
                    2) List any Afflictions you may be suffering from?
                </label>

                <textarea
                    id="suffer"
                    name="suffer"
                    rows="3"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300
                        @error('suffer') border-red-500 @enderror"
                ></textarea>

                @error('suffer')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 3) Allergies (default None) --}}
            <div>
                <label for="allergies" class="block text-xs font-semibold mb-1">
                    3) List any Allergies?
                </label>

                <textarea
                    id="allergies"
                    name="allergies"
                    rows="3"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300
                        @error('allergies') border-red-500 @enderror"
                ></textarea>

                @error('allergies')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 4) Concerns (default None) --}}
            <div>
                <label for="concerns" class="block text-xs font-semibold mb-1">
                    4) Do you have any other concerns and accommodation needs?
                </label>

                <textarea
                    id="concerns"
                    name="concerns"
                    rows="3"
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300
                        @error('concerns') border-red-500 @enderror"
                ></textarea>

                @error('concerns')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- 5) Code of Conduct (required) --}}
            <div>
                <label for="conduct" class="block text-xs font-semibold mb-1">
                    5) Code of Conduct <span class="text-red-600">*</span>
                </label>

                <p class="mb-2 text-sm text-gray-600 dark:text-[#A1A09A]">
                    <a href="https://homewardboundadirondacks.org/wp-content/uploads/2024/01/hba-code_of_conduct.pdf"
                       target="_blank"
                       rel="noopener"
                       class="text-blue-700 hover:text-blue-800 underline">
                        Click here to read the Code of Conduct (PDF)
                    </a>
                    <span class="block mt-1">
    Enter <span class="font-semibold">Agree</span> to RSVP.
</span>
                </p>

                <input
                    id="conduct"
                    name="conduct"
                    type="text"
                    required
                    placeholder='Type "Agree"'
                    autocomplete="off"
                    value=""
                    class="w-full border rounded-md px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-300
        @error('conduct') border-red-500 @enderror"
                />



                @error('conduct')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="pt-2 flex items-center gap-3">
                <button
                    type="submit"
                    id="submitBtn"
                    disabled
                    class="inline-flex items-center justify-center rounded-md border border-blue-600
           bg-blue-400 px-4 py-2 text-xs font-semibold text-white
           cursor-not-allowed transition
           focus:outline-none"
                >
                    Submit RSVP
                </button>


                <a href="{{ url()->previous() }}"
                   class="inline-flex items-center justify-center rounded-md border border-gray-300
                          bg-gray-100 px-4 py-2 text-xs font-semibold text-gray-800
                          hover:bg-gray-200 transition
                          dark:bg-[#1f1f1e] dark:border-[#2b2b2a] dark:text-[#EDEDE7]">
                    Cancel
                </a>
            </div>
        </form>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const conductInput = document.getElementById('conduct');
                const submitBtn = document.getElementById('submitBtn');

                function toggleSubmit() {
                    if (conductInput.value === 'Agree') {
                        submitBtn.disabled = false;
                        submitBtn.classList.remove('bg-blue-400', 'cursor-not-allowed');
                        submitBtn.classList.add('bg-blue-600', 'hover:bg-blue-700', 'hover:border-blue-700');
                    } else {
                        submitBtn.disabled = true;
                        submitBtn.classList.add('bg-blue-400', 'cursor-not-allowed');
                        submitBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'hover:border-blue-700');
                    }
                }

                conductInput.addEventListener('input', toggleSubmit);
                toggleSubmit(); // run once on page load
            });
        </script>
    </section>
@endsection
