

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        * {
            font-family: 'Inter';
        }
    </style>
    <!-- Jquery -->
    <x-default-global-js></x-default-global-js>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/stream-chat"></script>
    <script src={{ asset('js/modal_create.js') }}></script>
    <script src={{ asset('js/handle_upload.js') }}></script>
    <script src={{ asset('js/handle_dropdown.js') }}></script>
    <script src={{ asset('js/handle_host.js') }}></script>
    <script src={{ asset('js/handle_drag.js') }}></script>
    <script src={{ asset('js/handle_itemlist.js') }}></script>
    <script src={{ asset('js/handle_theme.js') }}></script>
    <script src="{{ asset('js/tinymce/tinymce.js') }}" referrerpolicy="origin"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src={{ asset('js/modernizr.js')}}></script>
    <script src={{ asset("js/snap.svg-min.js")}}></script>
    <script src={{ asset("js/main.js")}}></script> 
    <script src={{ asset("js/jquery.mobile.custom.min.js") }}></script>
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.11.0/mapbox-gl.css' rel='stylesheet' />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.3/mapbox-gl-geocoder.css"
        type="text/css">
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> --}}
    @include('sweetalert::alert')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        //GETSTREAM API AUTHORIZATION
        const apiKey = "{{ env('STREAM_API_KEY') }}";
        const userId = "{{ Auth::user()->id_user }}";
        const userToken = "{{ $streamToken ?? '' }}";
        const client = new StreamChat(apiKey);
        async function refreshUnread() {
            const unreadCounts = await client.getUnreadCount();
            if (unreadCounts['total_unread_count'] > 0) {
                $("#chatNotification").css('display', 'flex');
            } else {
                $("#chatNotification").css('display', 'none');
            }
            $("#chatNotification").html(unreadCounts['total_unread_count']);
        }
        async function connectUser() {
            await client.connectUser({
                    id: userId,
                    name: "{{ Auth::user()->contactInformation->first_name }} {{ Auth::user()->contactInformation->last_name }}",
                },
                userToken);
            refreshUnread();
            setInterval(() => {
                refreshUnread();
            }, 5000);
        }
        connectUser();
        //JQUERY PLUGIN
        (function($) {
            $.fn.onEnter = function(func) {
                this.bind('keypress', function(e) {
                    if (e.keyCode == 13) func.apply(this, [e]);
                });
                return this;
            };
            $.fn.onPause = function(func, delay = 2000) {
                let timer;
                this.on('input', function() {
                    clearTimeout(timer); 
                    timer = setTimeout(() => {
                        func.apply(this); 
                    }, delay);
                });
                return this;
            };
        })(jQuery);
        ////////////////////////////////////////////////////////////////
        let createBounced = false;
        let isDark = document.documentElement.classList.contains('dark');
        let onThemeChangeFunction = {};

        function decodeHTML(html) {
            const textarea = document.createElement('textarea');
            textarea.innerHTML = html;
            return textarea.value;
        }

        function addFunctionToTheme(name, functions) {
            if (typeof(functions) !== 'function') {
                return;
            }
            functions();
            onThemeChangeFunction[name] = functions;
        }
        let mapboxAccessToken =
            'pk.eyJ1IjoidmlydHVlMTA0MCIsImEiOiJjbTRvbDN0Nzkwbm90MmtvcjBkbjM5eXIxIn0.QO5RmH14wE4_ej1Xx9isMQ';

        function setupMap(object, lng, lat, property) {
            mapboxgl.accessToken = mapboxAccessToken;
            const map = new mapboxgl.Map({
                container: object,
                style: 'mapbox://styles/mapbox/streets-v12',
                center: [lng, lat],
                zoom: 15,
                attributionControl: false
            });

            // let map = L.map(object, { attributionControl: false }).setView([lat, lng], 13);

            // L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            //     attribution: false
            // }).addTo(map);

            return map;
        }

        function geocodeAddress(address, callback) {
            $.ajax({
                url: `https://api.mapbox.com/geocoding/v5/mapbox.places/${encodeURIComponent(address)}.json`,
                method: "GET",
                data: {
                    access_token: mapboxAccessToken,
                    limit: 1,
                },
                success: function(data) {
                    if (data.features && data.features.length > 0) {
                        // data.features.forEach(element => {
                        //     if (element.place_type[0] === 'poi') {
                        //         const feature = element;
                        //         const latitude = feature.center[1];
                        //         const longitude = feature.center[0];
                        //         callback(longitude, latitude);   
                        //     }
                        // });
                        const feature = data.features[0];
                        const latitude = feature.center[1];
                        const longitude = feature.center[0];
                        callback(longitude, latitude);
                    } else {

                    }
                },
                error: function(error) {
                    $('#result').html('<p>An error occurred: ' + error.responseText + '</p>');
                    console.error("Error with API request:", error);
                }
            });
            // mapboxClient.geocoding
            // .forwardGeocode({
            //     query: address,
            //     limit: 1
            //     })
            //     .send()
            //     .then(response => {
            //     if (response && response.body && response.body.features.length) {
            //         const feature = response.body.features[0];
            //         callback(feature);
            //         console.log(feature);
            //         console.log('Coordinates:', feature.geometry.coordinates);
            //         console.log('Place Name:', feature.place_name);
            //     }
            // });
            // var url = `https://api.mapbox.com/geocoding/v5/mapbox.places/${address}.json`;

            // $.ajax({
            //     url: url,
            //     type: 'GET',
            //     success: function(data) {

            //         if (data && data.length > 0) {
            //             var lat = data[0].lat;
            //             var lon = data[0].lon;
            //             callback(lat, lon);
            //         } else {

            //         }
            //     },
            //     error: function(error) {

            //     }
            // })
        }

        function reverseGeocode(lng, lat, callback) {
            $.ajax({
                url: `https://api.mapbox.com/search/geocode/v6/reverse?longitude=${lng}&latitude=${lat}`,
                method: "GET",
                data: {
                    access_token: mapboxAccessToken,
                    limit: 1,
                },
                success: function(data) {
                    if (data.features && data.features.length > 0) {
                        const feature = data.features[0];
                        const placeName = feature.place_name;
                        callback(feature);
                    } else {

                    }
                },
                error: function(error) {
                    $('#result').html(`<p>An error occurred: ${error.responseText}</p>`);
                    console.error("Error with API request:", error);
                }
            });
            // mapboxClient.geocoding
            // .reverseGeocode({
            //     query: [lat, lng],
            //     limit: 1
            //     })
            //     .send()
            //     .then(response => {
            //     if (response && response.body && response.body.features.length) {
            //         const feature = response.body.features[0];
            //         console.log(feature);
            //         console.log('Place Name:', feature.place_name);
            //     }
            // });
            // var url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`;

            // $.ajax({
            //     url: url,
            //     type: 'GET',
            //     success: function(data) {
            //         if (data && data.address) {
            //             callback(data);
            //             var address = data.display_name;
            //             // // Optionally add a marker with the address
            //             // L.marker([lat, lng]).addTo(map).bindPopup(address).openPopup();
            //         }
            //     },
            //     error: function(error) {

            //     }
            // })
        }

        function onThemeChange() {
            isDark = document.documentElement.classList.contains('dark');
            Object.keys(onThemeChangeFunction).forEach(key => {
                onThemeChangeFunction[key]();
            });
        }

        function loadTinyMCE(editorName, setup) {
            tinymce.remove(editorName);
            tinymce.init({
                selector: editorName,
                plugins: 'code lists',
                toolbar: 'bold | forecolor | fontsize | alignleft | aligncenter | alignright | alignjustify | lineheight ',

                height: 250,
                branding: false,
                width: '100%',
                promotion: false,
                skin: (isDark ? "oxide-dark" : "oxide"),
                content_css: (isDark ? "tinymce-5-dark" : "tinymce-5"),
                menubar: false,
                inline_boundaries: false,
                statusbar: false,
                license_key: 'gpl',
                setup: setup
            });
        }
        const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 4500,
            timerProgressBar: true,
        })

        const ToastSave = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: true,
            showDenyButton: true,
            confirmButtonText: `Save`,
            denyButtonText: `Discard`,
        })

        $(document).ready(function() {
            @if (session('alert'))
                Toast.fire({
                    icon: '{{ session('alert')['type'] }}',
                    title: '{{ session('alert')['message'] }}',
                });
            @endif
        })

        function askConfirmation(name, method = 'POST', formData = '', text = 'Are you sure?', onCreated) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let extended = ''
            formData.forEach((item, index) => {
                extended += `<input name='${item.name}' value='${item.value}' type='hidden'>`
            });
            let returns = init_create_modal(name, [{
                title: ''
            }], [
                `
                                <div class="flex justify-center items-center">
                                    <input name='form_name' value='a' type='hidden'>  
                                    @method('${method}')
                                    ${extended}
                                    <x-a-label>${text}</x-a-label>
                                </div>
                            `,
            ], {

            }, {
                lastButton: "Yes",
                hideStep: true,
                'min-width': 0,
                backAsClose: true,
                backButton: 'Cancel',
                onCreate: function(form, div) {
                    if (onCreated !== undefined) {
                        console.log("gacorrrrrrrr");
                        onCreated(form, div)
                    }
                    createBounced = false;
                },
            })
        }

        function toUpperCase(word) {
            const str = word;
            let result = str.charAt(0).toUpperCase() + str.slice(1);
            return result;
        }
    </script>
