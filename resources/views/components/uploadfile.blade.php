@props(['text', 'id', 'name'])

<x-text-input id="{{ $id }}" class="hidden"  type="file" name="{{ $name }}" accept="image/png, image/jpeg" onchange="handle_upload(this)"/>
<img class="hidden w-[250px]" name="preview"></img>
<x-icon.upload p="70" l="70" name="icon"/>
<x-a-label>{!! nl2br(e($text)) !!}</x-a-label>
<x-primary-label for="{{ $id }}" class="cursor-pointer">Upload Image</x-primary-label>
<x-a-label name="fileName">No File Selected</x-a-label>