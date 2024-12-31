@section('title', '- Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <script>
        $(document).ready(function() {
            
            // var options = {
            //     series: [44, 55, 13, 43, 22],
            //     chart: {
            //         width: '100%',
            //         type: 'pie',
            //         background: 'transparent'
            //     },
            //     theme: {
            //         mode: isDark ? 'dark' : 'light',
            //     },
            //     labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
            //     responsive: [{
            //         breakpoint: 480,
            //         options: {
            //             chart: {
            //                 width: 200
            //             },
            //             legend: {
            //                 position: 'bottom'
            //             }
            //         }
            //     }]
            // };

            // var chart = new ApexCharts(document.querySelector("#chart"), options);
            // chart.render();

        })
    </script>
    <div class="flex gap-[25px] p-6 flex-col lg:flex-row">
        <div class="flex flex-col gap-[25px] w-full">
            <div class="grid gap-6 lg:grid-cols-1 xl:grid-cols-4">
                <!-- Jumlah Property -->
                <x-box-dropdown name="Jumlah Property">
                    <div class="mb-4 w-12 h-12 text-gray-700">
                        <x-icon.booking p="48" l="48" />
                    </div>
                    <div class="flex flex-col w-full gap-[15px]">
                        <x-a-label class="text-lg runcate">{{ $property['object']->count() }} Property</x-a-label>
                        <hr class="dark:border-[#464649] border-gray-200 w-full">
                        <div class="flex gap-[10px]">
                            <div
                                class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                <div class="-rotate-90">
                                    <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                </div>
                                <a>{{ $property['percent'] }}%</a>
                            </div>
                            <x-a-label>than last week</x-a-label>
                        </div>
                    </div>
                    </x-nav-dropdown>
                    <!-- Jumlah User -->
                    <x-box-dropdown name="Jumlah User">
                        <div class="mb-4 w-12 h-12 text-gray-700">
                            <x-icon.user p="48" l="48" />
                        </div>
                        <div class="flex flex-col w-full gap-[15px]">
                            <x-a-label class="text-lg runcate">{{ $user['object']->count() }} User</x-a-label>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px]">
                                <div
                                    class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                    <div class="-rotate-90">
                                        <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                    </div>
                                    <a>{{ $user['percent'] }}%</a>
                                </div>
                                <x-a-label>than last week</x-a-label>
                            </div>
                        </div>
                        </x-nav-dropdown>
                        <!-- Jumlah Owner -->
                        <x-box-dropdown name="Jumlah Owner">
                            <div class="mb-4 w-12 h-12 text-gray-700">
                                <x-icon.owner p="48" l="48" />
                            </div>
                            <div class="flex flex-col w-full gap-[15px]">
                                <x-a-label class="text-lg runcate">{{ $owner['object']->count() }} Owner</x-a-label>
                                <hr class="dark:border-[#464649] border-gray-200 w-full">
                                <div class="flex gap-[10px]">
                                    <div
                                        class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                        <div class="-rotate-90">
                                            <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                        </div>
                                        <a>{{ $property['percent'] }}%</a>
                                    </div>
                                    <x-a-label>than last week</x-a-label>
                                </div>
                            </div>
                            </x-nav-dropdown>
                            <!-- Jumlah Resident -->
                            <x-box-dropdown name="Jumlah Resident">
                                <div class="mb-4 w-12 h-12 text-gray-700">
                                    <x-icon.residents p="48" l="48" />
                                </div>
                                <div class="flex flex-col w-full gap-[15px]">
                                    <x-a-label class="text-lg runcate">{{ $resident['object']->count() }}Resident</x-a-label>
                                    <hr class="dark:border-[#464649] border-gray-200 w-full">
                                    <div class="flex gap-[10px]">
                                        <div
                                            class="flex gap-[5px] bg-[#5E93DA] w-fit text-xs p-[3px] rounded-full px-[5px] max-h-[25px] items-center">
                                            <div class="-rotate-90">
                                                <x-icon.arrow-right p="20" l="20"></x-icon.arrow-right>
                                            </div>
                                            <a>{{ $resident['percent'] }}%</a>
                                        </div>
                                        <x-a-label>than last week</x-a-label>
                                    </div>
                                </div>
                            </x-nav-dropdown>
                            <x-box-dropdown name="Property Category Statistic">
                                <div id="chart">

                                </div>
                            </x-box-dropdown>
            </div>
        </div>
    </div>
   


</x-app-layout>
