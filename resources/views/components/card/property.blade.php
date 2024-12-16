@props(['id' => 0, 'imgUrl' => '', 'kost_nama' => 'Default Kost', 'kost_desc' => 'Default Desc', 'location' => '', 'rent' => 0, 'facility' => 0])

    <div {{ $attributes->merge(['class' => 'overflow-hidden relative bg-white rounded-2xl shadow dark:bg-[#18181B] group h-auto border-gray-200 dark:border-[#464649] border-[1px]']) }}>
        <img src="{{ asset($imgUrl) }}" alt="Cover Property" class="object-cover w-full h-[200px]">
        <div class="flex flex-col p-4 gap-[10px]">
            <div class="">
                <x-a-label>{{ $kost_nama }}</x-a-label>
            </div>
            <div class="flex gap-[10px]">
                <div class="dark:bg-[#464649] rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                    <x-icon.location p="20" l="20"/>
                </div>
                <x-a-label class="truncate">{{ $location }}</x-a-label>
            </div>
        </div>
        <hr class="dark:border-[#464649] border-gray-200 w-full">
        <div class="flex flex-nowrap justify-between p-4">
            <div class="flex gap-[10px] w-[100%] items-center">
                <div class="dark:bg-[#464649] rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                    <x-icon.rent p="20" l="20"/>
                </div>
                <x-a-label class="text-sm">Rent: {{ $rent }}</x-a-label>
            </div>
            <div class="flex gap-[10px] w-[100%] items-center justify-end">
                <div class="dark:bg-[#464649] rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                    <x-icon.facility p="20" l="20"/>
                </div>
                <x-a-label class="text-sm">Facility: {{ $facility }}</x-a-label>
            </div>
        </div>
        <div class="flex p-4">
            <x-primary-button onclick="window.location.href='{{ route('property.detail', $id) }}'" class="w-full !text-nowrap !rounded-l-full !rounded-r-none flex justify-center">
                View Details
            </x-primary-button>
            <x-primary-button onclick="window.location.href='{{ route('property.edit', $id) }}'" class="w-full !text-nowrap !rounded-r-full !rounded-l-none flex justify-center">
                Edit
            </x-primary-button>
        </div>
        <!-- Text Overlay -->
        {{--<div class="absolute right-0 bottom-0 group-hover:h-[200px] transition-[height] duration-300 ease-in-out h-16 left-0 rounded-lg bg-black bg-opacity-50 backdrop-blur-[3px]">
         <div class="relative p-4 w-full h-full">
                <h3 class="text-lg font-semibold text-white" >{{ $kost_nama }}</h3>
                <p class="text-sm text-gray-300 opacity-0">{{ $kost_desc }}</p>
                <div>
                    
                </div>
                {{-- <div class="flex gap-[10px]">
                    <a href="{{ route('property.detail', $id) }}">
                        <x-primary-button class="w-[50px] h-[50px] !p-[10px] flex items-center transition-[width] duration-300 ease-in-out hover:after:content-['Detail'] hover:w-[109px]  gap-[10px]"><x-icon.homeApp p="28" l="28"/></x-primary-button>
                    </a>
                    <a href="{{ route('property.detail.calendar', $id) }}">
                        <x-primary-button class="w-[50px] h-[50px] !p-[10px] flex items-center transition-[width] duration-300 ease-in-out hover:after:content-['Calendar'] hover:w-[140px] gap-[10px]"><x-icon.calendar p="28" l="28"/></x-primary-button>
                    </a>
                    <a href="{{ route('property.detail.rent.overview', ['id' => $id]) }}">
                        <x-primary-button class="w-[50px] h-[50px] !p-[10px] flex items-center transition-[width] duration-300 ease-in-out hover:after:content-['Rent'] hover:w-[100px] gap-[10px]"><x-icon.rent p="28" l="28"/></x-primary-button>
                    </a>
                </div>
            </div> 
        </div>--}}
    </div>
