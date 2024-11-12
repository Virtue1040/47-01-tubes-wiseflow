<!-- resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wise Flow - Landing Page</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('sweetalert::alert')
    @vite ('resources/css/app.css')
</head>

<body class= "bg-[#5E93DA]">
    <!-- Header -->
    <header class="flex justify-center items-center px-10 mt-4 bg-[#5E93DA] xl:justify-between h-[83px]">
        <!-- Logo -->
        <x-icon.wiseflow-text class="hidden pl-2 xl:flex"></x-icon.wiseflow-text>
        
        <!-- Navbar -->
        <div class="flex gap-6 items-center font-bold text-white">
            <p class="text-2xl cursor-pointer p-nav hover:underline">Home</p>
            <p class="text-2xl cursor-pointer p-nav hover:underline">About</p>
            <p class="text-2xl cursor-pointer p-nav hover:underline">Service</p>
            <p class="text-2xl cursor-pointer p-nav hover:underline">Help</p>
            <div class="flex">
                <a href="{{ route('login') }}" >
                    <div class="rounded-l-2xl p-[5px] px-[25px] bg-white hover:bg-gray-400 hover:shadow-xl">
                        <p class="text-black">Login</p>
                    </div>
                </a>
                <a href="{{ route('register') }}">
                    <div class="rounded-r-2xl p-[5px] px-[25px] bg-gray-200 hover:bg-gray-400 hover:shadow-xl">
                        <p class="text-black">Register</p>
                    </div>
                </a>
            </div>
        </div>
    </header>

    <section class="flex flex-col items-center py-24 text-center bg-[#5E93DA] px-[10px]">
        <h1 class="mb-4 text-4xl font-bold text-white">We Provide Management Service for your Property!</h1>
        <p class="pb-10 text-lg text-white">"An application providing management services for boarding houses and rental properties."</p>
    </section>
    
    <!-- Main Section -->
    <section class="flex justify-center py-10 bg-white">
        <div class="grid grid-cols-1 gap-8 max-w-4xl md:grid-cols-2 px-[25px]">
            <!-- Cards -->
            <div class="p-10 bg-white rounded-lg shadow-lg">
                <x-svg.rumah2></x-svg.rumah2>
                <h1 class="text-2xl font-medium">Tenant Management</h1>
                <p class="text-justify">We simplify tenant management for property owners by providing a centralized platform to manage leases, payments, and tenant communications.</p>
            </div>

            <div class="p-10 bg-white rounded-lg shadow-lg">
                <img src="{{ asset("img/financial1.png  ") }}" class=""></img>
                <br>
                <h1 class="text-2xl font-medium">Financial Reporting</h1>
                <p class="text-justify">Gain insights into your property's financial health with easy-to-read reports on rent collection, expenses, and profit summaries.</p>
            </div>

            <div class="p-10 bg-white rounded-lg shadow-lg">
                <x-svg.multi></x-svg.multi>
                <br>
                <h1 class="text-2xl font-medium">Multi-Property Dashboard</h1>
                <p class="text-justify">Manage multiple properties at once with a centralized dashboard, allowing you to view and manage all properties in one view.</p>
            </div>
            
            <div class="p-10 bg-white rounded-lg shadow-lg">
                <x-svg.supportcenter></x-svg.supportcenter>
                <h1 class="text-2xl font-medium">24/7 Support Center</h1>
                <p class="text-justify">24-hour support service to handle tenant or property owner requests, ensuring all issues are handled in a timely, fast and reliable manner</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-6 px-16 bg-[#5E93DA]">
    <div class="container flex flex-col justify-between mx-auto md:flex-row gap-[15px]">  
        <div>
            <x-icon.wiseflow-text class="pl-2"></x-icon.wiseflow-text>            
        </div>
        
        <div class="flex flex-col text-2xl text-white">
            <a href="#" class="hover:underline">Home</a>
            <a href="#" class="hover:underline">Contact us</a>
            <a href="#" class="hover:underline">Privacy Policy</a>
            <a href="#" class="hover:underline">Our mission</a>
        </div>
        <br>
        <div class="flex flex-row gap-4 justify-center text-2xl text-black">
            <a href="#" class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                <x-icon.facebook-black p="50" l="50"></x-icon.facebook-black>
            </a>
            <a href="#" class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                <x-icon.twitter p="50" l="50"></x-icon.twitter>
            </a>
            <a href="#" class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                <x-icon.instagram p="50" l="50"></x-icon.instagram>
            </a>
            <a href="#" class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                <x-icon.linkedin p="50" l="50"></x-icon.linkedin>
            </a>
        </div>

    </div>  
    </footer>
</body>
</html>
