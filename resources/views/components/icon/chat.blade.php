@props(['p', 'l', 'active'])
@php
    $activeColour = ($active ?? false) ? 'fill-[#5E93DA] dark:fill-[#5E93DA]' : 'fill-black dark:fill-white';
@endphp
<svg {{ $attributes->merge(['class' => $activeColour]) }} height="{{ $p }}"  width="{{ $l }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M240-400h320v-80H240v80Zm0-120h480v-80H240v80Zm0-120h480v-80H240v80ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z"/></svg>