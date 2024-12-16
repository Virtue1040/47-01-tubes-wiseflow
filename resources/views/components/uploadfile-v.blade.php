@props(['text', 'id', 'name', 'hide_filename' => false, 'hide_preview' => false])

<div class="flex flex-col-reverse h-full w-full ">
    <div class="flex gap-[5px] bg-[#18181B] flex-col py-[10px] w-full rounded-b-2xl items-center">
        {{-- <x-a-label>{!! nl2br(e($text)) !!}</x-a-label> --}}
        <x-primary-label for="{{ $id }}" class="cursor-pointer">Upload Image</x-primary-label>
        <x-text-input id="{{ $id }}" class="hidden"  type="file" name="{{ $name }}" accept="image/png, image/jpeg" onchange="handle_upload(this)"/>
        <x-a-label class="{{ $hide_filename ? 'hidden' : '' }}" name="fileName">No File Selected</x-a-label>
    </div>

    <img class="{{ $hide_preview ? '!hidden' : '' }}  hidden w-[250px]" name="preview"></img>
    <x-icon.upload class="hidden" p="70" l="70" name="icon"/>

</div>