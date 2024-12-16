<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <body class="font-sans bg-gray-100">
        <!-- Header -->
        <header class="py-4 text-black">
          <div class="container flex justify-between items-center px-4 mx-auto">
            <h1 class="text-xl font-bold">Hello, Resident!</h1>
            
          </div>
        </header>
      
        <!-- Main Content -->
        <main class="container px-4 mx-auto mt-6">
          <!-- Overview Cards -->
          <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <!-- Card: Billing Status -->
            <div class="p-6 bg-white rounded-lg shadow-md">
              <h2 class="text-xl font-bold text-gray-700">Billing Status</h2>
              <p class="mt-4 text-4xl font-bold text-red-600">Unpaid</p>
              <p class="mt-2 text-gray-500">Due Date: December 15, 2024</p>
              <button class="px-4 py-2 mt-4 text-white bg-blue-600 rounded-lg hover:bg-blue-500">
                Pay Now
              </button>
            </div>
      
            <!-- Card: Cleaning Tasks -->
            <div class="p-6 bg-white rounded-lg shadow-md">
              <h2 class="text-xl font-bold text-gray-700">Cleaning Tasks</h2>
              <p class="mt-4 text-lg text-gray-700">Bathroom Cleaning</p>
              <p class="mt-2 text-gray-500">Deadline: December 12, 2024</p>
              <button class="px-4 py-2 mt-4 text-white bg-green-600 rounded-lg hover:bg-green-500">
                Mark as Done
              </button>
            </div>
      
            <!-- Card: Notifications -->
            <div class="p-6 bg-white rounded-lg shadow-md">
              <h2 class="text-xl font-bold text-gray-700">Notifications</h2>
              <ul class="mt-4 space-y-2 text-gray-600">
                <li>📢 Electrical maintenance on December 14, 2024.</li>
                <li>📢 Resident meeting: December 16, 2024, at 7:00 PM.</li>
              </ul>
            </div>
          </div>
      
          <!-- Statistics Section -->
          <div class="mt-8">
            <h2 class="text-2xl font-bold text-gray-700">Monthly Payment Statistics</h2>
            <div class="p-6 mt-4 bg-white rounded-lg shadow-md">
              <canvas id="paymentChart"></canvas>
            </div>
          </div>
        </main>
      
        <!-- Footer -->
        {{-- <footer class="py-4 mt-10 text-white bg-gray-800">
          <div class="container mx-auto text-center">
            <p>&copy; 2024 Kos Management. All rights reserved.</p>
          </div>
        </footer> --}}
      
        <!-- Script for Chart -->
        <script>
          document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('paymentChart').getContext('2d');
            const paymentData = {
              labels: ['January', 'February', 'March', 'April', 'May', 'June'],
              datasets: [{
                label: 'Monthly Payment (IDR)',
                data: [500000, 450000, 600000, 550000, 500000, 470000],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            };
      
            const config = {
              type: 'bar',
              data: paymentData,
              options: {
                responsive: true,
                plugins: {
                  legend: {
                    display: true,
                    position: 'top',
                  },
                  tooltip: {
                    callbacks: {
                      label: function (context) {
                        return `IDR ${context.raw.toLocaleString()}`;
                      }
                    }
                  }
                },
                scales: {
                  y: {
                    beginAtZero: true,
                    title: {
                      display: true,
                      text: 'Amount (IDR)'
                    }
                  },
                  x: {
                    title: {
                      display: true,
                      text: 'Month'
                    }
                  }
                }
              }
            };
      
            new Chart(ctx, config);
          });
        </script>
      </body>
</x-app-layout>
