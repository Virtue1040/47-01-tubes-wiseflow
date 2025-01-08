@section('title', '- My Booking')
<x-app-layout>
    <script>
        function rateRent(id_booking) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("rent/rate/" + id_booking, [{
                    icon: 'detail',
                    title: 'Rate Property'
                },
            ], [
                `
                        <div>
                            <div class="rate">
                                <input type="radio" id="star5" name="rating" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rating" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rating" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rating" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rating" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>
                            <div class="mt-3">
                                    <label for="comment" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Comment
                                    </label>
                                    <x-text-area name="comment" class="block mt-2 h-[210px] w-full h-full bg-gray-200" id="comment" required/>
                                </div>
                                <x-input-error :messages="$errors->get('comment')" class="mt-1" />
                        </div>
                    `,
            ], {
            }, {
                lastButton: "Rate",
                "min-width": "550px",
                onCreate: function(form, div) {
                    createBounced = false;
                },
            })
        }
        $(document).ready(function() {
            handle_itemlist($('#booking-list'), 'booking',{
                'orderNumber': 'Order Number',
                'property_name': 'Property',
                'rent_name': 'Rent',
                'status': 'Status',
                'checkin': 'Check In',
                'checkout': 'Check Out',
            }, {
                "useAction": true,
                "useEdit": false,
                "useDelete": false,
                onDelete: function(data) {
                    askConfirmation('booking/' + data.id_booking, 'DELETE', [], 'Are you sure you want to delete this booking?');
                },
                onFavorite: function(data) {
                    rateRent(data.id_booking);
                },
                "onStatusColor": function(itemData, object) {
                    if (itemData.status === "paid") {
                        object.find("p").css("background-color", "green");
                    } else {
                        object.find("p").css("background-color", "#F87171");
                    }
                    return object.prop("outerHTML");
                },
                "onActionCreate": function(itemData, itemRow, addButtonFunction) {
                    if (itemData.status === "paid") {
                        if (itemData.isRated === 0) {
                            addButtonFunction("favorite");
                        }
                    } else {
                        addButtonFunction("delete");
                    }
                }
            });
        })
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <x-card.list-item id="booking-list"/>
        </div>
    </div>
</x-app-layout>
