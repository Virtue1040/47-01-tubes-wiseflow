@section('title', '- Find Property')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Find Property') }}
        </h2>
    </x-slot>
    <style>
        .mapboxgl-popup-content {
            background: transparent !important; 
            box-shadow: none !important;       
            border: none !important;         
        }

        .mapboxgl-popup-tip {
            display: none !important;     
        }
    </style>
    <script>
        $('#contentContainer').css('padding', '0px');
        $("#contentContainer").css("display", 'flex');
    </script>
    <script>
        $(document).ready(function() {
            let map
            navigator.geolocation.getCurrentPosition(function(position) {
                console.log(position);
                map = setupMap('map', position.coords.longitude, position.coords.latitude);
                const geocoder = new MapboxGeocoder({
                    accessToken: mapboxgl.accessToken,
                    mapboxgl: mapboxgl
                });
                map.addControl(geocoder);
            });

            let page = 1;
            let maxPage = 10;
            let groupBy = '';
            let orderBy = undefined;
            let popups = null;
            
            function searchProperty(text) {
                $.ajax({
                    url: "{{ route('property.search', 'a    ') }}",
                    method: 'GET',
                    data: {
                        search: text,
                        page: page,
                        maxPage: maxPage,
                        groupBy: groupBy,
                        orderBy: orderBy
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            $('#propertyContainer').empty();
                            $("#itemResult").html(response.data.total + ' Results')
                            response.data.data.forEach(property => {
                                let rating = property.rating
                                let cover = property.cover
                                let property_name = property.property_name
                                let location = property.location
                                let min_price = property.min_price
                                let total_rent = property.total_rent
                                let total_com = property.total_comment
                                let total_fav = property.total_fav
                                let total_visit = property.total_visit
                                let longitude = property.longitude
                                let latitude = property.latitude

                                const marker = new mapboxgl.Marker()
                                .setLngLat([longitude, latitude])
                                .addTo(map);
                                const popup = new mapboxgl.Popup({
                                    offset: 25
                                })
                                .setHTML(
                                    `<x-box-dropdown :disableDropdown=true class="">
                                        <img src="{{ asset('storage/') }}/${property.cover}" onerror="$(this).attr('src', '{{ asset('img/placeholder.png') }}')" alt="Cover Property" class="object-cover w-full h-full rounded-xl">
                                        <br>
                                        <x-a-label class="text-lg font-bold">${property.property_name}</x-a-label><br>
                                        <x-a-label class="text-md">${property.property_category}</x-a-label>
                                        <br><br>
                                        <x-primary-button onclick="window.location.href='/view/property/profile/${property.id_property}'" class="flex justify-center w-full">View Detail</x-primary-button>
                                    </x-box-dropdown>`
                                );
                                marker.setPopup(popup);

                                let theButton = $(`
                                    <x-card.property-find src="{{ asset('storage/') }}/${property.cover}" property_name="${property.property_name}" location="${property.location}" rating="${parseFloat(rating).toFixed(1)}" price="IDR ${property.min_price}"
                                        rent="${total_rent}" com="${total_com}" eye="${total_visit}" fav="${total_fav}"/>
                                `)
                                theButton.click(function() {
                                    map.flyTo({
                                        center: [longitude, latitude],
                                        essential: true
                                    });
                                    if (popups !== null) {
                                        popups.remove();
                                    }
                                    popups = popup.addTo(map);
                                })
                                
                                $("#propertyContainer").append(theButton);
                                $('#propertyContainer').append(`<hr class="dark:border-[#464649] border-gray-200 w-full">`);
                            });
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                })                
            }

            searchProperty('');

            $("#search_property").onPause(function() {
                searchProperty($(this).val());
            })
        })
    </script>
    <div class="flex flex-row w-full h-full">
        {{-- kiri --}}
        <div class="p-10 w-full h-full">
            <x-box-dropdown class="w-[100%] h-full" name="Property Search">
                <div class="flex flex-col h-full">
                    <div>
                        <div>
                            <x-search id="search_property" placeholder="Property Name" />
                        </div><br>
                        <hr class="dark:border-[#464649] border-gray-200 w-full"><br>
                        <div class="flex gap-[10px] w-full">
                            <x-select class="p-[6.5px] w-full" name="filter_price" value="Price">
                                <option value="" selected>Place Filter</option>
                            </x-select>
                            <x-select class="p-[6.5px] w-full" name="filter_price" value="Price">
                                <option value="" selected>Property Type Filter</option>
                            </x-select>
                            <x-select class="p-[6.5px] w-full" name="filter_price" value="Price">
                                <option value="" selected>Price Range Filter</option>
                            </x-select>
                            <x-select class="p-[6.5px] w-full" name="filter_price" value="Price">
                                <option value="" selected>Facility Filter</option>
                            </x-select>
                        </div><br>
                        <hr class="dark:border-[#464649] border-gray-200 w-full"><br>
                        <div class="flex justify-between">
                            <div class="flex flex-col">
                                <x-a-label class="font-bold !text-gray-400">Showing</x-a-label>
                                <x-a-label class="font-bold" id="itemResult">0 Result</x-a-label>
                            </div>
                            <div>
                                <x-select class="p-[6.5px] w-full" name="filter_price" value="Price">
                                    <option value="" selected>Newest</option>
                                </x-select>
                            </div>
                        </div><br>
                    </div>
                    <div class="flex flex-col gap-[20px] w-full h-full overflow-y-auto pr-2
                    [&::-webkit-scrollbar]:w-2
                    [&::-webkit-scrollbar-track]:rounded-full
                    [&::-webkit-scrollbar-thumb]:rounded-full
                    [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]
                        " id="propertyContainer">
                    </div>
                </div>

            </x-box-dropdown>
            
            {{-- <div class="flex flex-row py-8">
            <x-icon.search p="20" l="20" />Bandung,jawabarat
            </div>
            
            <hr class="border-black">
            <br>
            <div class="flex flex-row gap-8">
                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p>show filter </p>
                </div>
                
                <div class="w-[200px] bg-transparant">
              
                </div>
                
                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p>Rp.5jt - 10jt </p>
                </div>

                <div class="rounded p-[5px] px-[25px] bg-white w-[140px] border border-black ">
                    <p> Rent hause </p>
                </div>
            </div>
            
            <br>
            
            <hr class="border-black">
            
            <div class="flex flex-row justify-between py-10" >
                <div>
                    <p>Showing</p>
                    <p class="font-bold">126 Result</p>
                </div>
                
                <div class="rounded p-[5px] px-[25px] bg-white w-[110px] h-8 border border-black ">
                    <p> Sort by </p>
                </div>
                
            </div>

            <div>
                <div>
                    <img src="{{ asset('img/hause-japan.jpg') }}" class="w-[300px]"></img>
                    <div>
                        <p>Rp.1000.000 / night</p>
                    </div>
                </div>
                
                <div>
                    <div></div>
                    <div></div>
                </div>
                
            </div> --}}
            
            
        </div>
        
        {{-- kanan --}}
        <div class="w-full h-full">
            <div id="map" class="w-full h-full bg-white rounded-r-xl">
                
            </div>
        </div>
    </div>
    
</x-app-layout>

