@props(['l' => "800px", 'p' => "600px"])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('site.webmanifest') }}">

        <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
            rel="stylesheet">
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
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src={{ asset("js/handle_theme.js")}}></script>
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
                showConfirmButton: true,
                timer: 5000,
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
    <body x-data="{
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
        }"
        class="bg-[#ececec] dark:bg-[#09090B]">
        <div class="flex flex-col justify-center items-center w-screen h-screen">
            <div>
                <div class="w-[170px] flex items-center mb-2 gap-[5px]">
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
                <div {{ $attributes->merge(['class' => "m-auto flex flex-row md:w-[$l] w-full md:h-auto md:min-h-[$p] h-full min-h-[$p] py-[10px] px-[10px] bg-white dark:bg-[#18181B] bg-opacity-[.30] rounded-2xl shadow-2xl"]) }}>
                    
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
