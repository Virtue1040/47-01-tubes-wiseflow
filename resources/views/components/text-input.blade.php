@props(['disabled' => false, 'readonly' => false, 'values' => '', 'value' => ''])
@php
    if ($readonly === 'true') {
        $readonly = true;
    } else {
        $readonly = false;
    }

    if ($value !== '') {
        $values = $value;
    }
@endphp
<input value="{{ $values }}" autocomplete="off" @disabled($disabled) @readonly($readonly) {{ $attributes->merge(['class' => 'border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md ']) }}>
