<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite('resources/css/app.css')
</head>

<body>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-row w-screen h-screen">
        <div class="flex flex-col w-[50%] justify-center items-center h-full bg-[#5e93da]">
            <x-svg-rumah></x-svg-rumah>
            <div class="flex flex-row justify-center items-center p-6 gap-[10px]">
                <x-svg-application-logo></x-svg-application-logo>
                <h1 class="text-4xl font-bold text-white font-['Plus Jakarta Sans', sans-serif]">WiseFlow</h1>
            </div>
        </div>
        <div class="flex w-[50%] justify-center items-center">
            <form class="flex flex-col justify-center items-center w-[60%]" autocomplete="off" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- First Name -->
                <h1 class="text-5xl font-bold">Sign Up</h1><br>
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <x-text-input id="first_name" style="" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="First Name"  type="text" name="first_name"
                        :value="old('first_name')" required autofocus/>
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <!-- Last Name -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <x-text-input id="last_name" style="" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Last Name"  type="text" name="last_name"
                        :value="old('last_name')" required autofocus/>
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <!-- Username -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <x-text-input id="username" style="" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Username"  type="text" name="username"
                        :value="old('username')" required autofocus/>
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Email -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <x-text-input id="email" style="" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Email Address"   type="email" name="email"
                        :value="old('email')" required autofocus/>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- No Telp -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <x-text-input id="ematelpil" style="" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="No Telephone"   type="tel" name="telp"
                        :value="old('telp')" required autofocus/>
                    <x-input-error :messages="$errors->get('telp')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">
                    <!--x-input-label for="password" :value="__('Password')" /-->

                    <x-text-input id="password" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Password" type="password" name="password" required
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                 <!-- Password Confirmation -->
                <div class="mt-4 w-full max-w-[350px] min-h-[45px]">

                    <x-text-input id="password-confirmation" class="block mt-1 w-full min-h-[45px] bg-gray-200" placeholder="Confirm Password" type="password" name="password_confirmation" required
                    />

                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <br>
                <a class="text-xl font-bold">What are you?</a>
                <div class="mt-2 flex flex-row justify-center gap-[25px] w-full max-w-[350px] min-h-[45px]">

                    <div class="flex flex-row items-center gap-[10px]">
                        <input class="block mt-1 w-auto min-h-[45px] bg-gray-200" id="gender_male" value="male" type="radio" name="gender" required
                        />
                        <x-input-label for="gender_male" class="text-xl font-bold"> Male </x-input-label>
                    </div>
                    <div class="flex flex-row items-center gap-[10px]"">
                        <input class="block mt-1 w-auto min-h-[45px] bg-gray-200" id="gender_women" value="woman" type="radio" name="gender" required
                        />
                        <x-input-label for="gender_women" class="text-xl font-bold"> Woman </x-input-label>
                    </div>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <!--div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="text-indigo-600 rounded border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                            name="remember">
                        <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div-->
                <br>
                <div class="flex w-full justify-end items-center mt-4 max-w-[350px] min-h-[45px]">
                    @if (Route::has('password.request'))
                        <!--a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a-->
                    @endif

                    <x-primary-button class=" w-full min-h-[45px] flex items-center justify-center">
                        {{ __('Sign Up') }}
                    </x-primary-button>

                </div>
                <br>
                <p>Have an account? <a href="{{ route('register') }}" class="font-bold">Sign In</a></p>
            </form>
        </div>
    </div>
</body>

</html>
