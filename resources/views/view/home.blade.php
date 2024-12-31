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

            <div class="mt-6">
                {{-- <h2 class="text-2xl font-bold text-gray-700">Monthly Payment Statistics</h2> --}}
                <div class="">
                  <img src="{{ asset('img/iklan AI.webp  ') }}" class="rounded-md"></img>
                    {{-- <canvas id="paymentChart"></canvas> --}}
                </div>
            </div>

            <div class="flex justify-center py-10">
                <div class="grid grid-cols gap-8 md:grid-cols-4 px-[5px]">
                    <div>
                        <img src="{{ asset('img/house-thailand.jpg  ') }}" class=""></img>
                    </div>
        
                    <div>
                        <img src="{{ asset('img/hause-japan.jpg  ') }}" class=""></img>
                    </div>
        
                    <div>
                        <img src="{{ asset('img/hause-europ.jpg  ') }}" class=""></img>
                    </div>
        
                    <div>
                        <img src="{{ asset('img/hause-esthethic.jpg  ') }}" class=""></img>
                    </div>
        
                </div>
            </div>

            <div class="flex flex-row gap-8 mt-8">
                <x-a-label class="font-bold !text-black text-2xl">Popular of the week</x-a-label>
                {{-- <x-a-label class="" id="itemResult !text-gray-400">0 Result</x-a-label> --}}
            </div>
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 gap-4 mt-4 md:grid-cols-4">
                <!-- Card: Billing Status -->
                <div class="p-3 bg-white rounded-xl shadow-md">
                    <img src="{{ asset('img/house-thailand.jpg  ') }}" class="rounded-md"></img>
                    <br>
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-gray-700">Hotel Horison</h2>
                        <h2 class="text-xl font-bold text-gray-700">IDR 2000,000</h2>
                    </div>
                    <p class="mt-2 text-gray-500">Bandung,Jawa Barat</p>
                </div>

                <!-- Card: Cleaning Tasks -->
                <div class="p-3 bg-white rounded-xl shadow-md">
                    <img src="{{ asset('img/hause-japan.jpg  ') }}" class="rounded-md"></img>
                    <br>
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-gray-700">Hotel Horison</h2>
                        <h2 class="text-xl font-bold text-gray-700">IDR 2000,000</h2>
                    </div>
                    <p class="mt-2 text-gray-500">Bandung,Jawa Barat</p>
                </div>


                <!-- Card: Notifications -->
                <div class="p-3 bg-white rounded-xl shadow-md">
                    <img src="{{ asset('img/hause-europ.jpg  ') }}" class="rounded-md"></img>
                    <br>
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-gray-700">Hotel Horison</h2>
                        <h2 class="text-xl font-bold text-gray-700">IDR 2000,000</h2>
                    </div>
                    <p class="mt-2 text-gray-500">Bandung,Jawa Barat</p>
                </div>


                <div class="p-3 bg-white rounded-xl shadow-md">
                    <img src="{{ asset('img/hause-esthethic.jpg  ') }}" class="rounded-md"></img>
                    <br>
                    <div class="flex justify-between">
                        <h2 class="text-xl font-bold text-gray-700">Hotel Horison</h2>
                        <h2 class="text-xl font-bold text-gray-700">IDR 2000,000</h2>
                    </div>
                    <p class="mt-2 text-gray-500">Bandung,Jawa Barat</p>
                </div>
            </div>

            <!-- Statistics Section -->

        </main>

    </body>
</x-app-layout>
