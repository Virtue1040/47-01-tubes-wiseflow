<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/jquery.js'])
    <script>
        
    </script>
</head>

<body class="bg-[#ececec] dark:bg-gray-900">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col justify-center items-center w-screen h-screen">   
        <div class="flex flex-row w-full md:w-[800px] md:h-[600px] h-full py-[10px] px-[10px] bg-white dark:bg-gray-800 bg-opacity-[.30] rounded-2xl shadow-2xl">
             <div class="w-[100%] hidden md:flex flex-col justify-center items-center bg-[#5E93DA] relative p-[10px] rounded-2xl"> {{--bg-[url('/resources/image/cover.jpg')]  --}}
                <x-svg.rumah></x-svg.rumah> 
                <x-icon.wiseflow-text class=""></x-icon.wiseflow-text>
             </div> 
            <div class="flex w-full md:w-[85%] justify-center h-[100%] backdrop-blur-sm bg-opacity-2 rounded-2xl px-[5px]">
            <form class="flex flex-col justify-center items-center w-[80%] py-[50px]" autocomplete="off" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <x-input-label class="text-3xl font-bold">Hello Again!</x-input-label>
                <x-a-label class="mt-1 text-xs text-center">Welcome to WiseFlow, please sign in to continue.</x-a-label><br>
                <div class="mt-4 w-full min-w-[0px]  flex flex-col min-h-[45px]">
                    <x-text-input id="login" style="" class="block mt-1 w-full h-full bg-gray-200" placeholder="Email Address / Username" type="text" name="login"
                        :value="old('login')" required autofocus autocomplete="login" />
                    <x-input-error :messages="$errors->get('login')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 w-full min-w-[0px]  flex flex-col min-h-[45px]">
                    <!--x-input-label for="password" :value="__('Password')" /-->

                    <x-text-input id="password" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Password" type="password" name="password" required
                        autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                @if (Route::has('password.request'))
                    <x-a-label class="mt-2 w-full min-w-[0px]  text-right text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </x-a-label>
                @endif
                <!-- Remember Me -->
                <!--div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-indigo-600 rounded border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div-->
                <div class="mt-6 w-full min-w-[0px] flex flex-col min-h-[45px]">
                    <x-primary-button class=" w-full min-h-[45px] flex items-center justify-center">
                        {{ __('Log In') }}
                    </x-primary-button>
                </div>
                <x-input-label class="mt-6 text-sm">Or Sign In With</x-input-label><br>
                <div class="flex gap-[15px] w-full min-w-[300px] justify-center items-center">
                    <div class="flex justify-center items-center hover:shadow-xl w-[50px] h-[50px] p-[10px] cursor-pointer">
                        <x-icon.google></x-icon.google>
                    </div>
                    <div class="flex justify-center items-center hover:shadow-xl w-[50px] h-[50px] p-[10px] cursor-pointer">
                        <x-icon.facebook></x-icon.facebook>
                    </div>
                    <div class="flex justify-center items-center hover:shadow-xl w-[50px] h-[50px] p-[10px] cursor-pointer">
                        <x-icon.apple></x-icon.apple>
                    </div>
                </div>
                <br>
                <x-input-label>Don't have an account? <x-a-label href="{{ route('register') }}" class="font-bold">Sign Up</x-a-label></x-input-label>
            </form>
        </div>
    </div>
</body>

</html>
