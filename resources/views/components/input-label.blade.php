
@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block text-[11px] font-medium uppercase tracking-[0.08em] text-[#52525B] dark:text-[#A1A09A]']) }}>
    {{ $value ?? $slot }}
    @if($required)
        <span class="text-red-500">*</span>
    @endif
</label>
