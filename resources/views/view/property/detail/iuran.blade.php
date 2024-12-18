@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Iuran Management')

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Iuran Management') }}
        </h2>
    </x-slot>

    <!-- Iuran List -->
    <div class="mt-6 flex gap-[35px]">
        <x-card.list-item id="iuran-list" />
    </div>

    <!-- Button to trigger modal -->
    <div class="mt-6">
        <button type="button" data-modal-target="add-iuran-modal" data-modal-toggle="add-iuran-modal"
            class="px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700">
            Add Iuran
        </button>
    </div>

    <!-- Modal for Adding Iuran -->
    <div id="add-iuran-modal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-3xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-4 rounded-t border-b dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add New Iuran
                    </h3>
                    <button type="button"
                        class="inline-flex justify-center items-center ml-auto w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="add-iuran-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1l12 12m0-12L1 13" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal body -->
                <form id="form-add-iuran" method="POST" action="{{ route('iuran.store') }}" class="p-6">
                    @csrf
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Property Name -->
                        <div>
                            <label for="property_name" class="block mb-1 text-gray-700 dark:text-gray-200">
                                Property Name
                            </label>
                            <input type="text" name="property_name" id="property_name" value="{{ $property->property_name }}" readonly
                                class="px-3 py-2 w-full rounded-lg border border-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <!-- Iuran Type -->
                        <div>
                            <label for="type_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                Iuran Type
                            </label>
                            <input type="text" name="type_iuran" id="type_iuran" required
                                class="px-3 py-2 w-full rounded-lg border border-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <!-- Amount -->
                        <div>
                            <label for="nominal_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                Amount
                            </label>
                            <input type="number" name="nominal_iuran" id="nominal_iuran" required
                                class="px-3 py-2 w-full rounded-lg border border-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>

                        <!-- Due Date -->
                        <div>
                            <label for="tenggat_iuran" class="block mb-1 text-gray-700 dark:text-gray-200">
                                Due Date
                            </label>
                            <input type="date" name="tenggat_iuran" id="tenggat_iuran" required
                                class="px-3 py-2 w-full rounded-lg border border-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 w-full text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                            Add Iuran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Flowbite Script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>

<!-- Handle Item List Script -->
<script>
    handle_itemlist($('#iuran-list'), 'iuran/list/' + {{ $property->id_property }}, {
        'id_iuran': 'Iuran ID',
        'property_name': 'Property Name',
        'type_iuran': 'Iuran Type',
        'nominal_iuran': 'Amount',
        'status': 'Status',
        'tanggal_iuran': 'Date',
        'tenggat_iuran': 'Due Date',
    }, {});
</script>
