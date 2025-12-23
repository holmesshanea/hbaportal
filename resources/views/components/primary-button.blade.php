
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center rounded-sm border border-transparent bg-[#f97316] px-4 py-2 text-[12px] font-medium tracking-wide text-white hover:bg-[#ea580c] focus:outline-none focus:ring-2 focus:ring-[#fed7aa] focus:ring-offset-1 focus:ring-offset-[#fdfdfc] dark:focus:ring-offset-[#050505]']) }}>
    {{ $slot }}
</button>
