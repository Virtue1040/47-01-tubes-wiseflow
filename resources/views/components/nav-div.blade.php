@props(['active'])
@props(['href'])

@php
$classes = ($active ?? false)
            ? 'bg-gray-100 dark:bg-black rounded-xl  px-2 border-b-2 border-[#5E93DA] dark:border-[#5E93DA] text-sm font-medium text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : ' px-2 border-b-2 border-transparent text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    <a href="{{ $href }}" class="w-full h-full">
        {{ $slot }}
    </a>
</div>
