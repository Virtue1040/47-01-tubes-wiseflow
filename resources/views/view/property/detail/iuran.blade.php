@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Iuran Management')

<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#iuran-list'), 'iuran', {
                'id_iuran': 'ID Iuran',
                'iuran_desc': 'Iuran Name',
                'type_iuran': 'Iuran Type',
                'nominal_iuran': 'Amount',
                'status': 'Status',
                'tenggat_iuran': 'Due Date',
            }, {
                "useAction": true,
                onEdit: function(data) {
                    editIuran(data);
                },
                onDelete: function(data) {
                    askConfirmation('iuran/' + data.id_iuran, 'DELETE', [],
                        'Are you sure you want to delete this iuran?');
                },
            });
            // handle_itemlist($('#iuran-list'), 'iuran',{
            //     'id_iuran': 'ID Iuran',
            //     'property_name': 'Property',
            //     'type_iuran': 'Type Iuran',
            //     'status': 'Status',
            //     'tenggat_iuran': 'Tenggat Iuran',
            // }, {});
        })

        function editIuran(data) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("iuran/" + data.id_iuran, [{
                icon: 'detail',
                title: 'Edit Iuran'
            }], [
                `       
                        
                            <div class="grid grid-cols-2 gap-6">
                                @method("PUT")
                                <!-- Iuran Type -->
                                <div class="mt-3">
                                    <label for="type_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Type <a class="text-red-700">*</a> 
                                    </label>
                                    <x-select type="text" name="type_iuran" id="type_iuran"  class=" p-[6.5px] block mt-2 w-full h-full bg-gray-200"  required>
                                        <option ${data.type_iuran === "listrik" ? "selected" : ""} value="listrik">Listrik</option>
                                        <option ${data.type_iuran === "air" ? "selected" : ""} value="air">Air</option>
                                        <option ${data.type_iuran === "bulanan" ? "selected" : ""} value="bulanan">Kebutuhan Bulanan</option>
                                    </x-select>
                                </div>
                                <x-input-error :messages="$errors->get('type_iuran')" class="mt-1" />

                                <div class="mt-3">
                                    <label for="iuran_desc" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Description <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-area name="iuran_desc" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="iuran_desc" required>${data.iuran_desc}</x-text-area>
                                </div>
                                <x-input-error :messages="$errors->get('iuran_desc')" class="mt-1" />

                                <!-- Amount -->
                                <div class="mt-3">
                                    <label for="nominal_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Amount <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-input type="number" name="nominal_iuran" class="block mt-2 w-full h-full bg-gray-200" id="nominal_iuran" values="${data.nominal_iuran}" required/>
                                </div>
                                <x-input-error :messages="$errors->get('nominal_iuran')" class="mt-1" />
                                    
                                <!-- Due Date -->
                                <div class="mt-3">
                                    <label for="tenggat_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Due Date <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-input type="date" name="tenggat_iuran" class="block mt-2 w-full h-full bg-gray-200" values="${data.tenggat_iuran}" id="tenggat_iuran" required/>
                                </div>
                                <x-input-error :messages="$errors->get('tenggat_iuran')" class="mt-1" />
                            </div>
                        
                    `,
            ], {
                1: ["type_iuran", "iuran_desc", "nominal_iuran", "tenggat_iuran"]
            }, {
                lastButton: "Edit Iuran",
                onCreate: function(form) {

                    createBounced = false;
                },
            })
        }

        function createIuran() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("iuran", [{
                icon: 'detail',
                title: 'Create Iuran'
            }], [
                `       
                        
                            <div class="grid grid-cols-2 gap-6">
                                <input type="hidden" name="id_property" value="{{ $property->id_property }}">
                                <!-- Iuran Type -->
                                <div class="mt-3">
                                    <label for="type_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Type <a class="text-red-700">*</a> 
                                    </label>
                                    <x-select type="text" name="type_iuran" id="type_iuran"  class=" p-[6.5px] block mt-2 w-full h-full bg-gray-200"  required>
                                        <option value="listrik">Listrik</option>
                                        <option value="air">Air</option>
                                        <option value="bulanan">Kebutuhan Bulanan</option>
                                    </x-select>
                                </div>
                                <x-input-error :messages="$errors->get('type_iuran')" class="mt-1" />

                                <div class="mt-3">
                                    <label for="iuran_desc" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Description <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-area placeholder="Iuran Description" name="iuran_desc" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="iuran_desc" required/>
                                </div>
                                <x-input-error :messages="$errors->get('iuran_desc')" class="mt-1" />

                                <!-- Amount -->
                                <div class="mt-3">
                                    <label for="nominal_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Amount <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-input type="number" placeholder="Nominal Iuran" name="nominal_iuran" class="block mt-2 w-full h-full bg-gray-200" id="nominal_iuran" required/>
                                </div>
                                <x-input-error :messages="$errors->get('nominal_iuran')" class="mt-1" />
                                    
                                <!-- Due Date -->
                                <div class="mt-3">
                                    <label for="tenggat_iuran" placeholder="Tenggat Iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Due Date <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-input type="date" name="tenggat_iuran" class="block mt-2 w-full h-full bg-gray-200" id="tenggat_iuran" required/>
                                </div>
                                <x-input-error :messages="$errors->get('tenggat_iuran')" class="mt-1" />
                            </div>
                        
                    `,
            ], {
                1: ["type_iuran", "iuran_desc", "nominal_iuran", "tenggat_iuran"]
            }, {
                lastButton: "Create Iuran",
                onCreate: function(form) {

                    createBounced = false;
                },
            })
        }
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Iuran Management') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        <!-- Iuran List -->
        <div class="mt-6 mx-auto flex gap-[35px] max-w-5xl">
            <x-card.list-item id="iuran-list" />
        </div>

        <!-- Button to trigger modal -->
        <div class="mt-6">
            <x-primary-button onclick="createIuran();" type="button"
                class="px-4 py-2 text-white bg-[#5E93DA] rounded-lg ">
                Add Iuran
            </x-primary-button>
        </div>
    </div>

</x-app-layout>
