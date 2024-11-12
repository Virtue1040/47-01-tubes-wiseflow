@props(["name"])

<div class="flex flex-col h-auto gap-[10px]">
    <div class="flex justify-between items-center h-auto p-[5px] px-[15px] hover:bg-[#FAFAFA] hover:bg-opacity-10  rounded-xl cursor-pointer">
        <x-a-label class="font-bold">{{ __($name) }}</x-a-label>
        <div class="rotate-90">
            <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
        </div>
    </div>
    <div class="flex h-auto gap-[10px] flex-col">
        {{ $slot }}
    </div>
</div>