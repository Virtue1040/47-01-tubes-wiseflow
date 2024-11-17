<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <main class="grid flex-grow grid-cols-1 gap-4 p-4 md:grid-cols-2 lg:grid-cols-3">
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
                    </script>
                    
                
</x-app-layout>
