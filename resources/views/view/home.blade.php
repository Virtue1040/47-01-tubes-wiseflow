@section('title', '- Home')
<x-app-layout>
    <script src="{{ asset('js/carousel.js') }}"></script>
    <style>
        .carousel{
            padding-top: 20px;
            width: 357px;
            height: 50px;
            position: relative;
        }.carousel ul{
            position: relative;
            list-style: none;
            list-style-type: none;
            margin: 0;
            height: 50px;
            padding: 0;
        }.carousel ul li{
            position: absolute;
            height: 25px;
            width: 50px;
            float: left;
            margin-right: 1px;
            background: #f2f2f2;
            text-align: center;
            padding-top: 25px;
        }

        .News-navButton {
            border-radius: 100%;
            width: 35px;
            height: 35px;
            background-color: white;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
            box-shadow: 0 5px 15px rgb(145, 145, 145);
            cursor: pointer;
        }
        .centerHV {
            width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;
        }
        .News-container {

            width: 95%;
            height: 170px;
            display: flex;
            margin: auto auto auto 29px;
            padding-left: 5px;
            padding-right: 0;
            gap: 15px;
            position: relative;

        }

        #right-arrow {
            right: 15px;
        }

        #left-arrow {
            left: 15px;
        }

        .rotate180 {
            transform: rotate(180deg);
        }

        .navBar {
            width: 100%;
            height:7px;
            margin-top: 9px;
            display: flex;
            padding-left: 35px;
            gap: 10px;
        }

        .News-container-box {
            background-color: rgb(250,250,250);
            border-radius: 10px;
            width: 343px;
            height: 140px;
            margin-top: 15px;
            box-shadow: 0 0 5px rgb(145, 145, 145);
            transition: transform 0.3s;
            cursor: pointer;
            flex-shrink: 0;
            overflow-y:hidden;
        }

        .News-container-box:hover {
            transform: translateY(-10px);
        }

        .navBar-dots {
            border-radius: 100%;
            height: 100%;
            background-color: rgba(8, 56, 112, 0.482);;
            width: 7px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .dothover:hover {
            background-color: rgba(8, 56, 112, 0.882);
        }
    </style>
    <script>
        $(document).ready(function () {
            loadCarousel("#carousel", "#carouselNavigation", "#left-arrow", "#right-arrow", [
                4,
                "{{ asset('img/carousel/home') . '/' }}",
            ]);
        })
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <body class="font-sans bg-gray-100">

        <!-- Main Content -->
        <main class="container px-4 mx-auto mt-2">

            <div class="flex flex-row px-6 mt-8">
                <x-a-label class="text-2xl !text-white font-bold">Hallo!, {{ Auth::user()->getRoleNames()[0] }}</x-a-label>
                {{-- <x-a-label class="" id="itemResult !text-gray-400">0 Result</x-a-label> --}}
            </div>

            <div class="mt-6 w-full h-[300px]">
                {{-- <h2 class="text-2xl font-bold text-gray-700">Monthly Payment Statistics</h2> --}}
                <div class="">
                  <img src="{{ asset('img/iklan AI.webp') }}" class="rounded-xl"></img>
                    {{-- <canvas id="paymentChart"></canvas> --}}
                </div>
            </div>

            <div class="w-full backdrop-blur-[30px] py-1">

                {{-- corousel --}}
                <div class="flex flex-row px-6 mt-8">
                    <x-a-label class="text-2xl !text-white font-bold">Rental Recommendations</x-a-label>
                    {{-- <x-a-label class="" id="itemResult !text-gray-400">0 Result</x-a-label> --}}
                </div>
                <div class="mt-2" style="position: relative; height: 170px; overflow-x: hidden;">
                    <div id="left-arrow" class="News-navButton">
                        <div class="centerHV">
                            <img src="{{ asset("img/leftArrow.png") }}" alt="left Arrow" width="25px" height="25px" >
                        </div>
                    </div>
                    <div id="right-arrow" class="News-navButton">
                        <div class="centerHV">
                            <img class="rotate180" src="{{ asset("img/leftArrow.png") }}" alt="rotated 180 left arrow" width="25px" height="25px" >
                        </div>
                    </div>
                    <section id="carousel" class="News-container">
                    </section>
                </div>
                <div id="carouselNavigation" class="navBar">
                </div>
    
                <div class="flex flex-row gap-[5px] items-center px-6 mt-6">
                    <x-a-label class="text-2xl !text-white font-bold">Popular of the week</x-a-label>
                    <a href="{{ route('findproperty') }}"
                        class="bg-[#5E93DA] ml-2 py-[1px] text-sm px-[10px] text-white w-auto rounded-lg cursor-pointer">
                        Show More
                    </a>
                    {{-- <x-a-label class="" id="itemResult !text-gray-400">0 Result</x-a-label> --}}
                </div>
                <!-- Overview Cards -->
                <div class="grid grid-cols-1 gap-4 px-6 mt-4 md:grid-cols-4">
                    @foreach ($property as $prop)
                        <div onclick="window.location.href='{{ route('property.profile', $prop->id_property) }}'" class="cursor-pointer p-3 bg-white dark:bg-[#18181B] rounded-xl shadow-md">
                            <div class="flex justify-center items-center w-full h-auto">
                                <img src="{{ asset('storage/') }}/{{ $prop->cover }}" onerror="this.src='{{ asset('img/placeholder.png') }}'" class="rounded-md h-[200px]"></img>
                            </div>
                            <br>
                            <div class="flex justify-between">
                                <x-a-label class="text-xl font-bold">{{ $prop->property_name }}</x-a-label>
                                <x-a-label class="text-xl font-bold">IDR    {{ $prop->min_price }}</x-a-label>
                            </div>
                            <p class="mt-2 text-gray-500">{{ $prop->location }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

    </body>
</x-app-layout>
