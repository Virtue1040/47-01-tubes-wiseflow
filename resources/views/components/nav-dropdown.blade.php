@props(["name", 'open' => true, 'useBack' => false])

<div 
    x-data="{ openDropdown: @php
        if ($open) {
            echo 'true';
        } else {
            echo 'false';
        }
    @endphp }"
     @if ($useBack) 
        x-bind:class="openDropdown === true ? 'dark:bg-[#FAFAFA] dark:bg-opacity-10 bg-gray-100 rounded-xl' : 'bg-transparent'" 
     @endif 
 class="flex flex-col h-auto gap-[5px]">
    <button @click="openDropdown = ! openDropdown" class="flex justify-between items-center h-auto p-[5px] px-[15px] hover:bg-gray-100 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10  rounded-xl">
        <x-a-label class="font-bold">{{ __($name) }}</x-a-label>
        <div :class="{'rotate-90': ! openDropdown }" class="-rotate-90">
            <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
        </div>
    </button>
    <div 
        @if ($useBack) 
            x-bind:class="openDropdown === true ? 'pb-[5px]' : ''" 
        @endif 
        class="overflow-hidden h-auto">
        <div class="flex h-auto gap-[5px] flex-col"
        x-show="openDropdown"
        x-transition:enter="transition-transform ease-out duration-300"
        x-transition:enter-start="translate-y-[-100%]"
        x-transition:enter-end="translate-y-0"
        x-transition:leave="transition-transform ease-in duration-200"
        x-transition:leave-start="translate-y-0"
        x-transition:leave-end="translate-y-[-100%]">
            {{ $slot }}
        </div>
    </div>
</div>