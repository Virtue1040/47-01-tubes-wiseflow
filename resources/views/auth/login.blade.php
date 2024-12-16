@section('title', '- Login')
<x-guest-layout>
    <div class="w-[100%] hidden md:flex flex-col justify-center items-center bg-[#5E93DA] relative p-[10px] rounded-2xl">
        {{-- bg-[url('/resources/image/cover.jpg')]  --}}
        <x-svg.rumah></x-svg.rumah>
        <x-icon.wiseflow-text class=""></x-icon.wiseflow-text>
    </div>
    <div
        class="flex w-full md:w-[85%] justify-center h-[100%] backdrop-blur-sm bg-opacity-2 rounded-2xl px-[5px]">
        <form class="flex flex-col justify-center items-center w-[80%] py-[35px]"
            method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <x-input-label class="text-3xl font-bold">Hello Again!</x-input-label>
            <x-a-label class="mt-1 text-sm text-center">Welcome to WiseFlow, please sign in to
                continue.</x-a-label><br>
            <div class="mt-4 w-full min-w-[0px]  flex flex-col min-h-[45px]">
                <x-text-input id="login" style="" class="block mt-1 w-full h-full bg-gray-200"
                    placeholder="Email Address / Username" type="text" name="login" :value="old('login')"
                    required autofocus />
                <x-input-error :messages="$errors->get('login')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4 w-full min-w-[0px]  flex flex-col min-h-[45px]">
                <!--x-input-label for="password" :value="__('Password')" /-->

                <x-text-input id="password" class="block mt-1 w-full min-h-[45px] bg-gray-200"
                    placeholder="Password" type="password" name="password" required
                     />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            @if (Route::has('password.request'))
                <x-a-label
                    class="mt-2 w-full min-w-[0px]  text-right text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
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
                <div
                    class="transition all ease-in duration-100 flex justify-center items-center hover:drop-shadow-[0px_0px_15px_rgba(94,147,218)] rounded-full w-[50px] h-[50px] p-[10px] cursor-pointer">
                    <a class="w-full h-full" href="{{ url('/login/OAuth2/Google') }}">
                        <x-icon.google />
                    </a>
                </div>
                <div
                    class="transition all ease-in duration-100 flex justify-center items-center hover:drop-shadow-[0px_0px_15px_rgba(94,147,218)] rounded-full w-[50px] h-[50px] p-[10px] cursor-pointer ">
                    <a class="w-full h-full" href="{{ url('/login/OAuth2/Facebook') }}">
                        <x-icon.facebook />
                    </a>
                </div>
                <div
                    class="transition all ease-in duration-100 flex justify-center items-center hover:drop-shadow-[0px_0px_15px_rgba(94,147,218)] rounded-full w-[50px] h-[50px] p-[6px] cursor-pointer">
                    <a class="w-full h-full" href="{{ url('/login/OAuth2/microsoft') }}">
                        <x-icon.microsoft />
                    </a>
                </div>
            </div>
            <br>
            <x-input-label>Don't have an account? <x-a-label href="{{ route('register') }}"
                    class="font-bold">Sign Up</x-a-label></x-input-label>
        </form>
    </div>
</x-guest-layout>

</html>
