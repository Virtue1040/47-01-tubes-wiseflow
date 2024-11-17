<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="p-6 mx-auto max-w-5xl bg-white rounded-lg shadow-md">
        <div class="grid grid-cols-2 gap-4">
            <!-- Calendar View -->
            <div>
                <!-- Month and Year Heading -->
                <div class="text-center text-[#5E93DA] text-3xl font-bold mb-4">January, 2021</div>
                <!-- Calendar Box with increased size -->
                <div class="grid grid-cols-7 gap-2 p-4 font-medium text-center text-gray-600 bg-gray-50 rounded-lg" style="width: 100%; height: 450px;">
                    <!-- Days of the week -->
                    <div>Sun</div>
                    <div>Mon</div>
                    <div>Tue</div>
                    <div>Wed</div>
                    <div>Thu</div>
                    <div>Fri</div>
                    <div>Sat</div>
                    
                    <!-- Dates of the month (1-31) -->
                    <div class="p-4">1</div>
                    <div class="p-4">2</div>
                    <div class="p-4">3</div>
                    <div class="p-4">4</div>
                    <div class="p-4">5</div>
                    <div class="p-4">6</div>
                    <div class="p-4">7</div>
                    <div class="p-4">8</div>
                    <div class="p-4">9</div>
                    <div class="p-4">10</div>
                    <div class="p-4">11</div>
                    <div class="p-4">12</div>
                    <div class="p-4">13</div>
                    <div class="p-4">14</div>
                    <div class="p-4">15</div>
                    <div class="p-4">16</div>
                    <div class="p-4">17</div>
                    <div class="p-4">18</div>
                    <div class="p-4">19</div>
                    <div class="p-4">20</div>
                    <div class="p-4">21</div>
                    <div class="p-4">22</div>
                    <div class="p-4">23</div>
                    <div class="p-4">24</div>
                    <div class="p-4">25</div>
                    <div class="p-4">26</div>
                    <div class="p-4">27</div>
                    <div class="p-4">28</div>
                    <div class="p-4">29</div>
                    <div class="p-4">30</div>
                    <div class="p-4">31</div>
                </div>
            </div>

            <!-- Event List for the Selected Day -->
            <div>
                <!-- Selected Date Heading -->
                <div class="mb-4 text-2xl font-semibold text-right text-black">Saturday, 5<sup>th</sup></div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-gray-100 rounded-lg">
                        <div>
                            <div class="font-semibold text-gray-800">Work Time</div>
                            <div class="text-sm text-gray-500">09:00 - 15:30</div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-gray-600 hover:text-gray-800">
                                <!-- Edit icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l7 7-7 7m2-7H3"/>
                                </svg>
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <!-- More options icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5l7 7-7 7m2-7H3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex justify-between items-center p-4 bg-gray-100 rounded-lg">
                        <div>
                            <div class="font-semibold text-gray-800">Coffee Time at Frozen Coffee Shop</div>
                            <div class="text-sm text-gray-500">19:00 - 10:00</div>
                        </div>
                        <div class="flex space-x-2">
                            <button class="text-gray-600 hover:text-gray-800">
                                <!-- Edit icon -->
                            </button>
                            <button class="text-gray-600 hover:text-gray-800">
                                <!-- More options icon -->
                            </button>
                        </div>
                    </div>

                    <!-- Additional events here -->
                </div>
                <!-- "Add a new note" button -->
                <button class="mt-4 w-full py-2 text-white bg-[#5E93DA] rounded-lg hover:bg-blue-700">
                    + Add a new note
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
