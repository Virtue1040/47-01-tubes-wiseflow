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

<body class= "bg-[#ffffff]">
    <!-- Header -->
    <header
        class="flex justify-center flex-col items-center px-10 bg-[url('/public/img/modern-building.jpg')] bg-cover bg-center xl:justify-between h-screen">
        <div class="absolute inset-0 bg-black bg-opacity-40"></div>
        <!-- Logo -->
        <div class="flex z-50 flex-row justify-center">
            <x-icon.wiseflow-text class="hidden pr-20 pl-2 xl:flex"></x-icon.wiseflow-text>

            <!-- Navbar -->
            <div class="flex gap-10 items-center font-semibold text-white">
                <p class="text-2xl cursor-pointer p-nav hover:underline">Home</p>
                <p class="text-2xl cursor-pointer p-nav hover:underline">About</p>
                <p class="text-2xl cursor-pointer p-nav hover:underline">Service</p>
                <p class="text-2xl cursor-pointer p-nav hover:underline">Help</p>

                <div class="flex">
                    <a href="{{ route('login') }}">
                        <div
                            class="rounded-lg px-6 py-2 text-white hover:text-white bg-black hover:bg-[#5E93DA] hover:shadow-xl hover:text-white text-[15px]">
                            <p class="">Log in</p>
                        </div>
                    </a>

                </div>

            </div>
        </div>

        <div class="flex z-50 flex-col justify-end px-[10px] pb-[20%]">
            {{-- <img src="{{ asset("img/modern-building.jpg ") }}" class="max-w-full h-screen bg-center bg-cover"></img> --}}
            <h1 class="mb-4 text-5xl font-bold text-white">We Provide Management Service for your Property!</h1>
            <p class="pb-10 text-2xl text-white">"An application providing management services for boarding houses and
                rental properties."</p>
            <div class="flex">
                <a href="{{ route('register') }}">
                    <div
                        class="rounded-xl p-[10px] px-[25px] text-[#5E93DA] hover:text-white bg-white hover:bg-[#5E93DA] hover:shadow-xl hover:text-white text-xl  ">
                        <p class="">Get started</p>
                    </div>
                </a>
            </div>
        </div>

    </header>

    {{-- about --}}
    <div class="flex flex-row gap-10 justify-center p-10 mt-20 justify">

        {{-- <div>
            <img class="w-[300px] rounded-xl" src="{{ asset('img/rent-hause.jpg') }}" alt="">
        </div> --}}

        <div class="flex flex-row justify justify-center gap-20 pl-[30px] ">
            <div>
                <h1 class="text-xl">About us</h1>
                <h2 class="text-6xl font-semibold">What is WiseFlow?</h2>
            </div>

            <div>
                <p class="w-[600px] text-gray-700">Wise Flow is an innovative platform designed for boarding house or
                    rental owners to be
                    able to manage their property more easily and efficiently.
                    This application aims to help automate various aspects of boarding house management, such as payment
                    tracking, rental management, facilities management, and regular property maintenance.
                    With Wise Flow, boarding house owners can not only save time but also optimize daily operations, so
                    they
                    can provide better services to tenants and ensure their properties are well maintained.</p>

                <br>
                <hr>
            </div>
        </div>

    </div>

    <div class="flex justify-center py-10">
        <div class="grid grid-cols gap-8 md:grid-cols-4 px-[25px]">
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



    <div class="mt-20 bg-gray-50">
        <div class="p-6 mx-auto max-w-6xl">
            <div class="mb-12 text-center">

            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Left Image -->
                <div class="flex flex-col justify-center items-center">

                    <h1 class="text-4xl font-semibold text-gray-800">Find Your Dream Residance Here</h1>
                    <p class="mt-4 text-gray-600">You can see for yourself how the wiseflow offers beautiful and
                        comfortable housing for you and your family.
                        See photos of the house, environment, and facilities we provide here.</p>
                    <br>
                    <img class="rounded-lg shadow-lg" src="{{ asset('img/rent-hause.jpg') }}" alt="Decorative Interior">

                </div>

                <!-- Right Content -->
                <div class="col-span-2">
                    <img class="rounded-lg shadow-lg w-[800px]" src="{{ asset('img/kontrakan-claster.jpg') }}"
                        alt="Living Room">
                    <br>
                    <img class="rounded-lg shadow-lg w-[400px]"
                        src="{{ asset('img/kontrakan-minimalist.jpg') }}"alt="Modern Stairs">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Section -->
    <div class="bg-[#f5f7f7]">
        <h1 class="flex justify-center pt-10 text-5xl">Our services</h1>
        <section class="flex justify-center">
            <div class="grid grid-cols gap-1 md:grid-cols-4 px-[25px] pb-11">
                <!-- Cards -->
                <div class="p-5 w-[300px]">
                    <img src="{{ asset('img/Tenant Management.jpg  ') }}" class="object-cover aspect-[3/4]  "></img>
                    <br>
                    <h1 class="text-2xl font-medium">Tenant Management</h1>
                    <p class="text-justify text-gray-600">We simplify tenant management for property owners by providing a centralized
                        platform to manage leases, payments, and tenant communications.</p>
                </div>

                <div class="p-5 w-[300px]">
                    <img src="{{ asset('img/Financial Reporting.jpg') }}" class="object-cover aspect-[3/4]  "></img>
                    <br>
                    <h1 class="text-2xl font-medium">Financial Reporting</h1>
                    <p class="text-justify text-gray-600">Gain insights into your property's financial health with easy-to-read
                        reports on rent collection, expenses, and profit summaries.</p>
                </div>

                <div class="p-5 w-[300px]">
                    <img src="{{ asset('img/Multi-Property Dashboard.jpg') }}" class=" object-cover aspect-[3/4]  "></img>
                    <br>
                    <h1 class="text-2xl font-medium">Multi-Property Dashboard</h1>
                    <p class="text-justify text-gray-600">Manage multiple properties at once with a centralized dashboard, allowing
                        you to view and manage all properties in one view.</p>
                </div>

                <div class="p-5 w-[300px]">
                    <img src="{{ asset('img/247 Support Center.jpg') }}" class="object-cover aspect-[3/4] "></img>
                    <br>
                    <h1 class="text-2xl font-medium">24/7 Support Center</h1>
                    <p class="text-justify text-gray-600">24-hour support service to handle tenant or property owner requests,
                        ensuring all issues are handled in a timely, fast and reliable manner</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="p-16 bg-[#18181B]">
        <div class="container flex flex-col justify-between mx-auto md:flex-row gap-[15px]">

            <div class="flex flex-col justify-center">
                <h1 class="pl-4 mb-10 text-2xl font-bold text-white">COMPANY NAME</h1>
                <div>
                    <x-icon.wiseflow-text class="pl-2"></x-icon.wiseflow-text>
                </div>

                <div class="pl-4 text-white flex gap-[5px] flex-col">
                    <h1 class="text-2xl">Contact</h1>
                    <p>+6212-2222-3333</p>
                    <p>Wiseflow@gmail.com</p>
                    <p>Bojongsoang,Bandung,JawaBarat</p>
                </div>

            </div>

            <div class="flex flex-col text-xl text-white gap-[10px]">
                <h1 class="pl-4 mb-10 text-2xl font-bold text-white">NAVIGATION</h1>
                <a href="#" class="pl-4 hover:underline">Home</a>
                <a href="#" class="pl-4 hover:underline">Contact us</a>
                <a href="#" class="pl-4 hover:underline">Privacy Policy</a>
                <a href="#" class="pl-4 hover:underline">Our mission</a>
            </div>
            <br>
            <div class="flex flex-col text-xl text-white">
                <h1 class="pl-4 mb-10 text-2xl font-bold text-white">SOCIAL MEDIA</h1>
                <div class="flex flex-row gap-[10px] justify-center text-2xl text-white">

                    <a href="#"
                        class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                        <x-icon.facebook-black p="50" l="50" color="#FFFFFF"></x-icon.facebook-black>
                    </a>
                    <a href="#"
                        class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                        <x-icon.twitter p="50" l="50" color="#FFFFFF"></x-icon.twitter>
                    </a>
                    <a href="#"
                        class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                        <x-icon.instagram p="50" l="50" color="#FFFFFF"></x-icon.instagram>
                    </a>
                    <a href="#"
                        class="transition-all transform hover:underline hover:scale-110 hover:shadow-white">
                        <x-icon.linkedin p="50" l="50" color="#FFFFFF"></x-icon.linkedin>
                    </a>
                </div>
            </div>

        </div>
        <br>

    </footer>
    <footer class="p-4 bg-[#101010] flex justify-center items-center">
        <p class="text-white">© 2024 Copyright WiseFlow</p>
    </footer>
</body>

</html>
