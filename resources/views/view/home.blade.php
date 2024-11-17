<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <body class="bg-gray-100">
        <div class="flex flex-col min-h-screen">
            <!-- Main Content -->
            <main class="grid flex-grow grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:grid-cols-3">
                <!-- Quick Summary -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <div class="p-4 bg-white rounded-lg shadow">
                        <h2 class="mb-4 text-lg font-bold">Quick Summary</h2>
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="text-left bg-gray-100">
                                    <th class="px-4 py-2">Item</th>
                                    <th class="px-4 py-2">Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-4 py-2">Total Rooms</td>
                                    <td class="px-4 py-2">50</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2">Available Rooms</td>
                                    <td class="px-4 py-2">20</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2">Occupied Rooms</td>
                                    <td class="px-4 py-2">25</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2">Under Maintenance</td>
                                    <td class="px-4 py-2">5</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-4 py-2">Total Rent Collected</td>
                                    <td class="px-4 py-2">$10,000</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2">Total Expenses</td>
                                    <td class="px-4 py-2">$3,000</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Occupancy Trends Chart -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-bold">Occupancy Trends</h2>
                    <canvas id="occupancyTrendsChart" class="mt-4"></canvas>
                </div>

                <!-- Rent Collection Progress Chart -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-bold">Rent Collection Progress</h2>
                    <canvas id="rentCollectionChart" class="mt-4"></canvas>
                </div>

                <!-- Important Notifications -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-bold">Important Notifications</h2>
                    <ul>
                        <li>Upcoming Rent Due: 15th of the month</li>
                        <li>Pending Maintenance Requests: 3</li>
                    </ul>
                </div>

                <!-- Recent Activity -->
                <div class="p-4 bg-white rounded-lg shadow">
                    <h2 class="text-lg font-bold">Recent Activity</h2>
                    <ul>
                        <li>Tenant Payment Received: $500</li>
                        <li>Maintenance Completed: Room 101</li>
                    </ul>
                </div>

                <!-- Quick Actions -->
                <div class="flex flex-col justify-center items-center p-4 bg-white rounded-lg shadow">
                    <h2 class="mb-4 text-lg font-bold">Quick Actions</h2>
                    <button class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">Add Room</button>
                    <button class="px-4 py-2 mt-2 text-white bg-blue-500 rounded">Add Tenant</button>
                </div>
                
            </main>
        </div>

        <!-- Scripts for Chart.js -->
        <script>
            $(document).ready(function() {
                // Occupancy Trends Chart
                const occupancyData = {
                    labels: ['January', 'February', 'March', 'April', 'May', 'June'],
                    datasets: [{
                        label: 'Occupancy Rate (%)',
                        data: [70, 75, 80, 85, 90, 95],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: true,
                    }]
                };
                const occupancyConfig = {
                    type: 'line',
                    data: occupancyData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100
                            },
                        },
                    },
                };
                new Chart($('#occupancyTrendsChart'), occupancyConfig);

                // Rent Collection Progress Chart
                const rentData = {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [{
                        label: 'Rent Collected ($)',
                        data: [2000, 4000, 7000, 10000],
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                    }]
                };
                const rentConfig = {
                    type: 'bar',
                    data: rentData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            },
                        },
                    },
                };
                new Chart($('#rentCollectionChart'), rentConfig);
            });
        </script>
    </body>
</x-app-layout>
