<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Choose Roles') }}
        </h2>
    </x-slot>

    <div class="flex justify-center items-center min-h-[calc(100vh-180px)]">
        <div class="max-w-7xl">
            <div class="m-auto flex flex-row w-full md:w-[800px] md:h-auto h-full  min-h-[600px] py-[10px] px-[10px] bg-white dark:bg-[#18181B] bg-opacity-[.30] rounded-2xl shadow-2xl">
                <div class="flex w-full justify-center h-[100%] backdrop-blur-sm bg-opacity-2 rounded-2xl"
                    id="loginContainer">
                    <form action="{{ route('choose.role') }}" method="POST" class="flex flex-col justify-center items-center w-[80%] pt-[50px] pb-[35px]">
                        @csrf
                        <x-input-label class="text-3xl font-bold">Choose your Role!</x-input-label>
                        <x-a-label class="text-center text-md" id="signup_desc">Please Select Your Role Between Property's Owner And Residence</x-a-label><br>
                        <div class="overflow-hidden w-full px-[5px]">
                            <div class=" relative w-auto py-[50px]" id="slideRole">
                                <br>
                                <div class="flex gap-[35px] justify-center w-full ">
                                    <x-card.choose-item class="w-[170px] h-[170px]" id="Owner" name="role"
                                        value="2" :checked=true>
                                        <x-icon.owner p="65" l="65"></x-icon.owner>
                                        <x-a-label for="owner" class="text-lg font-bold">Owner</x-a-label>
                                    </x-card.choose-item>
                                    <x-card.choose-item class="w-[170px] h-[170px]" id="Resident" name="role"
                                        value="3" :checked=false>
                                        <x-icon.residents p="65" l="65"></x-icon.residents>
                                        <x-a-label for="residents" class="text-lg font-bold">Residents</x-a-label>
                                    </x-card.choose-item>
                                </div>
                                <br>
                            </div>
                        </div>
                        <x-primary-button onclick="control();" type="submit"
                                class=" w-full min-h-[40px] flex items-center justify-center">
                                {{ __('Choose Role') }}
                            </x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
