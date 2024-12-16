@props(['message' => '', 'last_updated' => '', 'id' => ''])
<div id="{{ $id }}" name="local" class="flex justify-end">
    <div class="p-3 max-w-2xl text-white bg-blue-500 rounded-lg dark:bg-[#5E93DA] flex flex-col">
        <p class="mr-[50px] w-full break-words">{{ $message }}</p>
        <div class="flex justify-end w-full mb-[-7px] gap-[5px] items-end">
            <p class="text-xs text-gray-300">{{ $last_updated }}</p>
            <div name="signal" class="hidden fill-black">
                <x-icon.signal p="20" l="20"/>
            </div>
        </div>
    </div>
</div>