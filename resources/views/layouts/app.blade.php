<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- Jquery -->
        <x-default-global-js></x-default-global-js>
        <!-- Scripts -->
        <script src={{ asset("js/modal_create.js")}}></script>
        <script src={{ asset("js/handle_upload.js")}}></script>
        <script src={{ asset("js/handle_drag.js")}}></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @include('sweetalert::alert')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end',
                iconColor: 'white',
                customClass: {
                    popup: 'colored-toast',
                },
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
            })

            $(document).ready(function() {
                @if (session('alert'))
                    Toast.fire({
                        icon: '{{ session('alert')['type'] }}',
                        title: '{{ session('alert')['message'] }}',
                    });
                @endif
                
            })
            
            
        </script>
    </head>

    <body x-data="{ open: false, openSidebar: true }" class="relative h-auto font-sans antialiased">
 
        <div class="flex h-auto bg-gray-100 dark:bg-gray-900">
            <!-- Layout Navigation -->
            @include("layouts.navigation")
            <div class="flex flex-col w-full h-auto">
                <!-- Page Heading -->
                @isset($header)
                <header class="flex relative bg-white dark:bg-gray-800">
                    <!-- Sidebar Humberger -->
                    <div class="hidden items-center ml-6 -me-2 md:flex">
                        <button @click="openSidebar = ! openSidebar" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': openSidebar, 'inline-flex': ! openSidebar }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! openSidebar, 'inline-flex': openSidebar }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="px-4 py-6 w-full sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                    <div class="flex float-right justify-end mr-5 w-full">
                        <div class="hidden float-right md:flex md:items-center md:gap-[5px]">
                            <x-text-input id="search" style="" class="block w-[250px] h-[50%] bg-gray-200" placeholder="Search"  type="text" name="search"
                                      />
                            <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 bg-white rounded-md border border-transparent transition duration-150 ease-in-out dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <x-icon.notification p=20 l=20></x-icon.notification>
                            </button>
                        </div>
                        <!-- Settings Dropdown -->
                        <div class="hidden float-right md:flex md:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 bg-white rounded-md border border-transparent transition duration-150 ease-in-out dark:text-gray-400 dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <div>{{ Auth::user()->contactInformation->first_name }} {{ Auth::user()->contactInformation->last_name }}</div>
                                        
                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>
            
                                <x-slot name="content">
                                    <x-dropdown-link :href="route('profile.edit')">
                                        {{ __('Profile') }}
                                    </x-dropdown-link>
            
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
            
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 md:hidden">
                            <button @click="open = ! open" class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                </header>
                
            @endisset

            <!-- Page Content -->
            <main class="flex flex-col justify-between h-auto bg-white dark:bg-gray-800">
                <!-- Responsive Navigation Menu -->
                <div :class="{'block': open, 'hidden': ! open}" class="hidden z-10 md:hidden p-[5px]">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Home') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('property')" :active="request()->routeIs('property')">
                            {{ __('Property') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('task')">
                            {{ __('Task') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('management')">
                            {{ __('Management') }}
                        </x-responsive-nav-link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <x-responsive-nav-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-responsive-nav-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="h-auto bg-white min-h-fit dark:bg-gray-800">
                    <div class="h-auto md:min-h-[calc(100vh-70px)] min-h-fit dark:bg-gray-900 bg-[#ececec] p-[0px] md:p-[25px]  dark:border-gray-800 border-white rounded-xl">
                        <div class="h-auto min-h-screen md:min-h-[calc(100vh-120px)] rounded-xl border-2 dark:bg-gray-800 dark:bg-opacity-60 bg-gray-100 border-[#5E93DA] shadow-lg p-[25px] ">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </main>
            </div>
        </div>
    </body>
</html>
