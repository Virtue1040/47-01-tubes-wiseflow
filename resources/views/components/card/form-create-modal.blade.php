<x-card.shadow-bg>
    <div class="hidden w-[40px] h-[40px] border-4  border-gray-400 rounded-full relative justify-center items-center" name="template1">
        <div class="hidden" name="checklist">
            <x-icon.checklist p="25" l="25" class="!fill-white" ></x-icon.checklist>
        </div>
        <x-a-label name="icon" class=""></x-a-label>
        <a  class="absolute top-10 left-1/2 text-sm font-bold  -translate-x-1/2 text-black dark:text-white text-nowrap focus:text-[#5E93DA]"></a>
    </div>
    <div class="hidden w-[100px] h-[4px] bg-gray-400" name="template2">
    </div>
    <div class="w-auto h-auto min-w-[600px] bg-[#fafafa] dark:bg-gray-800 rounded-3xl flex flex-col fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 border-2 dark:border-gray-700 border-gray-200 " name="modal">
        <div class="w-auto px-[35px] pb-[15px] h-[130px] border-b-2 border-[#EFEFEF] dark:border-gray-800 flex justify-center items-center" name="listStep">

        </div>
        <div class="w-auto h-auto  p-[25px] pt-[15px] rounded-b-3xl bg-white dark:bg-gray-900">
            <div class="mt-1 w-auto min-w-[0px] flex flex-col min-h-[45px]" >
                <form id="modal_form" name="container" autocomplete="off" method="POST" action="{{ route('property.store') }}" enctype="multipart/form-data">
                    <input class="hidden" name="form_name">
                    @csrf
                    <br>
                    <div class="flex justify-between gap-[30px]">
                        <x-primary-button class="mt-3 w-auto  min-h-[45px] flex items-center justify-center" name="back" disabled>
                            {{ __('Back') }}
                        </x-primary-button>
                        <x-primary-button type="submit" class="mt-3 w-auto min-h-[45px] flex items-center justify-center" name="continue" disabled>
                            {{ __('Next') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-card.shadow-bg>