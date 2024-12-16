@props(['message' => '', 'last_updated' => '', 'img' => null, 'name' => null])
<div name="opponent" class="flex gap-[10px]">
    @if ($img !== null)
        <div class="flex justify-center items-center rounded-full flex-shrink-0 flex-grow-0 w-[35px] h-[35px] bg-white overflow-hidden">
            <img id="username_image"
                onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                alt="Profile Image" src="{{ $img }}" class="" name="{{ $name }}">
            <a class="text-black"></a>
        </div>
    @endif
    <div class="p-3 max-w-2xl bg-white rounded-lg dark:bg-[#18181B] flex flex-col gap-[5px] min-w-24">
        @if ($name !== null)
            <div>
                <p class="text-xs text-gray-300">{{ $name }}</p>
            </div>
        @endif
        <p class="text-gray-900 break-words dark:text-gray-100 mr-[+50px]" name="message">{{ $message }}</p>
        <div class="flex items-end justify-end w-full mb-[-7px] ">
            <p class="text-xs text-gray-300">{{ $last_updated }}</p>
        </div>
    </div>
</div>