@props(['name' => 'null', 'disableDropdown' => false, 'open' => true, 'extended' => '', 'padding' => '25px'])
@php
    $disabledClass = '';
    $disabledClass2 = '';
    if ($disableDropdown) {
        $disabledClass = 'pointer-events-none';
        $disabledClass2 = 'hidden';
    }
@endphp
<div x-data="{ openDropdown: @php
    if ($open) {
        echo 'true';
    } else {
        echo 'false';
    }
@endphp }"
    {{ $attributes->merge(['class' => 'flex flex-col bg-white dark:bg-[#18181B] rounded-2xl shadow-sm h-fit border-gray-200 dark:border-[#272729] border-[1px]']) }}>
    @if ($name !== 'null')
        <button @click="openDropdown = ! openDropdown" @disabled($disableDropdown)
            class="{{ $disabledClass }} w-full flex justify-between items-center h-auto p-[25px] py-[15px] hover:bg-gray-50 dark:hover:bg-[rgb(250,250,250)] dark:hover:bg-opacity-10  rounded-xl">
            <div class="flex w-[90%] items-center ">
                <x-a-label class="text-xl font-bold truncate">{{__($name)}}</x-a-label>{{ $extended }}
            </div>
            @if(!$disableDropdown) 
                <div :class="{ 'rotate-90': !openDropdown }" class="{{ $disabledClass2 }} -rotate-90">
                    <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                </div>
            @endif
        </button>
    @endif
    <div class="overflow-hidden h-full">    
        <div class="p-[{{ $padding }}] h-full" x-show="openDropdown"
            x-transition:enter="transition-transform ease-out duration-300"
            x-transition:enter-start="translate-y-[-100%]" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition-transform ease-in duration-200" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-[-100%]">
            {{ $slot }}
        </div>
    </div>
</div>
