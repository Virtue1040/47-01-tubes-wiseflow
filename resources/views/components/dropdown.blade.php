                {{-- <x-dropdown align="left" width="48" contentClasses="py-2 bg-gray-100 dark:bg-gray-800">
   
                    <x-slot name="trigger">
                        <button class="px-4 py-2 text-white bg-blue-500 rounded">
                            Open Dropdown
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Option 1</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Option 2</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-200">Option 3</a>
                    </x-slot>
                </x-dropdown> --}}

@props(['align' => 'right', 'width' => 'w-48', 'contentClasses' => 'bg-white dark:bg-[#18181B] p-1 border-gray-200 dark:border-[#464649] border-[1px]']) 

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $width }} shadow-lg {{ $alignmentClasses }}"
            style=""
            @click="open = false">
        <div class="rounded-2xl ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
