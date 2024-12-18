@props(['src' => '', 'property_name' => '', 'location' => '', 'rating' => '0', 'price' => '0',
    'eye' => '0',
    'fav' => '0',
    'com' => '0',
    'rent' => '0'
    ])
<div class="flex gap-[25px] min-h-[180px] max-h-[180px] cursor-pointer overflow-hidden">
    <img src="{{ $src }}" onerror="$(this).attr('src', '{{ asset('img/placeholder.png') }}')" alt="Cover Property" class="object-cover min-w-[200px] max-w-[200px] max-h-full rounded-xl">
    <div class="flex flex-col w-full pt-[20px]">
        <div class="flex flex-col justify-between h-full">
            <div>
                <div class="flex justify-between w-full">
                    <div class="flex gap-[2px] items-center">
                        <x-a-label class="text-2xl font-bold">{{ $price }}</x-a-label><x-a-label class="text-sm font-bold text-gray-400 h-fit">/night</x-a-label>
                    </div>
                    <div class="p-1 px-2 w-auto h-full bg-yellow-200 rounded-xl flex gap-[5px] items-center">
                        <x-icon.star p="20" l="100%" filled/>
                        <x-a-label class="font-bold !text-yellow-600">{{ $rating }}</x-a-label>
                    </div>
                </div>
                <div class="mt-4">
                    <x-a-label class="font-bold">{{ $property_name }}</x-a-label>
                </div>
                <div class="overflow-hidden">
                    <x-a-label class="text-sm text-gray-400">{{ $location }}</x-a-label>
                </div>
            </div>
            <div class="flex gap-[10px]">
                <div class="flex gap-[10px] items-center">
                    <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                        <x-icon.eye p="20" l="20"/>
                    </div>
                    <x-a-label class="text-sm">{{ $eye }}</x-a-label>
                </div>
                <div class="flex gap-[10px] items-center">
                    <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                        <x-icon.love p="20" l="20"/>
                    </div>
                    <x-a-label class="text-sm">{{ $fav }}</x-a-label>
                </div>
                <div class="flex gap-[10px] items-center">
                    <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                        <x-icon.chat p="20" l="20"/>
                    </div>
                    <x-a-label class="text-sm">{{ $com }}</x-a-label>
                </div>
                <div class="flex gap-[10px] items-center">
                    <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                        <x-icon.rent p="20" l="20"/>
                    </div>
                    <x-a-label class="text-sm">{{ $rent }}</x-a-label>
                </div>
            </div>
        </div>
    </div>
</div>