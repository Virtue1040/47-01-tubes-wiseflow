@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Property Detail')

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __($property->property_name) }}
        </h2>
    </x-slot>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#guest-list'), 'property/getguest/' + '{{ $property->id_property }}', {
                'id_resident': 'ID Recident',
                'id_booking': 'ID Booking',
                'orderNumber': 'Order Number',
                'rent_name': 'Rent Name',
                'full_name': 'Name',
                'status': 'Status',
            }, {});

            var optionsLine = {
            chart: {
                    height: 328,
                    type: 'line',
                    background: 'transparent',
                zoom: {
                    enabled: false
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 2,
                    blur: 4,
                    opacity: 1,
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            //colors: ["#3F51B5", '#2196F3'],
            series: [{
                name: "Music",
                data: [1, 15, 26, 20, 33, 27]
                },
                {
                name: "Photos",
                data: [3, 33, 21, 42, 19, 32]
                },
                {
                name: "Files",
                data: [0, 39, 52, 11, 29, 43]
                }
            ],
            title: {
                text: 'Media',
                align: 'left',
                offsetY: 25,
                offsetX: 20
            },
            subtitle: {
                text: 'Statistics',
                offsetY: 55,
                offsetX: 20
            },
            theme: {
                    mode: isDark ? 'dark' : 'light',
                },
            markers: {
                size: 6,
                strokeWidth: 0,
                hover: {
                size: 9
                }
            },
            grid: {
                show: true,
                padding: {
                bottom: 0
                }
            },
            labels: ['01/15/2002', '01/16/2002', '01/17/2002', '01/18/2002', '01/19/2002', '01/20/2002'],
            xaxis: {
                tooltip: {
                enabled: false
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                offsetY: -20
            }
            }

            var chartLine = new ApexCharts(document.querySelector('#chart5MostProfit'), optionsLine);
            chartLine.render();

            var options = {
                series: [{
                name: 'Net Profit',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
                }, {
                name: 'Revenue',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
                }, {
                name: 'Free Cash Flow',
                data: [35, 41, 36, 26, 45, 48, 52, 53, 41]
                }],
                theme: {
                    mode: isDark ? 'dark' : 'light',
                },
                chart: {
                type: 'bar',
                height: 350,
                background: 'transparent',
                },
                plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                },
                },
                dataLabels: {
                enabled: false
                },
                stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
                },
                xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
                },
                yaxis: {
                title: {
                    text: '$ (thousands)'
                }
                },
                fill: {
                opacity: 1
                },
                tooltip: {
                y: {
                    formatter: function (val) {
                    return "$ " + val + " thousands"
                    }
                }
                }
                };

                var chart = new ApexCharts(document.querySelector("#chart5MostBooked"), options);
                chart.render();

            var options = {
                series: [44, 55, 41, 17, 15],
                chart: {
                    type: 'donut',
                    background: 'transparent',
                },
                theme: {
                    mode: isDark ? 'dark' : 'light',
                },
                responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                    width: 200
                    },
                    legend: {
                    position: 'bottom'
                    }
                }
                }]
            };

            var chart = new ApexCharts(document.querySelector("#chart5MostRated"), options);
            chart.render();
        })
    </script>
    <div class="flex gap-[25px] p-6 flex-col lg:flex-row">
        <div class="flex flex-col gap-[25px] w-full">
            <div class="flex gap-[24px] flex-col lg:flex-row ">
                <div class="flex flex-col gap-[24px] ">
                    <div class="flex 2xl:flex-row flex-col gap-[24px]">
                        <!-- Property Detail -->
                        <x-box-dropdown class="w-[100%] 2xl:w-[70%]" name="Property Detail">
                            <div class="flex gap-[25px]">
                                <img src="{{ asset('storage/' . $property->album->imagePath) }}" alt="Cover Property"
                                    class="object-cover w-[200px] rounded-2xl h-[200px]">
                                <div class="flex flex-col gap-[5px]">
                                    <div class="flex gap-[5px] items-center">
                                        <x-a-label class="text-xl font-bold">Property Name</x-a-label>
                                        <a href="{{ route('property.edit', ['id' => $property->id_property]) }}"
                                            class="bg-[#5E93DA] ml-2 py-[1px] text-sm px-[10px] text-white w-auto rounded-lg cursor-pointer">
                                            Edit Property
                                        </a>
                                    </div>
                                    <x-a-label class="text-lg">{{ $property->property_name }}</x-a-label>
                                    <x-a-label class="mt-2 text-xl font-bold">Property Description</x-a-label>
                                    <x-a-label class="text-lg">{!! $property->property_desc !!}</x-a-label>
                                </div>
                            </div>
                        </x-box-dropdown>
                        <x-box-dropdown class="w-[100%] 2xl:w-[30%]" name="Reviews">
                            <div
                                class="overflow-y-auto [&::-webkit-scrollbar]:w-2
                            [&::-webkit-scrollbar-track]:rounded-full
                            [&::-webkit-scrollbar-thumb]:rounded-full
                            [&::-webkit-scrollbar-thumb]:bg-[#5E93DA] h-[200px]">
                                <div class="flex flex-col justify-center">
                                    <div class="flex gap-[5px] items-center justify-center">
                                        <x-a-label
                                            class="text-[58px] font-bold">{{ $property->getAvgRating() + 0 }}</x-a-label>
                                        <x-icon.star p="58" l="58" filled />
                                    </div>
                                    <x-a-label class="mx-auto w-full text-center">(from {{ $property->getComment->count() }} votes)</x-a-label>
                                </div>
                                <div class="flex gap-[15px] w-full flex-col pr-[10px]">
                                    @foreach ($property->getComment as $comment)
                                        <x-card.reviews fullName="{{ $comment->user->getFullName() }}"
                                            comment="{{ $comment->comment }}" rating="{{ $comment->rating }}"
                                            imgUrl="{{ $comment->user->getAvatarUrl() }}"
                                            rentCover="{{ asset('storage/' . $comment->rent->album->imagePath) }}"
                                            rentName="{{ $comment->rent->rent_name }}"
                                            propertyId="{{ $property->id_property }}"
                                            rentId="{{ $comment->rent->id_rent }}" />
                                    @endforeach
                                </div>
                            </div>
                        </x-box-dropdown>

                    </div>
                    <div class="grid gap-6 lg:grid-cols-1 xl:grid-cols-4">

                        <!-- Jumlah Kamar -->
                        <x-box-dropdown name="Jumlah Rent">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.rent p="48" l="48" />
                            </div>
                            <x-a-label class="text-lg">{{ $property->rent->count() }} Rent</x-a-label>
                        </x-box-dropdown>

                        <!-- Fasilitas -->
                        <x-box-dropdown name="Jumlah Fasilitas">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.facility p="48" l="48" />
                            </div>
                            <x-a-label class="text-lg">{{ $property->facility->count() }} Fasilitas</x-a-label>
                        </x-box-dropdown>
                        <!-- Lokasi -->
                        <x-box-dropdown name="Lokasi">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.location p="48" l="48" />
                            </div>
                            <div class="flex w-full">
                                <x-a-label
                                    class="text-lg truncate">{{ $property->property_address->street_name }}</x-a-label>
                            </div>
                        </x-box-dropdown>

                        <!-- Tagihan -->
                        <x-box-dropdown name="Iuran">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.iuran p="48" l="48" />
                            </div>
                            <div class="flex w-full">
                                <x-a-label class="text-lg truncate">{{ $property->getTotalUnTargetedIuran() }} Uncomplete Iuran</x-a-label>
                            </div>
                        </x-box-dropdown>
                        <x-box-dropdown class="" name="Jumlah Available">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.iuran p="48" l="48" />
                            </div>
                            <div class="flex w-full">
                                <x-a-label class="text-lg truncate">{{ $property->getTotalAvailable() }} Available</x-a-label>
                            </div>
                        </x-box-dropdown>
                        <x-box-dropdown class="" name="Jumlah Stock Rent">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.iuran p="48" l="48" />
                            </div>
                            <div class="flex w-full">
                                <x-a-label class="text-lg truncate">{{ $property->getTotalRentStock() }} Stock</x-a-label>
                            </div>
                        </x-box-dropdown>

                    </div>
                </div>
                <x-box-dropdown class="w-full lg:w-[250px] lg:h-full h-[300px]" name="Manage">
                    <div class="w-full h-full">
                        <div class="flex lg:flex-row flex-row flex-wrap  gap-[10px]">
                            <a href="{{ route('property.detail.calendar', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center gap-[10px]"><x-icon.calendar
                                        p="28" l="28" class="!fill-white"/>Calendar</x-primary-button>
                            </a>
                            <a href="{{ route('property.detail.rent.overview', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center gap-[10px]"><x-icon.rent p="28"
                                        l="28" class="!fill-white"/>Rents</x-primary-button>
                            </a>
                            <a href="{{ route('property.detail.task', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center gap-[10px]"><x-icon.task p="28"
                                        l="28" class="!fill-white"/>Tasks</x-primary-button>
                            </a>
                            <a href="{{ route('property.detail.transaction', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center  gap-[10px]"><x-icon.transaction
                                        p="28" l="28" class="!fill-white"/>Transactions</x-primary-button>
                            </a>
                            <a href="{{ route('property.detail.reservation', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center gap-[10px]"><x-icon.booking
                                        p="28" l="28" class="!fill-white"/>Reservations</x-primary-button>
                            </a>
                            <a href="{{ route('property.detail.iuran', $property->id_property) }}">
                                <x-primary-button
                                    class="w-auto h-[50px] !p-[10px] flex items-center gap-[10px]"><x-icon.iuran p="28"
                                        l="28" class="!fill-white"/>Iurans</x-primary-button>
                            </a>
                        </div>
                    </div>
                </x-box-dropdown>
            </div>

            <!-- Property Statistic -->
            <div class="w-full">
                <x-a-label class="text-lg font-bold">Property Statistic</x-a-label><br><br>
                <div class="grid gap-6 lg:grid-cols-1 xl:grid-cols-4">

                    <!-- Jumlah Booking -->
                    <x-box-dropdown name="Jumlah Booking">
                        <div class="mb-4 w-12 h-12 text-gray-700">
                            <x-icon.booking p="48" l="48" />
                        </div>
                        <div class="flex flex-col w-full gap-[15px]">
                            <x-a-label class="text-lg runcate">{{ $property->getBookings->count() }} Booking</x-a-label>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px]">
                                <div
                                    class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                    <div class="-rotate-90">
                                        <x-icon.arrow-right p="20" l="20" class="fill-green-700"></x-icon.arrow-right>
                                    </div>
                                    <a class="text-white">{{ $property->getPrecentageOfBookingLastWeek() }}%</a>
                                </div>
                                <x-a-label>than last week</x-a-label>
                            </div>
                        </div>
                    </x-box-dropdown>
    
                    <!-- Jumlah Guest -->
                    <x-box-dropdown name="Jumlah Residents">
                        <div class="mb-4 w-12 h-12 text-gray-700">
                            <x-icon.residents p="48" l="48" />
                        </div>
                        <div class="flex flex-col w-full gap-[15px]">
                            <x-a-label class="text-lg truncate">{{ $property->getResidents->count() }} Resident</x-a-label>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px]">
                                <div
                                    class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                    <div class="-rotate-90">
                                        <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                    </div>
                                    <a  class="text-white">{{ $property->getPrecentageOfResidentLastWeek() }}%</a>
                                </div>
                                <x-a-label>than last week</x-a-label>
                            </div>
                        </div>
                    </x-box-dropdown>

                    <!-- Jumlah Visit -->
                    <x-box-dropdown name="Jumlah Visit">
                        <div class="mb-4 w-12 h-12 text-gray-700">
                            <x-icon.eye p="48" l="48" />
                        </div>
                        <div class="flex flex-col w-full gap-[15px]">
                            <x-a-label class="text-lg runcate">{{ $property->getView->count() }} Users Visited</x-a-label>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px]">
                                <div
                                    class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                    <div class="-rotate-90">
                                        <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                    </div>
                                    <a  class="text-white">{{ $property->getPrecentageOfBookingLastWeek() }}%</a>
                                </div>
                                <x-a-label>than last week</x-a-label>
                            </div>
                        </div>
                    </x-box-dropdown>

                    <!-- Jumlah Favorite -->
                    <x-box-dropdown name="Jumlah Favorite">
                        <div class="mb-4 w-12 h-12 text-gray-700">
                            <x-icon.star p="48" l="48" />
                        </div>
                        <div class="flex flex-col w-full gap-[15px]">
                            <x-a-label class="text-lg runcate">{{ $property->getFavorite->count() }} Users Favorited</x-a-label>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px]">
                                <div
                                    class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                    <div class="-rotate-90">
                                        <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                    </div>
                                    <a  class="text-white">{{ $property->getPrecentageOfBookingLastWeek() }}%</a>
                                </div>
                                <x-a-label>than last week</x-a-label>
                            </div>
                        </div>
                    </x-box-dropdown>
                </div>
            </div>

             <!-- Rent Statistic -->
            <div class="w-full">
                <x-a-label class="text-lg font-bold">Rent Statistic</x-a-label><br><br>
                <!-- Statistic Most Profit -->
                <div class="flex xl:flex-row flex-col gap-[25px] w-full">
                    <x-box-dropdown class="w-full" name="5 Most Profit">
                        <div id="chart5MostProfit">
    
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown class="w-full" name="5 Most Booked">
                        <div id="chart5MostBooked">
    
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown class="w-full" name="5 Most Rated">
                        <div id="chart5MostRated">
    
                        </div>
                    </x-box-dropdown>
                </div>
            </div>

            <!-- Daftar Penghuni -->
            <div class="w-full">
                <x-a-label class="text-lg font-bold">Daftar Penghuni</x-a-label><br><br>
                <x-card.list-item id="guest-list" />
            </div>

            <!-- Modal untuk detail tagihan -->
            <div id="unpaid-modal"
                class="flex hidden fixed inset-0 justify-center items-center bg-black bg-opacity-50">
                <div class="p-6 w-full max-w-md bg-white rounded-lg">
                    <h2 class="mb-4 text-xl font-bold">Detail Tagihan Belum Dibayar</h2>
                    <ul class="pl-5 list-disc text-gray-700">
                        <li>Rafi Hidayat - Rp2.1M</li>
                        <li>Evan Pratama - Rp3.2M</li>
                    </ul>
                    <button onclick="closeModal('unpaid-modal')"
                        class="py-2 mt-4 w-full text-white bg-red-500 rounded">Tutup</button>
                </div>
            </div>

            <!-- Modal untuk detail kamar -->
            <div id="room-modal" class="flex hidden fixed inset-0 justify-center items-center bg-black bg-opacity-50">
                <div class="p-6 w-full max-w-md bg-white rounded-lg">
                    <h2 id="room-modal-title" class="mb-4 text-xl font-bold"></h2>
                    <p id="room-modal-content" class="text-gray-700"></p>
                    <button onclick="closeModal('room-modal')"
                        class="py-2 mt-4 w-full text-white bg-blue-500 rounded">Tutup</button>
                </div>
            </div>
        </div>
        {{-- <div class="md:w-[30%] w-[70%]">
            <x-box-dropdown  name="Rating">
                <div class="mb-4 w-12 h-12 text-gray-700">
                    <x-icon.iuran p="48" l="48"/>
                </div>
                <div class="flex w-full">
                    <x-a-label class="text-lg truncate">4.7</x-a-label>
                </div>
            </x-nav-dropdown>
        </div> --}}
    </div>
</x-app-layout>
