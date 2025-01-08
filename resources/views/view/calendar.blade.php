

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Calendar') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        <x-box-dropdown class="w-[100%] h-full" name="My Tasks" disableDropdown=true>
            <div class="flex flex-col gap-3">
                @foreach ($tasks as $date => $taskGroup)
                    <x-box-dropdown class="w-[100%] h-full" name="{{ $date }}">
                        <div class="space-y-4">
                            @foreach ($taskGroup as $group)
                                <div class="flex justify-between items-center p-4 bg-white bg-opacity-10 rounded-lg">
                                    <div class="flex flex-col gap-1">
                                        <x-a-label class="text-xl font-bold">{{ $group->task_name }} ON {{ $group->property_name }} - {{ $group->rent_name }}</x-a-label>
                                        <x-a-label class="text-md !text-gray-400">{{ $group->task_desc }}</x-a-label>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Additional events here -->
                        </div>
                    </x-box-dropdown>
                @endforeach
                <!-- "Add a new note" button -->
                {{-- <button class="mt-4 w-full py-2 text-white bg-[#5E93DA] rounded-lg hover:bg-blue-700">
                    + Add a new note
                </button> --}}
            </div>
        </x-box-dropdown>
    </div>
</x-app-layout>
