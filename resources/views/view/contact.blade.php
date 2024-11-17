<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-7xl">
            <x-card.list-item id="contacts-list"/>
        </div>
    </div>
</x-app-layout>
