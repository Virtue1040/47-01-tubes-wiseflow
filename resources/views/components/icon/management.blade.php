@props(['p', 'l', 'active'])
@php
    $activeColour = ($active ?? false) ? 'fill-[#5E93DA] dark:fill-[#5E93DA]' : 'fill-black dark:fill-white';
@endphp
<svg {{ $attributes->merge(['class' => $activeColour]) }} height="{{ $p }}"  width="{{ $l }}" viewBox="0 0 1024 1024" xmlns="http://www.w3.org/2000/svg"><path  d="M576 128v288l96-96 96 96V128h128v768H320V128h256zm-448 0h128v768H128V128z"/></svg>