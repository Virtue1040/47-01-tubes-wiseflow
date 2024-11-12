@props(["for"])
@props(["disabled"=>false])

@php
    $disabled = $disabled ? $disabled : '';
    $class = $disabled ? '' : '';
@endphp

<label for="{{ $for }}" {{ $attributes->merge(['class' => $class . 'disabled:bg-gray-300 disabled:text-gray-500 disabled:dark:bg-gray-800 disabled:cursor-not-allowed inline-flex items-center px-4 py-2 border-[1px] border-gray-200 !dark:bg-transparent bg-[#5E93DA] dark:bg-[#5E93DA] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-[#315079] focus:bg-gray-700 dark:focus:bg-[#5E93DA] active:bg-gray-900 dark:active:bg-[#5E93DA] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</label>
