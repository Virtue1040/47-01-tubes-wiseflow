@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Property Transaction')

<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#transaction-list'), 'transaction/' + {{ $property->id_property }},{
                'checkNumber': 'Check Number',
                'id_transaction': "ID Transaction",
                'full_name': "Name",
                'type_payment': 'Type Payment',
                'nominal': 'Nominal',
                'status_payment': 'Status',
                'payment_date': 'Waktu Payment',
            }, {});

            handle_itemlist($('#transaction-iuran-list'), 'transaction-iuran/' + {{ $property->id_property }},{
                'checkNumber': 'Check Number',
                'id_transaction': "ID Transaction",
                'full_name': "Name",
                'type_payment': 'Type Payment',
                'nominal': 'Nominal',
                'status_payment': 'Status',
                'payment_date': 'Waktu Payment',
            }, {});
        })
    </script>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Property Transaction') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <div class="flex flex-col gap-6">
                <x-a-label class="text-2xl font-bold">Booking Transaction</x-a-label>
                <x-card.list-item id="transaction-list"/>
            </div>
            <div class="flex flex-col gap-6 mt-6">
                <x-a-label class="text-2xl font-bold">Iuran Transaction</x-a-label>
                <x-card.list-item id="transaction-iuran-list"/>
            </div>
        </div>
    </div>
</x-app-layout>
