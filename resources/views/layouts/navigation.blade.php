<script>
    $(document).ready(function() {
        handle_dropdown();
    })
</script>
<nav :class="{ 'block': openSidebar, 'hidden': !openSidebar }"
    class="float-left w-auto bg-white border-b border-gray-100 dark:bg-gray-800 dark:border-gray-700">
    <div class="hidden md:block w-[280px]">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="h-16">
                <div class="flex mt-6 bg-[#5E93DA] rounded-2xl drop-shadow-xl p-[5px]">
                    <!-- Logo -->
                    <div class="flex gap-[8px] items-center shrink-0">
                        <a href="{{ route('dashboard') }}" class="w-auto">
                            <x-icon.wiseflow p="45" l="45"
                                class="text-gray-800 fill-current dark:text-gray-200"></x-icon.wiseflow>
                        </a>
                        <a
                            class="text-xl font-bold text-white  font-['Plus Jakarta Sans', sans-serif] drop-shadow-md ">WiseFlow</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Navigation Links -->
        <div class="hidden sm:-my-px sm:mx-5 sm:flex sm:flex-col sm:gap-[10px]">
            <x-nav-dropdown name="Overview">
                <x-nav-div :href="route('home')" :active="request()->routeIs('home')" class="">
                    <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                        <x-svg.homeprop p="20" l="20" :active="request()->routeIs('home')"></x-svg.homeprop>
                        <p>{{ __('Home') }}</p>
                    </div>
                </x-nav-div>
                <x-nav-div :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                        <x-icon.dashboard p="20" l="20" :active="request()->routeIs('dashboard')"></x-icon.dashboard>
                        <p>{{ __('Dashboard') }}</p>
                    </div>

                </x-nav-div>
            </x-nav-dropdown>
            <x-nav-dropdown name="Property Management">
                <x-nav-div :href="route('property')" :active="request()->routeIs('property')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                        <x-icon.property p="20" l="20" :active="request()->routeIs('property')"></x-icon.property>
                        <p>{{ __('My Property') }}</p>
                    </div>

                </x-nav-div>
            </x-nav-dropdown>
            <x-nav-dropdown name="Task Management">
                <x-nav-div :href="route('task')" :active="request()->routeIs('task')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                        <x-icon.task p="20" l="20" :active="request()->routeIs('task')"></x-icon.task>
                        <p>{{ __('My Tasks') }}</p>
                    </div>

                </x-nav-div>
                <x-nav-div :href="route('calendar')" :active="request()->routeIs('calendar')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                        <x-icon.calendar p="20" l="20" :active="request()->routeIs('calendar')"></x-icon.calendar>
                        <p>{{ __('Calendar') }}</p>
                    </div>

                </x-nav-div>
            </x-nav-dropdown>
            <x-nav-dropdown name="Booking">
                <x-nav-div :href="route('booking')" :active="request()->routeIs('booking')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                        <x-icon.booking p="20" l="20" :active="request()->routeIs('booking')"></x-icon.booking>
                        <p>{{ __('Bookings') }}</p>
                    </div>

                </x-nav-div>
            </x-nav-dropdown>
            <x-nav-dropdown name="Communication">
                <x-nav-div :href="route('chat')" :active="request()->routeIs('chat')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                        <x-icon.chat p="20" l="20" :active="request()->routeIs('chat')"></x-icon.chat>
                        <p>{{ __('Chats') }}</p>
                    </div>

                </x-nav-div>
                <x-nav-div :href="route('contact')" :active="request()->routeIs('contact')" class="w-full">
                    <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                        <x-icon.contact p="20" l="20" :active="request()->routeIs('contact')"></x-icon.contact>
                        <p>{{ __('Contacts') }}</p>
                    </div>

                </x-nav-div>
            </x-nav-dropdown>
        </div>
    </div>
</nav> 
