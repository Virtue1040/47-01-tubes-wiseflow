@section('title', '- All Booking')
<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#booking-list'), 'booking/getAll',{
                'orderNumber': 'Order Number',
                'property_name': 'Property',
                'rent_name': 'Rent',
                'status': 'Status',
                'checkin': 'Check In',
                'checkout': 'Check Out',
            }, {
                "onStatusColor": function(itemData, object) {
                    if (itemData.status === "paid") {
                        object.find("p").css("background-color", "green");
                    } else {
                        object.find("p").css("background-color", "#F87171");
                    }
                    return object.prop("outerHTML");
                },
            });
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