</head>

<body x-data="{
    open: false,
    openSideBar: true,
    theme: localStorage.getItem('theme') || 'dark',
    lightMode() {
        this.theme = 'light';
        html.removeClass('dark');
        localStorage.setItem('theme', 'light');
        onThemeChange();
    },
    darkMode() {
        this.theme = 'dark';
        html.addClass('dark');
        localStorage.setItem('theme', 'dark');
        onThemeChange();
    },
    systemMode() {
        this.theme = 'system';
        localStorage.setItem('theme', 'system');
        applySystemMode();
        onThemeChange();
    }
}" class="relative h-auto font-sans antialiased dark:bg-[#18181B] overflow-y-hidden">
    <div class="flex h-auto bg-white dark:bg-[#18181B]">
        <!-- Layout Navigation -->
        @php
            $user = Auth::user();
        @endphp
        @if (!$user->roles->isEmpty())
            @include('layouts.navigation')
        @endif
        <div class="flex flex-col w-full h-auto">
            <!-- Page Heading -->
            @isset($header)
                <header class="flex bg-white dark:bg-[#18181B] sticky top-0 z-50">
                    <!-- Sidebar Humberger -->
                    @if (!$user->roles->isEmpty())
                        <div class="hidden items-center ml-6 -me-2 md:flex">
                            <button @click="openSideBar = ! openSideBar"
                                class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400"
                                id="sideBarHumberger">
                                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ 'hidden': openSideBar, 'inline-flex': !openSideBar }"
                                        class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{ 'hidden': !openSideBar, 'inline-flex': openSideBar }" class="hidden"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                    <div class="px-4 py-6 w-full sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                    <div class="flex float-right justify-end mr-5 w-full">
                        <div class="hidden float-right md:flex md:items-center md:gap-[5px]">
                            <x-search placeholder="Search" />
                        </div>
                        <!-- Notification Dropdown -->
                        <div class="hidden float-right md:flex md:items-center">
                            <x-dropdown align="right" width="w-[300px] ">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium  text-gray-500 dark:bg-[#18181B] bg-white relative rounded-md border border-transparent dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <div class="w-[25px] h-[25px] relative">
                                            <span
                                                class="inline-flex absolute w-[10px] h-[10px] top-0 right-0 bg-sky-400 rounded-full opacity-100 animate-ping"></span>
                                            <span
                                                class="inline-flex absolute w-[10px] h-[10px] top-0 right-0 bg-sky-500 rounded-full"></span>
                                            <x-icon.notification p=25 l=25></x-icon.notification>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="flex flex-col px-1 pb-[5px]">
                                        <div class="flex flex-col justify-center items-center w-full h-full py-[25px] gap-[15px]"
                                            name="noChildren">
                                            <div class="rotate-45">
                                                <x-icon.notification p=55 l=55></x-icon.notification>
                                            </div>
                                            <x-a-label class="text-sm">You don't have any notification</x-a-label>
                                        </div>
                                        <div class="hidden" id="notificationContainer">

                                        </div>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <!-- Settings Dropdown -->
                        <div class="hidden float-right md:flex md:items-center">
                            <x-dropdown align="right" width="w-[250px]">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 dark:bg-[#18181B] bg-white rounded-md border border-transparent dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                        <div class="flex items-center gap-[10px]">
                                            <div
                                                class="flex justify-center items-center rounded-full min-w-[30px] h-[30px] bg-white overflow-hidden">
                                                <img onerror="$(this).parent().find('a').text('{{ substr($user->contactInformation->first_name, 0, 1) }}'); $(this).css('display', 'none')"
                                                    src="{{ $user->getAvatarUrl() }}" class="w-[30px] h-[30px]">
                                                <a class="text-black"></a>
                                            </div>
                                        </div>

                                        <div class="ms-1">
                                            <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="flex flex-col px-1  pb-[5px]">
                                        <div class="h-[60px] flex items-center px-3 gap-[10px] py-[10px]">
                                            <div
                                                class="flex justify-center items-center rounded-full min-w-[30px] h-[30px] bg-white overflow-hidden">
                                                <img onerror="$(this).parent().find('a').text('{{ substr($user->contactInformation->first_name, 0, 1) }}'); $(this).css('display', 'none')"
                                                    src="@php
echo $user->contactInformation->profilePath == null ? $user->social_avatar : asset($user->contactInformation->profilePath) @endphp"
                                                    class="w-[30px] h-[30px]">
                                                <a class="text-black"></a>
                                            </div>
                                            <div class="flex flex-col w-full truncate">
                                                <div class="flex gap-[5px] items-center">
                                                    <x-a-label class="text-sm truncate text-nowrap">{{ $user->getFullName() }}</x-a-label>
                                                    @if (count($user->getRoleNames()) > 0)
                                                        <p
                                                            class="bg-[#5E93DA] py-[1px] text-xs px-[10px] text-white w-auto rounded-lg align-middle">
                                                            {{ $user->getRoleNames()[0] }}</p>
                                                    @endif
                                                </div>

                                                <x-a-label
                                                    class="mt-1 text-xs !text-gray-500 w-full">{{ Auth::user()->contactInformation->email }}</x-a-label>
                                            </div>
                                        </div>
                                        <hr class="dark:border-[#464649] border-gray-200">
                                        <div class="flex items-center mt-2 gap-[5px]">
                                            <button
                                                x-bind:class="theme === 'light' ? 'dark:!bg-[#242427] !bg-gray-100' : ''"
                                                @click="lightMode()" id="lightMode"
                                                class="flex justify-center rounded-md w-full py-2 hover:bg-gray-100 dark:hover:bg-[#242427] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                                <x-icon.light
                                                    x-bind:class="theme === 'light' ? '!stroke-[#5E93DA] dark:!stroke-[#5E93DA]' :
                                                        ''"
                                                    p=25 l=25 />
                                            </button>
                                            <button
                                                x-bind:class="theme === 'dark' ? 'dark:!bg-[#242427] !bg-gray-100' : ''"
                                                @click="darkMode()" id="darkMode"
                                                class="flex justify-center rounded-md w-full py-2 hover:bg-gray-100 dark:hover:bg-[#242427] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                                <x-icon.dark
                                                    x-bind:class="theme === 'dark' ?
                                                        '!stroke-[#5E93DA] dark:!stroke-[#5E93DA] dark:!fill-[#5E93DA] !fill-[#5E93DA]' :
                                                        ''"
                                                    p=25 l=25 />
                                            </button>
                                            <button
                                                x-bind:class="theme === 'system' ? 'dark:!bg-[#242427] !bg-gray-100' : ''"
                                                @click="systemMode()" id="systemMode"
                                                class="flex justify-center rounded-md w-full py-2 hover:bg-gray-100 dark:hover:bg-[#242427] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800">
                                                <x-icon.system
                                                    x-bind:class="theme === 'system' ? '!stroke-[#5E93DA] dark:!stroke-[#5E93DA]' :
                                                        ''"
                                                    p=25 l=25 />
                                            </button>
                                        </div>
                                        <hr class="dark:border-[#464649] border-gray-200 mt-2">
                                        <x-dropdown-link :href="route('profile.overview', $user->id_user)" class="mt-2 flex gap-[5px]">
                                            <x-icon.profile p="20" l="20" />
                                            {{ __('View Profile') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('profile.edit')" class=" flex gap-[5px]">
                                            <x-icon.setting p="20" l="20" />
                                            {{ __('Settings') }}
                                        </x-dropdown-link>
                                        <hr class="dark:border-[#464649] border-gray-200 mt-2">
                                        <x-dropdown-link :href="route('profile.edit')" class="mt-2 flex gap-[5px]">
                                            <x-icon.support p="20" l="20" />
                                            {{ __('Support') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('profile.edit')" class=" flex gap-[5px]">
                                            <x-icon.forum p="20" l="20" />
                                            {{ __('Community') }}
                                        </x-dropdown-link>
                                        <hr class="dark:border-[#464649] border-gray-200 mt-2">
                                        <x-dropdown-link :href="route('profile.edit')" class="mt-2 flex gap-[5px]">
                                            <x-icon.help p="20" l="20" />
                                            {{ __('Help') }}
                                        </x-dropdown-link>
                                        <hr class="dark:border-[#464649] border-gray-200 mt-2">
                                        <!-- Authentication -->
                                        <form class="" method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                                this.closest('form').submit();"
                                                class="mt-2 flex gap-[5px]">
                                                <x-icon.logout p="20" l="20" />
                                                {{ __('Sign Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 md:hidden">
                            <button @click="open = ! open"
                                class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                                <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                        stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                </header>

            @endisset

            <!-- Page Content -->
            <main class="flex flex-col justify-between h-auto bg-white dark:bg-gray-800">
                <!-- Responsive Navigation Menu -->
                <div :class="{ 'block': open, 'hidden': !open }" class="hidden z-10 md:hidden p-[5px]">
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
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                                {{ Auth::user()->name }}</div>
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

                <div class="w-full h-auto bg-white min-h-fit dark:bg-[#18181B]">
                    <div
                        class="w-fu;; flex h-auto md:min-h-[calc(100vh-70px)] min-h-fit dark:bg-[#09090B] bg-[#f1f1f1] p-[0px] md:p-[25px]  dark:border-gray-800 border-white rounded-xl overflow-hidden">
                        <div
                            class="w-full h-auto flex-grow rounded-xl border-2 dark:bg-[#18181B] dark:bg-opacity-50 bg-gray-100 border-[#5E93DA] shadow-lg ">
                            <div class="w-full overflow-y-auto h-[calc(100vh-125px)] p-[25px]
                            [&::-webkit-scrollbar]:w-2
                            [&::-webkit-scrollbar-track]:rounded-full
                            [&::-webkit-scrollbar-thumb]:rounded-full
                            [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]"
                                id="contentContainer">
                                {{ $slot }}
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
