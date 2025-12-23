@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'mt-1 block w-full rounded-md border border-[#E4E4E7] bg-white px-3 py-2 text-[13px] text-[#1b1b18] outline-none focus:border-[#f97316] focus:ring-1 focus:ring-[#f97316] dark:bg-[#09090b] dark:border-[#27272a] dark:text-[#EDEDE9]']) !!}>
