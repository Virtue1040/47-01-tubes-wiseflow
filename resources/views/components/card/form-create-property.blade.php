@props(['id'])
<x-card.shadow-bg>
    <div id="{{ $id }}" class="w-auto h-auto min-w-[600px] bg-white rounded-3xl flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
        <div class="w-auto px-[35px] pb-[15px] h-[130px] border-b-2 border-gray-300 flex justify-center items-center" name="listStep">

        </div>
        <div class="w-auto h-auto border-b-2 border-black p-[25px] rounded-b-2xl bg-gray-200">
            <div class="mt-6 w-auto min-w-[0px] flex flex-col min-h-[45px]">
                <br><br><br><br><br><br><br><br><br>
                <x-primary-button class=" w-full min-h-[45px] flex items-center justify-center">
                    {{ __('Continue') }}
                </x-primary-button>
            </div>
        </div>
    </div>
</x-card.shadow-bg>