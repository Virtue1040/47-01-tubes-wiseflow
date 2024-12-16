@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Calendar')

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="p-6 mx-auto max-w-7xl bg-white rounded-lg shadow-md">
        <!-- Month and Year Navigation -->
        <div class="flex justify-between items-center mb-4">
            <button onclick="previousMonth()" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Previous
            </button>
            <div id="monthYear" class="text-xl font-bold text-center text-gray-800"></div>
            <button onclick="nextMonth()" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                Next
            </button>
        </div>

        <!-- Calendar Grid -->
        <div id="calendarGrid" class="grid grid-cols-7 gap-2 mb-4 text-center">
            <!-- Days of the Week -->
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Sun</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Mon</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Tue</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Wed</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Thu</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Fri</div>
            <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Sat</div>
        </div>

        <!-- Add Event Button -->
        <div class="text-right">
            <button onclick="openAddEventModal()" class="px-4 py-2 text-white bg-green-500 rounded-lg hover:bg-green-600">
                + Add Event
            </button>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" class="flex hidden fixed inset-0 z-50 justify-center items-center bg-black bg-opacity-50">
        <div class="p-6 w-full max-w-md bg-white rounded-lg">
            <h3 class="mb-4 text-lg font-bold text-gray-800">Add New Event</h3>
            <form method="POST" action="{{ route('events.store') }}">
                @csrf
                <div class="mb-4">
                    <label for="event_date" class="block text-sm font-medium text-gray-700">Date</label>
                    <input type="date" id="event_date" name="event_date" class="px-3 py-2 w-full rounded-lg border" required>
                </div>
                <div class="mb-4">
                    <label for="event_name" class="block text-sm font-medium text-gray-700">Event Name</label>
                    <input type="text" id="event_name" name="event_name" class="px-3 py-2 w-full rounded-lg border" required>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeAddEventModal()" class="px-4 py-2 mr-2 text-gray-500 bg-gray-200 rounded-lg hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                        Save Event
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Calendar -->
    <script>
        const calendarGrid = document.getElementById('calendarGrid');
        const monthYear = document.getElementById('monthYear');
        const addEventModal = document.getElementById('addEventModal');
        let currentDate = new Date();

        function renderCalendar(date) {
            // Clear existing calendar cells
            calendarGrid.innerHTML = `
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Sun</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Mon</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Tue</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Wed</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Thu</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Fri</div>
                <div class="p-2 font-bold text-gray-700 bg-gray-200 rounded">Sat</div>
            `;

            const year = date.getFullYear();
            const month = date.getMonth();

            // Update the month and year heading
            monthYear.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });

            // Calculate first day of the month
            const firstDay = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();

            // Add empty cells for days before the first day of the month
            for (let i = 0; i < firstDay; i++) {
                calendarGrid.innerHTML += `<div class="p-2 bg-gray-50 rounded border border-gray-300"></div>`;
            }

            // Add cells for each day of the month
            for (let day = 1; day <= lastDate; day++) {
                calendarGrid.innerHTML += `
                    <div class="p-8 bg-white rounded border border-gray-300">
                        <div class="text-sm font-bold text-gray-800">${day}</div>
                    </div>
                `;
            }
        }

        function previousMonth() {
            currentDate.setMonth(currentDate.getMonth() - 1);
            renderCalendar(currentDate);
        }

        function nextMonth() {
            currentDate.setMonth(currentDate.getMonth() + 1);
            renderCalendar(currentDate);
        }

        function openAddEventModal() {
            addEventModal.classList.remove('hidden');
        }

        function closeAddEventModal() {
            addEventModal.classList.add('hidden');
        }

        // Initialize the calendar
        renderCalendar(currentDate);
    </script>
</x-app-layout>
