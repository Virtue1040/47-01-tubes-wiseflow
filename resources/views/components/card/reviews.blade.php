@props(['fullName' => "", 'comment' => "", 'rating' => 1, 'imgUrl' => "a", 'rentCover' => 'a', 'rentName' => '', 'rentId' => '', 'propertyId' => ''])

<div class="p-3 w-full h-auto rounded-xl dark:bg-[#242427] bg-gray-100 flex justify-between gap-[10px]">
    <div>
        <div class="flex gap-[10px]">
            <div
                class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden">
                <img id="username_profile"
                    onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                    alt="Profile Image" class="" name="{{ $fullName }}" src={{ $imgUrl }}>
                <a class="text-black"></a>
            </div>
            <div class="flex flex-col justify-center truncate">
                <div class="flex gap-[5px] items-center">
                    <x-a-label class="text-sm">{{ $fullName }}</x-a-label>
                </div>
            </div>
        </div>
        <div class="mt-2 flex gap-[2px] flex-col">
            <div class="flex gap-[2px]">
                @foreach (range(1, 5) as $i)
                    <x-icon.star p="20" l="20" :filled="$i <= $rating"></x-icon.star>
                @endforeach
            </div>
            <x-a-label>{{ $comment }}</x-a-label>
        </div>
    </div>
    <div class="w-[88px] flex">
            <div onclick="window.location.href='{{ route('property.detail.rent.overview', ['id' => $propertyId, 'id_rent' => $rentId]) }}'" class="cursor-pointer flex flex-col justify-center items-center gap-[5px] w-full">
                <x-a-label class="w-full truncate">{{ $rentName }}</x-a-label>
                <img src="{{ $rentCover }}" onerror="this.src='{{ asset('img/placeholder.png') }}'" alt="Cover Rent" class="object-cover w-[88px] h-[88px] rounded-2xl">
            </div>
    </div>
</div>