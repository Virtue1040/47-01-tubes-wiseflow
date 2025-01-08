@section('title', '- Iuran Pay')

<x-app-layout>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}"></script>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#bill-list'), 'getbills',{
                'iuran_desc': 'Iuran Name',
                'type_iuran': 'Iuran Type',
                'nominal_iuran': 'Amount',
                'status': 'Status',
                'tenggat_iuran': 'Due Date',
            }, {
                "useAction": true,
                "useEdit": false,
                "useDelete": false,
                "usePay": true,
                onPay: function(data) {
                    payIuran(data.id_iuran);
                },
                "onActionCreate": function(itemData, itemRow, addButtonFunction) {
                    if (itemData.status === "Belum Lunas") {
                        addButtonFunction("pay");
                    }
                }
            });
        })

        function payIuran(id_iuran) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("iuran", [{
                    icon: 'detail',
                    title: 'Pay Iuran'
                },
            ], [
                `
                        <div>
                            <div class="justify-center items-center w-full h-full" id="snap-container">
                            </div>
                        </div>
                    `,
            ], {

            }, {
                lastButton: "Pay Iuran",
                disableClose: true,
                onCreate: function(form, div) {
                    $.ajax({
                            url: "/api/paybill/" + id_iuran,
                            type: "POST",
                            data: {},
                            success: function(response) {
                                if (response.success) {
                                    let buttonContinue = div.find("button[name='continue']");
                                    let buttonBack = div.find("button[name='back']");
                                    buttonBack.addClass("hidden");
                                    buttonContinue.addClass("hidden");
                                    window.snap.embed(response.token, {
                                        embedId: 'snap-container',
                                        onSuccess: function (result) {
                                            Toast.fire({
                                                icon: 'success',
                                                title: 'Bill Successfuly Paid',
                                            });
                                            window.location.reload();
                                            div.remove();
                                        },
                                        onPending: function (result) {
                                            
                                        },
                                        onError: function (result) {
                                            div.remove();
                                        },
                                        onClose: function () {
                                            div.remove();
                                        }
                                    });
                                    $("#snap-midtrans").css("width", "564px");
                                    $("#snap-midtrans").addClass("w-[564px]");

                                }
                            }
                        })
                    createBounced = false;
                },
            })
        }
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('My Bills') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <x-card.list-item id="bill-list"/>
        </div>
    </div>
</x-app-layout>
