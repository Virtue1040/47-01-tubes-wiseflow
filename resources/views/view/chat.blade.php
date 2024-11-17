<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Chats') }}
        </h2>
    </x-slot>

    <!-- Chat Container -->
    <div class="flex flex-col h-screen">

        <!-- Profile Header -->
        <div class="flex items-center p-4 bg-gray-100 border-b border-gray-300 dark:border-gray-700 dark:bg-gray-800">
            <img src="" alt="Profile Image" class="mr-3 w-10 h-10 rounded-full">
            <span class="font-semibold text-gray-900 dark:text-gray-200">Kost Sumberjaya</span>
        </div>

        <!-- Chat Messages -->
        <div class="overflow-y-auto flex-grow p-4">
            <div class="flex flex-col space-y-4">
                <div class="flex items-center">
                    <div class="p-3 max-w-xs bg-gray-200 rounded-lg dark:bg-gray-700">
                        <p class="text-gray-900 dark:text-gray-100">Hallo, Alif!!!</p>
                    </div>
                </div>
                <div class="flex justify-end">
                    <div class="p-3 max-w-xs text-white bg-blue-500 rounded-lg dark:bg-blue-700">
                        <p>Iya bu kenapa?</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="p-3 max-w-xs bg-gray-200 rounded-lg dark:bg-gray-700">
                        <p class="text-gray-900 dark:text-gray-100">Jangan lupa bayar listrik ya:)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Input Message (Fixed at Bottom) -->
        <div class="sticky bottom-0 p-4 bg-gray-100 border-t border-gray-300 dark:bg-gray-800 dark:border-gray-700">
            <form class="flex items-center">
                <input type="text" placeholder="Type a message..." class="flex-grow px-4 py-2 mr-4 rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" />
                <button type="submit" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600 dark:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none">
                    Send
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
