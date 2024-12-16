
@props(['p', 'l', 'active'])
@php
    // $activeColour = ($active ?? false) ? 'fill-[#5E93DA] dark:fill-[#5E93DA]' : 'fill-black dark:fill-white';
@endphp
<svg {{ $attributes->merge(['class' => '']) }} height="{{ $p }}"  width="{{ $l }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-160v-240h120v240H200Zm240 0v-440h120v440H440Z"/></svg>