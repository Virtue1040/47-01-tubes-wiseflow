@props(['text', 'id', 'name', 'hide_filename' => false, 'hide_preview' => false])

<div class="flex flex-col justify-center items-center gap-[20px]">
    <x-text-input id="{{ $id }}" class="hidden"  type="file" name="{{ $name }}" accept="image/png, image/jpeg" onchange="handle_upload(this)"/>
    <img class="{{ $hide_preview ? '!hidden' : '' }}  hidden w-[250px]" name="preview"></img>
    <x-icon.upload class="{{ $hide_preview ? '!block' : '' }}" p="70" l="70" name="icon"/>
    <x-a-label>{!! nl2br(e($text)) !!}</x-a-label>
    <x-primary-label for="{{ $id }}" class="cursor-pointer">Upload Image</x-primary-label>
    <x-a-label class="{{ $hide_filename ? 'hidden' : '' }}" name="fileName">No File Selected</x-a-label>
</div>