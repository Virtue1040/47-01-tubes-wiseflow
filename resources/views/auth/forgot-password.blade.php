<x-guest-layout p="auto" class="md:!w-[500px]">
    <div class="flex flex-col justify-center items-center p-5 px-10">
        <x-icon.information p=120 l=120/>
        <x-input-label class="text-3xl font-bold">Forgot Password</x-input-label><br>
        <div class="mb-4 text-sm text-center text-gray-600 dark:text-gray-400">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    
        <form class="w-full" method="POST" action="{{ route('password.email') }}">
            @csrf
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <div class="flex justify-end items-center mt-4">
                <x-primary-button>
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    
</x-guest-layout>
