<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#transaction-list'), 'transaction',{
                'checkNumber': 'Check Number',
                'id_transaction': "ID Transaction",
                'type_payment': 'Type Payment',
                'nominal': 'Nominal',
                'status_payment': 'Status',
                'payment_date': 'Waktu Payment',
            }, {});
        })
    </script>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('All Transaction') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <x-card.list-item id="transaction-list"/>
        </div>
    </div>
</x-app-layout>
