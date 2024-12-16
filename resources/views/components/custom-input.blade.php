@props(['disabled' => false, 'readonly' => false, 'placeholder' => 'x', 'type' => 'text', 'values' => '', 'pr' => '40px', 'pl' => '40px', 'extended' => null])
@php
    if ($extended === null) {
        $pr = '8px';
    }
@endphp
<div class="flex relative border-[1px] mt-2 border-gray-200 dark:border-[#464649] h-[38px] bg-gray-200 dark:bg-white dark:bg-opacity-10 dark:text-gray-300 rounded-md">
    <div class="w-[25px] flex justify-center items-center absolute top-1/2 -translate-y-1/2 left-[10px]">
        {{ $slot }}
    </div>
    <input value="{{ $values }}" @readonly($readonly) autocomplete="off" type="{{ $type }}" placeholder="{{ $placeholder }}" @disabled($disabled) {{ $attributes->merge(['class' => 'bg-transparent pl-[40px] pr-[40px] w-full rounded-md']) }}  {{ $attributes }}>
    @if ($extended !== null)
        {{ $extended }}
    @endif
</div>