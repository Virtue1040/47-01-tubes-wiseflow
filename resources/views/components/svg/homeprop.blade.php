@props(['p', 'l', 'active'])
@php
    $activeColour = ($active ?? false) ? 'fill-[#5E93DA] dark:fill-[#5E93DA]' : 'fill-black dark:fill-white';
@endphp
<svg {{ $attributes->merge(['class' => $activeColour]) }} height="{{ $p }}"  width="{{ $l }}" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
<path d="M1 6V15H6V11C6 9.89543 6.89543 9 8 9C9.10457 9 10 9.89543 10 11V15H15V6L8 0L1 6Z"/>
</svg>