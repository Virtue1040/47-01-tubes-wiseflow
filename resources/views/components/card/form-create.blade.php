
<div class="hidden w-[100px] h-[4px] bg-gray-400" name="template2">
</div>
<form id="forms" class="" autocomplete="off" method="POST" action="{{ route('property.store') }}" enctype="multipart/form-data') }}">
    @csrf
    <div class="w-auto h-auto max-w-[1000px] m-auto  flex flex-col gap-[10px]" name="modal">
        <div class="w-auto h-[80px] p-[15px] flex  rounded-xl bg-white dark:bg-gray-800 border-[1px] border-gray-700" name="listStep">
            <div class="w-full p-[10px] flex items-center gap-[15px]" name="template1">
               <div class="border-2 border-[#5E93DA] rounded-full h-[40px] w-[40px] flex justify-center items-center">
                    <x-a-label>1</x-a-label>
               </div>
               <x-a-label>Detail</x-a-label>
            </div>
            <div class="w-full p-[10px] flex items-center gap-[15px]" name="template1">
                <div class="border-2 border-[#5E93DA] rounded-full h-[40px] w-[40px] flex justify-center items-center">
                     <x-a-label>1</x-a-label>
                </div>
                <x-a-label>Detail</x-a-label>
             </div>
             <div class="w-full p-[10px] flex items-center gap-[15px]" name="template1">
                <div class="border-2 border-[#5E93DA] rounded-full h-[40px] w-[40px] flex justify-center items-center">
                     <x-a-label>1</x-a-label>
                </div>
                <x-a-label>Detail</x-a-label>
             </div>
        </div>
        <div class="w-auto h-auto  p-[25px] pt-[15px] rounded-xl bg-white dark:dark:bg-gray-900 border-[1px] border-gray-700">
            <div class="mt-1 w-auto min-w-[0px] flex flex-col min-h-[45px]" name="container">
                <div class="flex flex-col gap-[10px]">
                    <div class=" w-full min-w-[0px]">
                        <x-input-label for="kontrakan_name">Nama Kontrakan</x-input-label>
                        <x-text-input id="kontrakan_name" class="block mt-3 w-full h-full bg-gray-200" placeholder="Nama Kontrakan"  type="text" name="kontrakan_name"
                            :value="old('kontrakan_name')"  autofocus/>
                    </div>
                    <div class="w-full min-w-[0px] flex">
                        <x-select id="kontrakan_category" style="" class="block w-full h-full bg-gray-200" placeholder="Category Kontrakan" name="kontrakan_category"
                            :value="old('kontrakan_category')"  autofocus>
                            <option value="Kontrakan">Kontrakan</option>
                            <option value="Kost">Kost</option>
                        </x-select>
                    </div>
                    <x-input-error :messages="$errors->get('kontrakan_name')" class="mt-1" />
                    <div class="w-full min-w-[0px] flex">
                        <x-text-area id="kontrakan_desc" style="" class="block w-full h-[150px] bg-gray-200" placeholder="Deskripsi Kontrakan"  type="text" name="kontrakan_name"
                          autofocus>{{ old('kontrakan_desc') }}</x-text-area>
                    </div>
                    <x-input-error :messages="$errors->get('kontrakan_desc')" class="mt-1" />
                </div>
            </div>
        </div>
        <div class="flex justify-between gap-[30px]">
            <x-primary-button class="mt-3 w-auto !bg-transparent !text-white min-h-[45px] flex items-center justify-center">
                {{ __('Back') }}
            </x-primary-button>
            <x-primary-button class="mt-3 w-auto min-h-[45px] flex items-center justify-center">
                {{ __('Next') }}
            </x-primary-button>
        </div>
    </div>
</form>