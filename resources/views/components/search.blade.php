@props(['disabled' => false, 'placeholder' => 'x', 'extended' => null])
<div class="w-full flex relative border-gray-200 dark:border-[#464649] border-[1px] h-[36px] bg-[#FAFAFA] dark:bg-white dark:bg-opacity-10 dark:text-gray-300 rounded-lg">
    <div class="flex justify-center items-center absolute top-1/2 -translate-y-1/2 left-[10px]">
        @if ($extended !== null)
            {{ $extended }}
        @else
            <x-icon.search p="20" l="20" />
        @endif
    </div>
    <input autocomplete="off" type="text" placeholder="{{ $placeholder }}" @disabled($disabled) class="bg-transparent pl-[35px] w-full focus:outline-[#5E93DA] focus:outline focus:outline-2 rounded-lg" {{ $attributes }}>
</div>




