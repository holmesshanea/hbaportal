@extends('layouts.app')

@section('title', 'Add event')

@section('content')
    <section class="bg-white dark:bg-[#161615] dark:text-[#EDEDEC] rounded-lg p-6 lg:p-10 text-[13px] leading-[20px]">
        <div class="max-w-2xl mx-auto">

            @php
                $labelClasses = 'inline-block mb-1 px-2 py-1 rounded text-xs font-bold bg-emerald-600 text-white';
            @endphp

            <h1 class="text-base font-semibold mb-4">Add event</h1>

            @if ($errors->any())
                <div class="mb-4 border border-red-300 bg-red-50 text-red-800 text-xs p-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $eventType = old('event_type', 'retreat');

                if ($eventType === 'retreat') {
                    $defaultDescription = <<<'TEXT'
            Register now and join us for a weekend of nature therapy and peer connections in the beautiful Adirondack Mountains. Meet and recreate with other veterans. Veterans build resilience and support networks through peer to peer discussions and activities. Retreats offer an opportunity to build comradery with other Vets while relaxing in a wilderness environment. Retreats are free once people arrive - however we are not in a position to pay for transportation to get to and from the retreat venue. Our screening process involves direct contact from a HBA Case Manager for all registered veterans to assess eligibility and prioritize attendance. Although all veterans are welcome and encouraged to apply, we're focusing first on veterans enrolled in our Case Management and those who haven't yet experienced a retreat, particularly those facing service-related challenges. If a retreat reaches capacity under these criteria, we may need to schedule you for a later date. We understand this might be inconvenient and appreciate your understanding. Our goal is to support as many veterans as possible, prioritizing those dealing with service-related trauma or difficulties. A member of our HBA team will be in touch shortly for a pre-screening discussion about your specific situation. If there are any cancellations, those first on the waiting list, will be offered these on first come basis. Feel free to contact Homeward Bound Adirondacks to get on the waiting list. If you need to cancel, please cancel with HBA as soon as possible. Please do not wait until the day before the retreat. An empty RSVP is one veteran who misses out.
            TEXT;
                } else {
                    $defaultDescription = <<<'TEXT'
            Register now and join us for a one-day peer connection event hosted by Homeward Bound Adirondacks. These events are designed to bring veterans together in a supportive, welcoming environment to connect with peers, share experiences, and strengthen community bonds. Our peer connection events provide opportunities for meaningful conversation, camaraderie, and engagement through facilitated discussions and group activities. Whether you are new to Homeward Bound Adirondacks or a returning participant, these events offer a low-commitment way to connect with other veterans and learn more about available supports and services.            This is a single-day event and does not include overnight accommodations. Participants are responsible for their own transportation to and from the event location unless otherwise noted. While all veterans are welcome and encouraged to register, space may be limited. Registration helps us plan appropriately and ensure a positive experience for all attendees. If the event reaches capacity, you may be placed on a waiting list and contacted if space becomes available. If you need to cancel your registration, please notify Homeward Bound Adirondacks as soon as possible. Early cancellations allow another veteran the opportunity to attend.
            TEXT;
                }
            @endphp


            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden text-xs border-l-4 border-l-emerald-500">
                    <table class="min-w-full">
                        <tbody>

                        {{-- Type --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top w-44">
                                <span class="{{ $labelClasses }}">Type</span>
                            </td>
                            <td class="px-3 py-3">
                                <select name="event_type" id="event_type"
                                        class="w-full border rounded px-3 py-2 text-xs"
                                        required>
                                    <option value="retreat" {{ old('event_type', 'retreat') === 'retreat' ? 'selected' : '' }}>
                                        Retreat
                                    </option>
                                    <option value="event" {{ old('event_type') === 'event' ? 'selected' : '' }}>
                                        Event
                                    </option>
                                </select>
                            </td>
                        </tr>

                        {{-- Title --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top w-44">
                                <span class="{{ $labelClasses }}">Title</span>
                            </td>
                            <td class="px-3 py-3">
                                <input type="text" name="title"
                                       value="{{ old('title') }}"
                                       class="w-full border rounded px-3 py-2 text-xs"
                                       required>
                            </td>
                        </tr>


                        {{-- Short Description --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Short Description</span>
                            </td>
                            <td class="px-3 py-3">
                                <textarea name="short_description" rows="2"
                                          class="w-full border rounded px-3 py-2 text-xs">{{ old('short_description') }}</textarea>
                            </td>
                        </tr>

                        {{-- Description (TinyMCE) --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Description</span>
                            </td>
                            <td class="px-3 py-3">
                                <textarea id="description" name="description" rows="6"
                                          class="w-full border rounded px-3 py-2 text-xs">{{ old('description', $defaultDescription) }}</textarea>
                            </td>
                        </tr>

                        {{-- Location --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Location</span>
                            </td>
                            <td class="px-3 py-3">
                                <input type="text" name="location"
                                       value="{{ old('location') }}"
                                       class="w-full border rounded px-3 py-2 text-xs">
                            </td>
                        </tr>

                        {{-- Start Date / Time --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Start Date</span><br>
                                <span class="{{ $labelClasses }}">Start Time</span>
                            </td>
                            <td class="px-3 py-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input type="date" name="start_date"
                                           value="{{ old('start_date') }}"
                                           class="w-full border rounded px-3 py-2 text-xs" required>
                                    <input type="time" name="start_time"
                                           value="{{ old('start_time') }}"
                                           class="w-full border rounded px-3 py-2 text-xs">
                                </div>
                            </td>
                        </tr>

                        {{-- End Date / Time --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">End Date</span><br>
                                <span class="{{ $labelClasses }}">End Time</span>
                            </td>
                            <td class="px-3 py-3">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input type="date" name="end_date"
                                           value="{{ old('end_date') }}"
                                           class="w-full border rounded px-3 py-2 text-xs" required>
                                    <input type="time" name="end_time"
                                           value="{{ old('end_time') }}"
                                           class="w-full border rounded px-3 py-2 text-xs">
                                </div>
                            </td>
                        </tr>

                        {{-- Capacity --}}
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Capacity</span>
                            </td>
                            <td class="px-3 py-3">
                                <input type="number" name="capacity"
                                       value="{{ old('capacity') }}"
                                       class="w-full border rounded px-3 py-2 text-xs" min="0">
                            </td>
                        </tr>

                        {{-- Image Upload --}}
                        <tr>
                            <td class="px-3 py-3 align-top">
                                <span class="{{ $labelClasses }}">Image</span>
                            </td>
                            <td class="px-3 py-3">
                                <input type="file" name="image" accept="image/*"
                                       class="w-full border rounded px-3 py-2 text-xs">
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex items-center gap-2">
                    <button type="submit" class="px-4 py-2 text-xs rounded border bg-blue-600 text-white">
                        Save
                    </button>

                    <a href="{{ route('admin.events.index') }}" class="text-xs underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </section>
@endsection


@push('scripts')
    {{-- TinyMCE --}}
    <script src="https://cdn.tiny.cloud/1/rbpygo1o7hzjbtnx0ha05r1q4krs6k6dlemieo3eskxue3xa/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof tinymce === 'undefined') return;

            tinymce.init({
                selector: '#description',
                height: 320,
                menubar: false,
                plugins: 'lists link',
                toolbar: 'undo redo | bold italic underline | bullist numlist | link | removeformat',
                branding: false,
                content_style: `
                     a { color: #0000ee !important; text-decoration: underline !important; }
                    a:link { color: #0000ee !important; text-decoration: underline !important; }
                    a:visited { color: #551a8b !important; text-decoration: underline !important; }
                    a:active { color: #ee0000 !important; text-decoration: underline !important; }
                    a:hover { cursor: pointer; }
                `
            });
        });
    </script>

    {{-- Event Type / Descdription Values --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('event_type');
            const descriptionField = document.getElementById('description');

            if (!typeSelect || !descriptionField) return;

            const templates = {
                retreat: `Register now and join us for a weekend of nature therapy and peer connections in the beautiful Adirondack Mountains. Meet and recreate with other veterans. Veterans build resilience and support networks through peer to peer discussions and activities. Retreats offer an opportunity to build comradery with other Vets while relaxing in a wilderness environment. Retreats are free once people arrive - however we are not in a position to pay for transportation to get to and from the retreat venue. Our screening process involves direct contact from a HBA Case Manager for all registered veterans to assess eligibility and prioritize attendance. Although all veterans are welcome and encouraged to apply, we're focusing first on veterans enrolled in our Case Management and those who haven't yet experienced a retreat, particularly those facing service-related challenges. If a retreat reaches capacity under these criteria, we may need to schedule you for a later date. We understand this might be inconvenient and appreciate your understanding. Our goal is to support as many veterans as possible, prioritizing those dealing with service-related trauma or difficulties. A member of our HBA team will be in touch shortly for a pre-screening discussion about your specific situation. If there are any cancellations, those first on the waiting list, will be offered these on first come basis. Feel free to contact Homeward Bound Adirondacks to get on the waiting list. If you need to cancel, please cancel with HBA as soon as possible. Please do not wait until the day before the retreat. An empty RSVP is one veteran who misses out.`,

                event: `Register now and join us for a one-day peer connection event hosted by Homeward Bound Adirondacks. These events are designed to bring veterans together in a supportive, welcoming environment to connect with peers, share experiences, and strengthen community bonds. Our peer connection events provide opportunities for meaningful conversation, camaraderie, and engagement through facilitated discussions and group activities. Whether you are new to Homeward Bound Adirondacks or a returning participant, these events offer a low-commitment way to connect with other veterans and learn more about available supports and services. This is a single-day event and does not include overnight accommodations. Participants are responsible for their own transportation to and from the event location unless otherwise noted. While all veterans are welcome and encouraged to register, space may be limited. Registration helps us plan appropriately and ensure a positive experience for all attendees. If the event reaches capacity, you may be placed on a waiting list and contacted if space becomes available. If you need to cancel your registration, please notify Homeward Bound Adirondacks as soon as possible. Early cancellations allow another veteran the opportunity to attend.`
            };

            let lastType = (typeSelect.value || '').toLowerCase();
            let userEdited = false;

            function getTinyEditor() {
                if (typeof tinymce === 'undefined') return null;
                return tinymce.get('description') || null;
            }

            function getCurrentDescription() {
                const ed = getTinyEditor();
                if (ed) return (ed.getContent({ format: 'text' }) || '').trim();
                return (descriptionField.value || '').trim();
            }

            function setDescription(text) {
                const ed = getTinyEditor();
                if (ed) {
                    ed.setContent(text);                 // updates what user sees
                    descriptionField.value = text;       // keeps textarea in sync for submit
                } else {
                    descriptionField.value = text;
                }
            }

            function applyTemplate(nextTypeRaw) {
                const nextType = (nextTypeRaw || '').toLowerCase();
                if (!templates[nextType]) return;

                const current = getCurrentDescription();
                const prevTemplateText = templates[lastType] ? templates[lastType].trim() : null;

                // overwrite only if empty OR not edited OR still equals previous template
                if (current === '' || !userEdited || (prevTemplateText && current === prevTemplateText)) {
                    setDescription(templates[nextType]);
                    userEdited = false;
                }

                lastType = nextType;
            }

            // Change type -> apply template
            typeSelect.addEventListener('change', function () {
                applyTemplate(typeSelect.value);
            });

            // Track edits (textarea fallback)
            descriptionField.addEventListener('input', function () {
                userEdited = true;
            });

            // Track edits (TinyMCE)
            const waitForEditor = setInterval(function () {
                const ed = getTinyEditor();
                if (!ed) return;

                clearInterval(waitForEditor);

                ed.on('input change keyup', function () {
                    userEdited = true;
                });

                // Optional: if blank, auto-fill based on current selection when editor becomes ready
                if (getCurrentDescription() === '') {
                    applyTemplate(typeSelect.value);
                }
            }, 100);
        });
    </script>
@endpush
