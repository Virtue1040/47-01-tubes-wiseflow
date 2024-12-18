@section('property_id', $property->id_property)
@section('title', '- Property Edit')

<x-app-layout>
    <script>
        $('#contentContainer').css('padding', '0px');
        $("#contentContainer").css("display", 'flex')

        $(document).ready(function() {
            // navigator.geolocation.getCurrentPosition(function(position) {
            //     setupMap('map', position.coords.latitude, position.coords.longitude);
            // });
            let lon = {{ $property->property_address->longitude }};
            let lat = {{ $property->property_address->latitude }};
            let property_name = $("[name='property_name']")
            let property_category = $("[name='property_category']")
            let property_desc = $("[name='property_desc']")
            let street_name = $("[name='street_name']")
            let state = $("[name='state']")
            let zipcode = $("[name='zipcode']")
            let province = $("[name='province']")
            let country = $("[name='country']")
            let id_cover = $("[name='id_cover']")
            let contact_name = $("[name='contact_name']")
            let contact_phone = $("[name='contact_phone']")
            let apiMap = $('#apiMap');

            let map = setupMap('map', lon, lat);
            const marker = new mapboxgl.Marker()
                .setLngLat([lon, lat])
                .addTo(map);
            const popup = new mapboxgl.Popup({
                    offset: 25
                })
                .setHTML(
                    '<a class="text-black"><strong>Location:</strong> {{ $property->property_address->getDisplayName() }}</a>'
                );
            const geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            });
            map.addControl(geocoder);
            marker.setPopup(popup);
            popup.addTo(map);
            map.addControl(new mapboxgl.FullscreenControl({container: document.querySelector('body')}));
            map.addControl(new mapboxgl.GeolocateControl({
                positionOptions: {
                    enableHighAccuracy: true
                },
                trackUserLocation: true,
                showUserHeading: true
            }));
            $("[name='get_location']").click(function() {
                navigator.geolocation.getCurrentPosition(function(position) {
                    lon = position.coords.longitude;
                    lat = position.coords.latitude;
                    marker.setLngLat([lon, lat]);
                    map.flyTo({
                        center: [lon, lat],
                        zoom: 15
                    });
                    reverseGeocode(lon, lat, function(data) {
                        popup.setHTML(
                            '<a class="text-black"><strong>Location:</strong> ' + data.properties
                            .place_formatted + '</a>'
                        );
                        popup.addTo(map);
                        let countryval = data.properties.context.country.name;
                        let county = data.properties.context.place.name;
                        let region = data.properties.context.region.name;
                        let postcode = data.properties.context.postcode.name;
                        let locality = data.properties.context.locality.name;
                        let neighborhood = data.properties.context.neighborhood.name;
                        let place = data.properties.context.place.name;
                        country.val(countryval);
                        province.val(region);
                        zipcode.val(postcode);
                        state.val(county);
                        street_name.val(locality + ', ' + neighborhood +
                            ', ' + place).trigger('change');;
                    });
                })
            })
            map.on('click', function(e) {
                const lngLat = e.lngLat;
                const longitude = lngLat.lng;
                const latitude = lngLat.lat;
                lon = longitude;
                lat = latitude;
                marker.setLngLat([longitude, latitude]);
                reverseGeocode(longitude, latitude, function(data) {
                    popup.setHTML(
                        '<a class="text-black"><strong>Location:</strong> ' + data.properties
                        .place_formatted + '</a>'
                    );
                    popup.addTo(map);
                    console.log(data);
                    // apiMap.val(data.properties.place_formatted);
                    let countryval = data.properties.context.country.name;
                    let county = data.properties.context.place.name;
                    let region = data.properties.context.region.name;
                    let postcode = data.properties.context.postcode.name;
                    let locality = data.properties.context.locality.name;
                    let neighborhood = data.properties.context.neighborhood.name;
                    let place = data.properties.context.place.name;
                    country.val(countryval);
                    province.val(region);
                    zipcode.val(postcode);
                    state.val(county);
                    street_name.val(locality + ', ' + neighborhood +
                        ', ' + place).trigger('change');;
                });

            });

            function propertyDeleteModal(id) {
                @if ($property !== null)
                    if (createBounced) {
                        return;
                    }
                    createBounced = true;
                    let returns = init_create_modal("property/" + id, [{
                        title: ''
                    }], [
                        `
                                    <div>
                                        @method('DELETE')
                                        <input name="form_name" value='a' type="hidden">
                                        <div class="flex flex-col gap-[15px] ">
                                            <div class="mt-3 w-full h-full min-w-[0px]">
                                                <x-input-label for="verification">Verification <a class="text-red-700">*</a></x-input-label>
                                                <x-text-input id="verification" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Retype Property Name to Confirm Delete"  type="text" name="verification"
                                                    :value="old('verification')"  autofocus/>
                                            </div>
                                            <x-input-error :messages="$errors->get('verification')" class="mt-1" />
                                        </div>
                                    </div>
                                `,
                    ], {
                        1: ['verification'],
                    }, {
                        hideStep: true,
                        lastButton: "Delete Property",
                        onCreate: function(form) {

                            createBounced = false;
                        },
                    })
                @endif
            }

            $("#deleteProperty").click(function() {
                propertyDeleteModal({{ $property->id_property }})
            })
            $("#updateProperty").click(function() {

                let longitude = lon;
                let latitude = lat;
                $.ajax({
                    url: "{{ route('property.update', $property->id_property) }}",
                    type: 'PUT',
                    headers: {
                        'Accept': 'application/json'
                    },
                    data: {
                        property_name: property_name.val(),
                        property_category: property_category.val(),
                        property_desc: property_desc.val(),
                        street_name: street_name.val(),
                        state: state.val(),
                        zipcode: zipcode.val(),
                        province: province.val(),
                        country: country.val(),
                        id_cover: id_cover.val(),
                        longitude: longitude,
                        latitude: latitude,
                        contact_name: contact_name.val(),
                        contact_phone: contact_phone.val(),
                    },
                    success: function(response) {
                        if (response.success) {
                            Toast.fire({
                                icon: 'success',
                                title: 'Property Updated',
                            });

                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Property Failed to Update',
                            });
                        }
                    },
                    error: function(xhr) {
                        Toast.fire({
                            icon: 'error',
                            title: 'Property Failed to Update',
                        });
                    }
                });
            })
            let albumDummy = $("#propertyAlbumDummy");
            let Album = @json($property->getAlbum);
            Album.forEach(data => {
                let clone = albumDummy.clone();
                clone.css('display', 'block');
                clone.find('div[name="albumImage"]').css('background-image', 'url("' +
                    "{{ asset('storage') }}" + '/' + data.imagePath + '")');
                $("#propertyAlbumContainer").append(clone);

                clone.find('button[name="setPropertyCover"]').click(function(
                    event) {
                    $("#propertyCover").attr('src',
                        "{{ asset('storage') }}" + '/' +
                        data.imagePath);
                    id_cover.val(data.id_album);
                });
                clone.find('button[name="deleteAlbum"]').click(function(event) {
                    askConfirmation('album/' + data.id_album,
                        'DELETE', [],
                        'Are you sure you want to delete this album?',
                        function(form, div) {
                            $(form).submit(function(event) {
                                event.preventDefault();
                                $.ajax({
                                    url: $(form).attr('action'),
                                    type: 'DELETE',
                                    headers: {
                                        'Accept': 'application/json'
                                    },
                                    success: function(response) {
                                        div.remove();
                                        if (response.success) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Album Deleted',
                                            });
                                            clone.remove();
                                        } else {
                                            Toast.fire({
                                                icon: 'error',
                                                title: 'Album Failed to Delete',
                                            });
                                        }
                                    }
                                })
                            })
                        });
                });
            });

            $("#albumImage").on('change', function() {
                $.ajax({
                    url: "{{ route('album.store') }}",
                    type: "POST",
                    dataType: 'json',
                    data: new FormData($('#formPropertyAlbum')[0]),
                    headers: {
                        'Accept': 'application/json'
                    },
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            let clone = albumDummy.clone();
                            clone.css('display', 'block');
                            clone.find('div[name="albumImage"]').css('background-image',
                                'url("' +
                                "{{ asset('storage') }}" + '/' + response.data.imagePath +
                                '")');
                            $("#propertyAlbumContainer").append(clone);
                            clone.find('button[name="setPropertyCover"]').click(function(
                                event) {
                                $("#propertyCover").attr('src',
                                    "{{ asset('storage') }}" + '/' +
                                    response.data.imagePath);
                                id_cover.val(response.data.id_album);
                            });
                            clone.find('button[name="deleteAlbum"]').click(function(event) {
                                askConfirmation('album/' + response.data.id_album,
                                    'DELETE', [],
                                    'Are you sure you want to delete this album?',
                                    function(form, div) {
                                        $(form).submit(function(event) {
                                            event.preventDefault();
                                            $.ajax({
                                                url: $(form).attr(
                                                    'action'),
                                                type: 'DELETE',
                                                headers: {
                                                    'Accept': 'application/json'
                                                },
                                                success: function(
                                                    response) {
                                                    div
                                                .remove();
                                                    if (response
                                                        .success
                                                    ) {
                                                        Toast
                                                            .fire({
                                                                icon: 'success',
                                                                title: 'Album Deleted',
                                                            });
                                                        clone
                                                            .remove();
                                                    } else {
                                                        Toast
                                                            .fire({
                                                                icon: 'error',
                                                                title: 'Album Failed to Delete',
                                                            });
                                                    }
                                                }
                                            })
                                        })
                                    });
                            });

                            Toast.fire({
                                icon: 'success',
                                title: 'Album Uploaded',
                            });
                        }
                    }
                })
            });
        })
    </script>
    <style>
        .ui-state-highlight {
            height: 150px;
            background: #e0e0e0;
            border: 1px dashed #999;
            border-radius: 16px
        }
    </style>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Property Edit') }}
        </h2>
    </x-slot>
    <div class="flex justify-center w-full">
        <div class="p-[45px] py-[25px] w-full relative max-w-[80%]" id="overview">
            <div
                class="flex overflow-hidden justify-center items-center absolute right-10 top-[25px] gap-[10px] w-auto h-auto">
                <button id="updateProperty" onclick=""
                    class="w-auto h-auto px-[5px] text-sm font-bold text-white bg-[#5E93DA] rounded-xl shadow-lg hover:bg-[#5E93DA] hover:bg-opacity-50">
                    <div class="flex justify-center items-center w-auto h-auto p-[10px]">
                        <span class="">Save</span>
                    </div>
                </button>
                <button id="deleteProperty" onclick=""
                    class="w-auto h-auto px-[5px] text-sm font-bold text-white bg-red-500 rounded-xl shadow-lg hover:bg-red-600">
                    <div class="flex justify-center items-center w-auto h-auto p-[10px]">
                        <span class="">Delete</span>
                    </div>
                </button>
            </div>
            <div class="mt-16 flex gap-[35px] pb-[25px]">
                <div class="flex gap-[30px] flex-col w-full">
                    <x-box-dropdown name="Property Information" :open=true>
                        <x-slot:extended>
                            <a class="bg-[#5E93DA] ml-2 py-[1px] text-sm px-[10px] text-white w-auto rounded-lg">ID:
                                {{ $property->id_property }}
                            </a>
                        </x-slot:extended>
                        <div class="flex justify-between gap-[15px] ">
                            <div class="w-full h-full min-w-[0px]">
                                <x-input-label for="property_name">Property Name <a
                                        class="text-red-700">*</a></x-input-label>
                                <x-text-input id="property_name" values="{{ $property->property_name }}"
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Property"
                                    type="text" name="property_name" :value="old('property_name')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('property_name')" class="mt-1" />
                            <div class="w-full h-full min-w-[0px]">
                                <x-input-label for="stock">Property Category <a
                                        class="text-red-700">*</a></x-input-label>
                                <x-select id="property_category" value="{{ ucfirst($property->property_category) }}"
                                    class=" p-[6.5px] block mt-2 w-full h-full bg-gray-200"
                                    placeholder="Category Property" name="property_category" :value="old('property_category')"
                                    autofocus>
                                    @foreach (config('enums.property_category') as $key => $value)
                                        <option value="{{ ucfirst($value) }}"
                                            {{ $property->property_category === ucfirst($value) ? 'selected' : '' }}>
                                            {{ ucfirst($value) }}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <x-input-error :messages="$errors->get('property_category')" class="mt-1" />
                        </div>
                        <script>
                            addFunctionToTheme('overview', function() {
                                loadTinyMCE('textarea#property_desc', function(editor) {
                                    editor.on('Change', function() {
                                        $("#overview").find("textarea#property_desc").val(editor.getContent()).trigger(
                                            "change");
                                    });
                                });
                            });
                        </script>
                        <div class="mt-3 w-full min-w-[0px] ">
                            <x-input-label for="property_desc">Property Description <a
                                    class="text-red-700">*</a></x-input-label>
                            <x-text-area id="property_desc" style=""
                                class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Property"
                                type="text" name="property_desc"
                                autofocus>{{ $property->property_desc }}</x-text-area>
                        </div>
                        <x-input-error :messages="$errors->get('property_desc')" class="mt-1" />
                    </x-box-dropdown>
                    <x-box-dropdown name="Property Albums" :open=false>
                        <x-slot:extended>
                            <x-a-label class='text-xs'> (hover the album to show action)</x-a-label>
                        </x-slot:extended>
                        <div class="w-full">
                            <form id="formPropertyAlbum">
                                <input name="id_property" value="{{ $property->id_property }}" type="hidden">
                                <div class="flex justify-center items-center w-full h-auto min-h-[50px] py-[25px] flex-col gap-4 border-4 rounded-2xl border-dashed"
                                    id="property_upload_area">
                                    <x-uploadfile id="albumImage" name="album" :hide_filename=true :hide_preview=true
                                        text="Upload or Drag Here (.jpg/.jpeg)" />
                                </div>
                                <x-input-error :messages="$errors->get('album')" class="mt-1" />
                            </form>
                        </div>
                        <div class="flex gap-[10px] flex-wrap mt-4 max-h-[200px] overflow-y-auto"
                            id="propertyAlbumContainer">
                            <div id="propertyAlbumDummy" class="hidden">
                                <div class="relative bg-cover rounded-lg w-[100px] h-[100px]" name="albumImage">
                                    <div
                                        class="w-full h-full p-[10px] rounded-lg bg-black bg-opacity-30 opacity-0 hover:opacity-100 flex justify-end">
                                        <button
                                            class="bg-gray-200 m-auto p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                            name="setPropertyCover"><x-icon.set p="20" l="20" /></button>
                                        <button
                                            class="bg-gray-200 m-auto p-[5px] dark:bg-[#242427] border-[1px] dark:border-[#464649] flex justify-center items-center rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-[#2F2F32]"
                                            name="deleteAlbum"><x-icon.delete p="20" l="20" /></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown name="Property Address" :open=true>
                        <div id="map" class="w-full h-[400px] rounded-xl">

                        </div>
                        <br>
                        <div class="mt-3 w-full min-w-[0px]">
                            <x-custom-input id="apiMap" style="" class="!pr-[220px]"
                                placeholder="click to get current location" type="text" name="apiMap" autofocus
                                :readonly=true><x-icon.location p="20" l="20" />
                                <x-slot:extended>
                                    <div
                                        class="w-[25px] flex justify-end items-center absolute top-1/2 -translate-y-1/2 right-[5px]">
                                        <x-primary-button name="get_location"
                                            class="!p-[2px] !px-[5px] text-nowrap flex gap-[5px]"><x-icon.near p="20"
                                                l="20" />Use current location</x-primary-button>
                                    </div>
                                </x-slot:extended>
                            </x-custom-input>
                        </div>
                        <div class="mt-3 w-full min-w-[0px]">
                            <x-input-label for="street_name">Street Name <a class="text-red-700">*</a></x-input-label>
                            <input type="hidden" name="longtitude" />
                            <input type="hidden" name="latitude" />
                            <x-text-input id="street_name" style="" class="block mt-2 w-full h-full bg-gray-200"
                                placeholder="Street Name" type="text" name="street_name"
                                values="{{ $property->property_address->street_name }}" :value="old('street_name')" autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('street_name')" class="mt-1" />
                        <div class="flex justify-between gap-[15px] ">
                            <div class="mt-3 w-full h-full min-w-[0px] ">
                                <x-input-label for="state">Place <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="state" style=""
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Place" type="text"
                                    name="state" values="{{ $property->property_address->state }}"
                                    :value="old('state')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('state')" class="mt-1" />
                            <div class="mt-3 w-full h-full min-w-[0px] ">
                                <x-input-label for="zipcode">Zipcode <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="zipcode" style=""
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Zipcode" type="number"
                                    name="zipcode" values="{{ $property->property_address->zipcode }}"
                                    :value="old('zipcode')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('zipcode')" class="mt-1" />
                        </div>
                        <div class="flex justify-between gap-[15px] ">
                            <div class="mt-3 w-full h-full min-w-[0px] ">
                                <x-input-label for="province">Province <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="province" style=""
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Province"
                                    type="text" name="province"
                                    values="{{ $property->property_address->province }}" :value="old('province')"
                                    autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('province')" class="mt-1" />
                            <div class="mt-3 w-full h-full min-w-[0px] ">
                                <x-input-label for="country">Country <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="country" style=""
                                    class="block mt-2 w-full h-full bg-gray-200" placeholder="Country" type="text"
                                    name="country" values="{{ $property->property_address->country }}"
                                    :value="old('country')" autofocus />
                            </div>
                            <x-input-error :messages="$errors->get('country')" class="mt-1" />
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown name="Property Contact" :open=true>
                        <div class=" w-full min-w-[0px] ">
                            <x-input-label for="contact_name">Contact Name <a
                                    class="text-red-700">*</a></x-input-label>
                            <x-text-input id="contact_name" style=""
                                class="block mt-2 w-full h-full bg-gray-200" placeholder="Contact Name"
                                type="text" name="contact_name"
                                values="{{ $property->property_contact->contact_name }}" :value="old('contact_name')"
                                autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('contact_name')" class="mt-1" />
                        <div class="mt-3 w-full min-w-[0px] ">
                            <x-input-label for="contact_phone">Contact Phone <a
                                    class="text-red-700">*</a></x-input-label>
                            <x-text-input id="contact_phone" style=""
                                class="block mt-2 w-full h-full bg-gray-200" placeholder="Contact Phone"
                                type="tel" name="contact_phone"
                                values="{{ $property->property_contact->contact_phone }}" :value="old('contact_phone')"
                                autofocus />
                        </div>
                        <x-input-error :messages="$errors->get('contact_phone')" class="mt-1" />
                    </x-box-dropdown>
                </div>
                <div class="w-[400px] flex gap-[30px] flex-col">
                    <x-box-dropdown name="Property Cover" :open=true>
                        <input type="hidden" name="id_cover"
                            value="{{ $property->album !== null ? $property->album->id_album : 0 }}" />
                        <img id="propertyCover"
                            src="{{ $property->album !== null ? asset('storage/' . $property->album->imagePath) : 's' }}"
                            class="object-cover rounded-xl" onerror="this.src='{{ asset('img/placeholder.png') }}'"
                            width=100% height=100%>

                    </x-box-dropdown>
                    <x-box-dropdown name="History" :open=true>
                        <x-a-label>Created At</x-a-label><br>
                        <x-a-label class="text-xs">{{ $property->created_at }}</x-a-label><br><br>
                        <x-a-label>Updated At</x-a-label><br>
                        <x-a-label class="text-xs">{{ $property->updated_at }}</x-a-label>
                    </x-box-dropdown>
                </div>
            </div>
        </div>
    </div>
    {{-- <x-rentNavigation/> --}}
</x-app-layout>
