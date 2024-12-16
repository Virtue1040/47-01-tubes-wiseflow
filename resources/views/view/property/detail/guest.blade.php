@section('property_name', $property->property_name)
@section('property_id', $property->id_property)

<title>Wiseflow - Property's Guest</title>
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Guests') }}
        </h2>
    </x-slot>

    <div class="p-4 w-full">
        <table class="overflow-hidden min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Room Number</th>
                    <th class="px-4 py-2 text-left">Booking Number</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">Charlotte Clark</td>
                    <td class="px-4 py-2 border">Charlotte@gmail.com</td>
                    <td class="px-4 py-2 border">-</td>
                    <td class="px-4 py-2 border">101</td>
                    <td class="px-4 py-2 border">BDC-5d017f...</td>
                    <td class="px-4 py-2 border"><a href="#" class="text-blue-600">View/Edit Profile</a></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">William Smith</td>
                    <td class="px-4 py-2 border">Smith452@outlook.com</td>
                    <td class="px-4 py-2 border">-</td>
                    <td class="px-4 py-2 border">102</td>
                    <td class="px-4 py-2 border">BDC-38760...</td>
                    <td class="px-4 py-2 border"><a href="#" class="text-blue-600">View/Edit Profile</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</x-app-layout>
