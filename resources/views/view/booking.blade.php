<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#booking-list'), 'booking',{
                'id_booking': 'ID Booking',
                'property_name': 'Property',
                'rent_name': 'Rent',
                'status': 'Status',
                'checkin': 'Check In',
                'checkout': 'Check Out',
            }, {});
        })
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-[80%]">
            <x-card.list-item id="booking-list"/>
        </div>
    </div>
</x-app-layout>
