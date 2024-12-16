@section('property_name', $property->property_name)
@section('property_rent', $property)
@section('property_id', $property->id_property)


<x-app-layout>
    <script>
        $('#contentContainer').css('padding', '0px');
    </script>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Rent Management') }}
        </h2>
    </x-slot>
    <div class="flex w-full h-full">
        
        <x-rentNavigation/>
    </div>
</x-app-layout>
