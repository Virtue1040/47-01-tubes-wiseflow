@props(['active'])
@props(['href'])

@php
$classes = ($active ?? false)
            ? 'dark:bg-[#FAFAFA] dark:bg-opacity-10 bg-gray-100 rounded-xl text-sm font-medium h-auto text-[#5E93DA] dark:text-[#5E93DA] focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 hover:bg-gray-100 rounded-xl text-sm h-auto font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <a href="{{ $href }}" class="w-full h-full flex gap-[2px]">
        {{ $slot }}
    </a>
</div>
