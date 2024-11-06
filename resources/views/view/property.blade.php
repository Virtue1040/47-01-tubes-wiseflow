<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Property') }}
        </h2>
    </x-slot>

    <div class="flex">
            <div class="flex flex-col gap-6 md:flex-row grow md:grow-0">
                <!-- Kost 1 -->
                <x-card.property url='/view/property/detail/1' kost_nama='Gallant Kost' kost_desc='Kost' imgUrl='img/kost1.jpg'></x-card.property>

                <!-- Kost 2 -->
                <x-card.property url='' kost_nama='Cozy Home' kost_desc='Kontrakan' imgUrl='img/kost2.jpg'></x-card.property>
            </div>
    </div>
    

    <button class="w-[50px] h-[50px] fixed right-10 bottom-10 text-3xl font-bold text-white bg-blue-500 rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <div class="relative w-full h-full">
            <span class="flex absolute top-1/2 left-1/2 items-center -translate-x-1/2 -translate-y-1/2">+</span>
        </div>
    </button>       
</x-app-layout>
