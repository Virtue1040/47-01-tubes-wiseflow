@props(['url' => '', 'imgUrl' => '', 'kost_nama' => 'Default Kost', 'kost_desc' => 'Default Desc'])

<a class="w-full" href="{{ url($url) }}">
    <div class="overflow-hidden relative w-full bg-white rounded-lg shadow dark:bg-gray-800">
        <img src="{{ asset($imgUrl) }}" alt="Gallant Kost" class="object-cover w-full h-48">
        <!-- Text Overlay -->
        <div class="absolute right-0 bottom-0 left-0 p-4 bg-black bg-opacity-50 backdrop-blur-[3px]">
            <h3 class="text-lg font-semibold text-white" >{{ $kost_nama }}</h3>
            <p class="text-sm text-gray-300">{{ $kost_desc }}</p>
        </div>
    </div>
</a>