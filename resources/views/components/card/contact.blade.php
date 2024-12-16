@props(['name' => '', 'last_update' => '10:40', 'message' => 'Message', 'id' => ''])
<div id={{ $id }} class="active:dark:bg-[#FAFAFA] active:dark:bg-opacity-10 active:bg-gray-100 active:bg-opacity-50 flex items-center p-3 w-full gap-[10px] rounded-xl cursor-pointer hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10">
    <div class="flex justify-center items-center rounded-full max-w-[35px] max-h-[35px] bg-white overflow-hidden">
        <img onerror="let getFirst = '{{ $name }}'; $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')" class="w-[30px] h-[30px]">
        <a class="text-black"></a>
    </div>
    <div class="flex flex-col w-full">
        <div class="flex justify-between w-full">
            <x-a-label name="username">{{ $name }}</x-a-label>
            <x-a-label name="last_update" class="text-sm">{{ $last_update }}</x-a-label>
        </div>
        <x-a-label name="message" class="w-full text-sm text-gray-400 truncate dark:text-gray-400">{{ $message }}</x-a-label>
    </div>
</div>