@section('title', '- My Property')
<x-app-layout>
    @if (Auth::user()->hasAnyRole(['Owner', 'Admin']))
        <script>
            let oldInput = @json(old());
            $(document).ready(function() {
                if (oldInput['form_name'] === "property") {
                    createProperty();
                }
            })

            function createProperty() {
                if (createBounced) {
                    return;
                }
                createBounced = true;
                let returns = init_create_modal("property", [{
                    icon: 'detail',
                    title: 'Detail'
                }, {
                    icon: 'address',
                    title: 'Address'
                }, {
                    icon: 'contact',
                    title: 'Contact&nbsp;Detail'
                }, {
                    icon: 'image',
                    title: 'Cover'
                }], [
                    `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="property_name">Nama Property <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="property_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Property"  type="text" name="property_name"
                                            :value="old('property_name')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('property_name')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="property_category">Category Property <a class="text-red-700">*</a></x-input-label>
                                        <x-select id="property_category" class=" p-[6.5px] block mt-2 w-full h-full bg-gray-200" placeholder="Category Property" name="property_category"
                                            :value="old('property_category')"  autofocus>
                                            @foreach (config("enums.property_category") as $key => $value)
                                                <option value="{{ ucfirst($value) }}">{{ ucfirst($value) }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>
                                    <x-input-error :messages="$errors->get('property_category')" class="mt-1" />
                                </div>
                                
                                <div class="mt-3 w-full min-w-[0px] ">
                                    <x-input-label for="property_desc">Property Description <a class="text-red-700">*</a></x-input-label>
                                    <x-text-area id="property_desc" style="" class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Kontrakan"  type="text" name="property_desc"
                                    autofocus>{{ old('property_desc') }}</x-text-area>
                                </div>
                                <x-input-error :messages="$errors->get('property_desc')" class="mt-1" />
                            </div>
                        `,
                    `
                            <div>
                                <div class="mt-3 w-full min-w-[0px]">
                                    <x-custom-input id="apiMap" :readonly=true style="" class="!pr-[220px]" placeholder="click to get current location"  type="text" name="apiMap"  autofocus><x-icon.location p="20" l="20"/>
                                        <x-slot:extended>
                                            <div class="w-[25px] flex justify-end items-center absolute top-1/2 -translate-y-1/2 right-[5px]">
                                                <x-primary-button name="get_location" class="!p-[2px] !px-[5px] text-nowrap flex gap-[5px]"><x-icon.near p="20" l="20"/>Use current location</x-primary-button>
                                            </div>
                                        </x-slot:extended>
                                    </x-custom-input>
                                </div>
                                <input type="hidden" name="longitude" />
                                <input type="hidden" name="latitude" />
                                <div class="mt-3 w-full min-w-[0px]">
                                    <x-input-label for="street_name">Street Name <a class="text-red-700">*</a></x-input-label>
                                    <x-text-input id="street_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Street Name"  type="text" name="street_name"
                                        :value="old('street_name')"  autofocus/>
                                </div>
                                <x-input-error :messages="$errors->get('street_name')" class="mt-1" />
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px] ">
                                        <x-input-label for="state">Place <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="state" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Place"  type="text" name="state"
                                            :value="old('state')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('state')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px] ">
                                        <x-input-label for="zipcode">Zipcode <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="zipcode" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Zipcode"  type="number" name="zipcode"
                                            :value="old('zipcode')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('zipcode')" class="mt-1" />
                                </div>
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px] ">
                                        <x-input-label for="province">Province <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="province" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Province"  type="text" name="province"
                                            :value="old('province')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('province')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px] ">
                                        <x-input-label for="country">Country <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="country" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Country"  type="text" name="country"
                                            :value="old('country')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('country')" class="mt-1" />
                                </div>
                            </div>
                    `,
                    `
                            <div>
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                    <x-input-label for="contact">Contact Information </x-input-label>
                                    <x-select id="contact" class=" p-[6.5px] block mt-2 w-full h-full bg-gray-200" placeholder="Contact Information" name="contact"
                                        :value="old('contact')"  autofocus>
                                            <option value="" selected>Select Saved Contact</option>
                                    </x-select>
                                </div>
                                <br>
                                <div class="flex gap-[15px] items-center">
                                    <hr class="dark:border-[#464649] border-gray-200 w-full">
                                    <x-a-label>Or</x-a-label>
                                    <hr class="dark:border-[#464649] border-gray-200 w-full">
                                </div>
                                <div class="mt-6 w-full min-w-[0px] ">
                                    <x-input-label for="contact_name">Contact Name <a class="text-red-700">*</a></x-input-label>
                                    <x-text-input id="contact_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Contact Name"  type="text" name="contact_name"
                                        :value="old('contact_name')"  autofocus/>
                                </div>
                                <x-input-error :messages="$errors->get('contact_name')" class="mt-1" />
                                <div class="mt-3 w-full min-w-[0px] ">
                                    <x-input-label for="contact_phone">Contact Phone <a class="text-red-700">*</a></x-input-label>
                                    <x-text-input id="contact_phone" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Contact Phone"  type="tel" name="contact_phone"
                                        :value="old('contact_phone')"  autofocus/>
                                </div>
                                <x-input-error :messages="$errors->get('contact_phone')" class="mt-1" />
                            </div>
                        `,
                    `
                            <div>
                                <div class="flex justify-center items-center w-full h-auto min-h-[350px] py-[25px] flex-col gap-4 border-4 rounded-2xl border-dashed" id="property_upload_area">
                                    <x-uploadfile id="albumImage" name="album" text="Upload or Drag Here (.jpg/.jpeg)"></x-uploadfile>
                                </div>
                                <x-input-error :messages="$errors->get('album')" class="mt-1" />
                                
                            </div>
                        `
                ], {
                    1: ['property_name', 'property_category', 'property_desc'],
                    2: ['street_name', 'state', 'zipcode', 'province', 'country'],
                    3: ['contact_name', 'contact_phone', '||contact'],
                }, {
                    lastButton: "Create Property",
                    onNext: function(prevStep, nextStep, form) {
                        if (prevStep === 2) {
                            let longitude = $(form).find('[name="longitude"]');
                            let latitude = $(form).find('[name="latitude"]');
                            let streetName = $(form).find('[name="street_name"]');
                            let state = $(form).find('[name="state"]');
                            let zipcode = $(form).find('[name="zipcode"]');
                            let province = $(form).find('[name="province"]');
                            let country = $(form).find('[name="country"]');
                            
                            geocodeAddress(streetName.val() + ', ' + province.val() + ', ' + state.val() + ', ' + zipcode.val() + ', ' + country.val(), function(long, lat) {
                                longitude.val(long);
                                latitude.val(lat);
                                console.log(long + ' ' + lat);
                                console.log(longitude);
                            });
                            console.log(longitude);
                            console.log(longitude.val());
                            console.log(latitude.val());
                            
                        }
                    },
                    onCreate: function(form) {
                        loadTinyMCE('textarea#property_desc', function(editor) {
                            editor.on('Change', function() {
                                $("textarea#property_desc").val(editor.getContent())
                                    .trigger(
                                        "change");
                            });
                        });
                        createBounced = false;
                        let selectContact = $(form).find("select[name='contact']");
                        $.ajax({
                            url: "{{ route('contact.getAll') }}",
                            type: "GET",
                            success: function(response) {
                                if (response.success) {
                                    let data = response.data;
                                    data.forEach(function(contact) {
                                        selectContact.append(`
                                                <option value=${contact.id_contact}>Name : ${contact.name}, Phone : ${contact.no_hp}</option>
                                        `);
                                    });   
                                }
                            }
                        })
                        let getLoc = $(form).find('[name="get_location"]');
                        getLoc.click(function() {
                            event.preventDefault();
                            navigator.geolocation.getCurrentPosition(function(position) {
                                reverseGeocode(position.coords.longitude, position.coords.latitude, function(data) {
                                    console.log(data);
                                    $(form).find('#apiMap').val(data.properties.place_formatted);
                                    let country = data.properties.context.country.name;
                                    let county = data.properties.context.place.name;
                                    let postcode = data.properties.context.postcode.name;
                                    let locality = data.properties.context.locality.name;
                                    let neighborhood = data.properties.context.neighborhood.name;
                                    let place = data.properties.context.place.name;
                                    $(form).find('input[name="country"]').val(country)
                                    $(form).find('input[name="province"]').val(county);
                                    $(form).find('input[name="zipcode"]').val(postcode);
                                    $(form).find('input[name="state"]').val(county);
                                    $(form).find('input[name="street_name"]').val(locality + ', ' + neighborhood + ', ' + place).trigger('change');;
                                });
                            });
                        });
                    },
                })
            }
        </script>
    @endif
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Property') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-[25px]">
        <div class="dark:bg-[#18181B] bg-white shadow-lg rounded-xl border-[1px] dark:border-[#464649] border-gray-200 flex p-4 md:flex-row flex-col md:h-[180px] h-auto">
            @foreach (config("enums.property_category") as $key => $value)
                @php
                    $getAvailable = 0;
                    $getTotalRent = 0;
                    $getTotalProp = 0;
                @endphp
                @foreach ($property as $getCate)
                    @if (($getCate->property_category) === $value)
                        @php
                            $getAvailable += $getCate->total_available;
                            $getTotalRent += count($getCate->rent);
                            $getTotalProp += 1;
                        @endphp
                    @endif
                @endforeach
                <div class="flex flex-col justify-between w-[100%] dark:border-[#464649] border-gray-200 p-4 py-2 [&:not(:first-child)]:px-6 md:[&:not(:first-child)]:border-l-[1px] md:[&:not(:first-child)]:border-t-[0px] [&:not(:first-child)]:border-t-[1px]">
                    <div class="flex gap-[15px] items-center">
                        @switch($value)
                            @case('Kontrakan')
                                <x-icon.kontrakan p="35" l="35" :active=true/>
                                @break
                            @case('Kost')
                                <x-icon.kost p="35" l="35" :active=true/>
                                @break
                            @case('Hotel')
                                <x-icon.hotel p="35" l="35" :active=true/>
                                @break
                            @case('Apartemen')
                                <x-icon.apartement p="35" l="35" :active=true/>
                                @break
                            @default
                                
                        @endswitch
                        <x-a-label class="text-lg !text-gray-400">{{ ucfirst($value) }}</x-a-label>
                    </div>
                    <x-a-label class="text-xl">{{ $getTotalProp }}</x-a-label>
                    <div class="flex justify-between items-center">
                        <div class="flex gap-[10px] items-center">
                            <x-a-label class="text-lg !text-gray-400">Rent</x-a-label>
                            <x-a-label>{{ $getTotalRent }}</x-a-label>
                        </div>
                        <div class="flex gap-[10px] items-center">
                            <x-a-label class="text-lg !text-gray-400">Available</x-a-label>
                            <x-a-label>{{ $getAvailable }}</x-a-label>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div x-data="{ openedCategory: 'All' }" class="flex flex-col gap-[15px]">
            <div class="flex justify-between items-center" id="property_type">
                <div class="flex gap-[5px]">
                    <x-a-label x-bind:class="openedCategory !== 'All' ? 'hidden' : ''" class="text-xl font-bold">All Property</x-a-label>
                    <x-a-label x-bind:class="openedCategory === 'All' ? 'hidden' : ''" class="text-xl font-bold">All </x-a-label>
                    <x-a-label x-bind:class="openedCategory === 'All' ? 'hidden' : ''" class="text-xl font-bold" x-text="openedCategory"></x-a-label>
                </div>
                <div>
                    <div
                        class="m-auto w-fit p-[10px] py-[8px] bg-white dark:bg-[#18181B] rounded-full shadow-lg h-auto border-gray-200 dark:border-[#272729] border-[1px]">
                        <div class="flex gap-[10px]">
                            <button name="openOverview" @click="openedCategory = 'All'"
                                x-bind:class="openedCategory === 'All' ? 'bg-[#5E93DA]' : 'hover:bg-[#5E93DA] hover:bg-opacity-50'"
                                class="px-[10px] rounded-full"><x-a-label
                            x-bind:class="openedCategory === 'All' ? 'font-bold !text-white' : ''">All</x-a-label></button>
                            @foreach ($propertyCategory as $propCate)
                            <button name="openOverview" @click="openedCategory = '{{ $propCate->property_category }}'"
                                x-bind:class="openedCategory === '{{ $propCate->property_category }}' ? 'bg-[#5E93DA]' : 'hover:bg-[#5E93DA] hover:bg-opacity-50'"
                                class="px-[10px] rounded-full"><x-a-label
                            x-bind:class="openedCategory === '{{ $propCate->property_category }}' ? 'font-bold !text-white' : ''">{{ $propCate->property_category }}</x-a-label></button>
                            @endforeach
                        </div>
                </div>
                </div>
            </div>
            <div x-show="openedCategory === 'All'" class="grid 2xl:grid-cols-5 grid-flow-row md:flex-row gap-[25px] md:grid-cols-3 grid-cols-1">
                <!-- Kost 1 -->
                @foreach ($property as $prop)
                    <x-card.property class=" w-[100%]" id="{{ $prop->id_property }}"
                        kost_nama='{{ $prop->property_name }}' kost_desc='' rent='{{ count($prop->rent) }}' facility='{{ count($prop->facility) }}'
                        imgUrl='storage/{{ $prop->album->imagePath }}' test="{{ $prop->album }}" location="{{ $prop->property_address->street_name }}"> </x-card.property>
                @endforeach
            </div>
            @foreach ($propertyCategory as $propCate)
                <div x-show="openedCategory === '{{ $propCate->property_category }}'" class="grid grid-cols-3 2xl:grid-cols-5 grid-flow-row md:flex-row gap-[25px]">
                    <!-- Kost 1 -->
                    @foreach ($property as $prop)
                        @if ($prop->property_category !== $propCate->property_category)
                            @continue
                        @endif
                        <x-card.property class=" w-[100%]" id="{{ $prop->id_property }}"
                            kost_nama='{{ $prop->property_name }}' kost_desc='' rent='{{ count($prop->rent) }}' facility='{{ count($prop->facility) }}'
                            imgUrl='storage/{{ $prop->album->imagePath }}' test="{{ $prop->album }}" location="{{ $prop->property_address->street_name }}"> </x-card.property>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>

    @if (Auth::user()->hasAnyRole(['Owner', 'Admin']))
        <button onclick="createProperty();"
            class="w-[50px] h-[50px] fixed right-10 bottom-10 text-3xl font-bold text-white bg-[#5E93DA] rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <div class="relative w-full h-full">
                <span class="flex absolute top-1/2 left-1/2 items-center -translate-x-1/2 -translate-y-1/2">+</span>
            </div>
        </button>
    @endif
</x-app-layout>
