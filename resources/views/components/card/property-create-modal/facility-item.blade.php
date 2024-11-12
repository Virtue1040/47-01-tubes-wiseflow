<div class="rounded-2xl h-[150px] mt-2 w-full bg-[#fafafa] dark:bg-gray-800 border-[1px] border-gray-200 dark:border-gray-700 flex flex-col">
    <div class="w-auto p-[10px] h-[60px] border-b-2 border-[#EFEFEF] dark:border-gray-700 flex justify-center items-center " name="listStep">
        <div class="rotate-90 cursor-pointer">
            <x-icon.drag-indicator></x-icon.drag-indicator>
        </div>
    </div>
    <div class="w-auto flex gap-[15px] p-[15px] rounded-b-2xl ">
        <div class=" w-full h-fit min-w-[0px] ">
            <x-input-label for="facility_id">Facility <a class="text-red-700">*</a></x-input-label>
            <x-select id="facility_id" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Facility"  type="text" name="facility_id"
                :value="old('facility_id')"  autofocus/>
        </div>
        <x-input-error :messages="$errors->get('province')" class="mt-1" />
        <div class=" w-full h-fit min-w-[0px] ">
            <x-input-label for="quantity">Quantity <a class="text-red-700">*</a></x-input-label>
            <x-text-input id="quantity" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Quantity"  type="number" name="quantity"
                :value="old('quantity')"  autofocus/>
        </div>
        <x-input-error :messages="$errors->get('quantity')" class="mt-1" />
    </div>
</div>