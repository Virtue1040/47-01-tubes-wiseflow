@props(['id', 'value', 'name', 'checked'])
@php
    $checked = $checked ? $checked : '';
@endphp

<div {{ $attributes->merge(['class' => 'relative dark:bg-white dark:bg-opacity-10 rounded-3xl shadow-lg']) }}>
    <input class="peer hidden w-full min-h-[35px] bg-gray-200" id="{{ $id }}"
        value="{{ $value }}" type="radio" name="{{ $name }}" @checked($checked) />
        
    <div class="hidden absolute z-[2] top-[-15px] left-1/2 -translate-x-1/2 w-[30px] h-[30px] peer-checked:flex justify-center items-center bg-[#5E93DA] rounded-full p-1">
        <x-icon.checklist></x-icon.checklist>
    </div>
    <div class=" z-0 relative w-full h-full border-[#42699c] rounded-3xl hover:border-4 peer-checked:border-4 peer-checked:border-[#5E93DA]">
        <x-input-label for="{{ $id }}" class="w-full h-full text-xl cursor-pointer flex flex-col gap-[10px] justify-center items-center">
            {{ $slot }}
            
        </x-input-label>
    </div>
</div>