
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<x-app-layout>
    <script>
        let oldInput = @json(old()); 
        let createPropertyBounced = false;
        $(document).ready(function() {
            if (oldInput['form_name'] === "property_create") { createProperty(); }
        })
        function createProperty() {
            if (createPropertyBounced) { return; }
            createPropertyBounced = true;
            console.log("WHAT DU HELLLLLL");
            let returns = init_create_modal("property_create", [
                {
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
                }
            ], [
                `
                        <div>
                            <div class="flex justify-between gap-[15px] ">
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                    <x-input-label for="property_name">Nama Property <a class="text-red-700">*</a></x-input-label>
                                    <x-text-input id="property_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama Property"  type="text" name="property_name"
                                        :value="old('property_name')"  autofocus/>
                                </div>
                                <x-input-error :messages="$errors->get('property_name')" class="mt-1" />
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                    <x-input-label for="property_category">Category Property <a class="text-red-700">*</a></x-input-label>
                                    <x-select id="property_category" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Category Property" name="property_category"
                                        :value="old('property_category')"  autofocus>
                                        <option value="Kontrakan">Kontrakan</option>
                                        <option value="Kost">Kost</option>
                                        <option value="Other">Lain-lain</option>
                                    </x-select>
                                </div>
                                <x-input-error :messages="$errors->get('property_category')" class="mt-1" />
                            </div>
                            
                            <div class="mt-3 w-full min-w-[0px] ">
                                <x-input-label for="property_category">Property Description <a class="text-red-700">*</a></x-input-label>
                                <x-text-area id="property_desc" style="" class="block mt-2 w-full h-[150px] bg-gray-200" placeholder="Deskripsi Kontrakan"  type="text" name="property_desc"
                                  autofocus>{{ old('property_desc') }}</x-text-area>
                            </div>
                            <x-input-error :messages="$errors->get('property_desc')" class="mt-1" />
                        </div>
                    `,
                `
                        <div>
                            <div class="mt-3 w-full min-w-[0px]">
                                <x-input-label for="street_name">Street Name <a class="text-red-700">*</a></x-input-label>
                                <x-text-input id="street_name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Street Name"  type="text" name="street_name"
                                    :value="old('street_name')"  autofocus/>
                            </div>
                            <x-input-error :messages="$errors->get('street_name')" class="mt-1" />
                            <div class="flex justify-between gap-[15px] ">
                                <div class="mt-3 w-full h-full min-w-[0px] ">
                                    <x-input-label for="state">State <a class="text-red-700">*</a></x-input-label>
                                    <x-text-input id="state" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="State"  type="text" name="state"
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
                            <div class="mt-3 w-full min-w-[0px] ">
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
            ],{
                1: ['property_name', 'property_category', 'property_desc'],
                2: ['street_name', 'state', 'zipcode', 'province', 'country'],
                3: ['contact_name', 'contact_phone'],
            }, 
            {
                lastButton: "Create Property",
                onCreate: function() {
                    handle_drag($("#property_upload_area"), $("#albumImage"), ['image/jpeg', 'image/png', 'image/gif', 'image/jpg']);
                    createPropertyBounced = false;
                },
            })
        }
    </script>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Property') }}
        </h2>
    </x-slot>

    <div class="flex">
        <div class="flex flex-col flex-wrap gap-6 md:flex-row grow md:grow-0">
            <!-- Kost 1 -->
            @foreach ($property as $prop)
                <x-card.property class=" min-w-[300px]" url='/view/property/detail/{{ $prop->id_property }}' kost_nama='{{ $prop->property_name }}' kost_desc='{{ $prop->property_desc }}'
                imgUrl='storage/{{$prop->album->imagePath}}' test="{{$prop->album }}"> </x-card.property>
            @endforeach
        </div>
    </div>

    <button onclick="createProperty();"
        class="w-[50px] h-[50px] fixed right-10 bottom-10 text-3xl font-bold text-white bg-blue-500 rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <div class="relative w-full h-full">
            <span class="flex absolute top-1/2 left-1/2 items-center -translate-x-1/2 -translate-y-1/2">+</span>
        </div>
    </button>
</x-app-layout>
