<div {{ $attributes->merge(['class' => 'rounded-2xl h-[150px] w-full bg-[#fafafa] dark:bg-[#242427] border-[1px] border-gray-200 dark:border-[#464649] flex flex-col']) }}>
    <div class="w-auto p-[10px] h-[60px] border-b-[1px] border-[#EFEFEF] dark:border-[#464649] flex justify-end relative" name="listStep">
        <div class="absolute left-1/2 rotate-90 -translate-x-1/2 cursor-grab" name="drag">
            <x-icon.drag-indicator p=25 l=25/>
        </div>
        <div class="flex justify-end items-center gap-[10px]">
            <button name="open"><x-icon.open p="20" l="20"/></button>
            <button name="delete"><x-icon.delete p="20" l="20"/></button>
        </div>
    </div>
    <div class="w-auto flex gap-[15px] p-[15px] rounded-b-2xl ">
        <div class=" w-full h-fit min-w-[0px] ">
            <x-input-label for="id_facility">Facility <a class="text-red-700">*</a></x-input-label>
            <x-select id="id_facility" style="" class="p-[6.5px] block mt-2 w-full h-full bg-gray-200" placeholder="Facility"  type="text" name="id_facility"
                :value="old('id_facility')"  autofocus>
                {{ $slot }}
            </x-select>
        </div>
        <x-input-error :messages="$errors->get('id_facility')" class="mt-1" />
        <div class=" w-full h-fit min-w-[0px] ">
            <x-input-label for="quantity">Quantity <a class="text-red-700">*</a></x-input-label>
            <x-text-input id="quantity" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Quantity"  type="number" name="quantity"
                :value="old('quantity')"  autofocus/>
        </div>
        <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
    </div>
</div>