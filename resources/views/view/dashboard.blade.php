@section('title', '- Dashboard')

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <script>
        $(document).ready(function() {
            var options = {
                series: [44, 55, 13, 43, 22],
                chart: {
                    width: '100%',
                    type: 'pie',
                    background: 'transparent'
                },
                theme: {
                    mode: isDark ? 'dark' : 'light',
                },
                labels: ['Team A', 'Team B', 'Team C', 'Team D', 'Team E'],
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

            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();

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
    {{-- <main class="grid flex-grow grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:grid-cols-3">
        <!-- Overview Section -->
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="mb-4 text-lg font-bold">Room Status Overview</h2>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="text-left bg-gray-100">
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Count</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-2">Total Rooms</td>
                        <td class="px-4 py-2">50</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">Available</td>
                        <td class="px-4 py-2">20</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">Occupied</td>
                        <td class="px-4 py-2">25</td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-2">Under Maintenance</td>
                        <td class="px-4 py-2">5</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 font-bold">Rooms Occupied (%)</td>
                        <td class="px-4 py-2 font-bold">80%</td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Tenant Overview</h2>
            <p>Active Tenants: 30</p>
            <p>Recent Move-ins: 5</p>
            <p>Recent Move-outs: 2</p>
        </div>

        <!-- Financial Summary Section -->
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Income Overview</h2>
                <div>
                    <canvas id="pieChart"></canvas>
                    <script>
                        $(document).ready(function() {
                          // Data untuk pie chart
                          const data = {
                            labels: ['Category A', 'Category B', 'Category C'],
                            datasets: [{
                              label: 'Dataset 1',
                              data: [30, 50, 20], // Data persentase
                              backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'], // Warna-warna
                              hoverOffset: 4
                            }]
                          };
                      
                          // Konfigurasi chart
                          const config = {
                            type: 'pie',
                            data: data,
                            options: {
                              responsive: true,
                              plugins: {
                                legend: {
                                  position: 'top',
                                },
                                tooltip: {
                                  enabled: true,
                                }
                              }
                            },
                          };
                      
                          // Render chart ke canvas
                          const ctx = $('#pieChart')[0].getContext('2d');
                          new Chart(ctx, config);
                        });
                      </script>
                      
                </div>
                <br>
            <p>Total Rent Collected: $10,000</p>
            <p>Outstanding Payments: $1,000</p>
        </div>
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Expense Overview</h2>
            <p>Monthly Expenses: $3,000</p>
            <p>Utilities: $1,000</p>
            <p>Repairs: $500</p>
        </div>

        <!-- Notifications and Recent Activity -->
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Key Notifications</h2>
            <ul>
                <li>Upcoming Rent Due: 15th of the month</li>
                <li>Pending Maintenance Requests: 3</li>
            </ul>
        </div>
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Recent Activity</h2>
            <ul>
                <li>Tenant Payment Received: $500</li>
                <li>Maintenance Completed: Room 101</li>
            </ul>
        </div>

        <!-- Visual Analytics Section -->
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Occupancy Trends</h2>
            <canvas id="occupancyTrendsChart" class="mt-4"></canvas>
        </div>
        <div class="p-4 bg-white rounded-lg shadow">
            <h2 class="text-lg font-bold">Rent Collection Progress</h2>
            <canvas id="rentCollectionChart" class="mt-4"></canvas>
        </div>

        <!-- Quick Actions -->
        <div class="flex flex-col justify-center items-center p-4 bg-white rounded-lg shadow">
            <h2 class="mb-4 text-lg font-bold">Quick Actions</h2>
            <button class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">Add</button>
        </div>
        

                <script>
                    $(document).ready(function () {
                        // Data for Occupancy Trends
                        const occupancyData = {
                            labels: ['January', 'February', 'March', 'April', 'May', 'June'], // Example months
                            datasets: [{
                                label: 'Occupancy Rate (%)',
                                data: [70, 75, 80, 85, 90, 95], // Example data
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1,
                                fill: true,
                            }]
                        };
                    
                        // Config for Occupancy Trends Chart
                        const occupancyConfig = {
                            type: 'line',
                            data: occupancyData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: true },
                                },
                                scales: {
                                    y: { beginAtZero: true, max: 100 },
                                },
                            },
                        };
                    
                        // Render Occupancy Trends Chart
                        new Chart($('#occupancyTrendsChart'), occupancyConfig);
                    
                        // Data for Rent Collection Progress
                        const rentData = {
                            labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'], // Example weeks
                            datasets: [{
                                label: 'Rent Collected ($)',
                                data: [2000, 4000, 7000, 10000], // Example data
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            }]
                        };
                    
                        // Config for Rent Collection Progress Chart
                        const rentConfig = {
                            type: 'bar',
                            data: rentData,
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: { display: true },
                                },
                                scales: {
                                    y: { beginAtZero: true },
                                },
                            },
                        };
                    
                        // Render Rent Collection Progress Chart
                        new Chart($('#rentCollectionChart'), rentConfig);
                    });
                    </script> --}}


</x-app-layout>
