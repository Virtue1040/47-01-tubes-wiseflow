<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#booking-list'), 'booking/getAll',{
                'id_booking': 'ID Booking',
                'id_property': 'Property',
                'status': 'Status',
                'checkin': 'Check In',
                'checkout': 'Check Out',
            }, {});
        })
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('All Bookings') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <x-card.list-item id="booking-list"/>
        </div>
    </div>
</x-app-layout>
