<script>
    $(document).ready(function() {
        handle_dropdown();
    })
</script>
<nav :class="" x-show="openSideBar" class="float-left w-auto bg-white border-b border-gray-100 dark:bg-[#18181B] dark:border-gray-700 " id="sideBarNavigation" x-transition:enter="transition-transform ease-out duration-300" x-transition:enter-start="translate-x-[-100%]" x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform ease-in duration-200" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-[-100%]">
    <div class="hidden w-[290px] h-[calc(100vh)] md:block">
        <!-- Primary Navigation Menu -->
        <div class="mx-auto max-w-4xl sm:px-2 lg:px-8">
            <div class="flex justify-center items-center h-16">
                <div class="flex w-fit justify-center mt-6 bg-[#5E93DA] rounded-2xl drop-shadow-xl p-[5px] px-[8px]">
                    <!-- Logo -->
                    <div class="flex w-fit gap-[8px] items-center justify-center">
                        <a href="{{ route('dashboard') }}" class="w-auto">
                            <x-icon.wiseflow p="45" l="45"
                                class="text-gray-800 fill-current dark:text-gray-200"></x-icon.wiseflow>
                        </a>
                        <a class="text-xl font-bold text-white  font-['Plus Jakarta Sans', sans-serif] drop-shadow-md ">WiseFlow</a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <!-- Navigation Links -->
        <div class="hidden sm:-my-px sm:mx-5 sm:mr-2 sm:flex sm:flex-col sm:gap-[10px] h-[calc(100vh-100px)] !p-[5px]
            [&amp;::-webkit-scrollbar]:w-2
            [&amp;::-webkit-scrollbar-track]:rounded-full
            [&amp;::-webkit-scrollbar-thumb]:rounded-full
            [&amp;::-webkit-scrollbar-thumb]:bg-[#5E93DA]
            overflow-y-auto
            ">
            @auth
                <x-nav-dropdown name="Overview">
                    <x-nav-div :href="route('home')" :active="request()->routeIs('home')" class="">
                        <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                            <x-svg.homeprop p="20" l="20" :active="request()->routeIs('home')"></x-svg.homeprop>
                            <p>{{ __('Home') }}</p>
                        </div>
                    </x-nav-div>
                    @if (Auth::user()->hasRole('Admin'))
                        <x-nav-div :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="w-full">
                            <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                                <x-icon.dashboard p="20" l="20" :active="request()->routeIs('dashboard')"></x-icon.dashboard>
                                <p>{{ __('Dashboard') }}</p>
                            </div>
                        </x-nav-div>      
                    @endif
                </x-nav-dropdown>
                @if (Auth::user()->hasAnyRole(['Owner', 'Admin']))
                    <x-nav-dropdown name="Property Management">
                        <x-nav-div :href="route('property')" :active="request()->routeIs('property')" class="w-full">
                            <div class="flex gap-[15px] items-center mx-5 h-full p-[10px]">
                                <x-icon.property p="20" l="20" :active="request()->routeIs('property')"></x-icon.property>
                                <p>{{ __('My Property') }}</p>
                            </div>

                        </x-nav-div>
                        <?php
                            $property_id = View::getSection('property_id');
                        ?>
                        @if (request()->routeIs(['property.detail', 'property.detail.rent.overview', 'property.detail.iuran', 'property.detail.reservation', 'property.detail.task', 'property.detail.transaction', 'property.edit']))
                            <x-nav-div :href="route('property.detail', $property_id)" :active="request()->routeIs('property.detail')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-7 h-full p-[10px]">
                                    <x-icon.homeApp p="20" l="20" :active="request()->routeIs('property.detail')"></x-icon.property>
                                    <p>{{ __('Detail') }}</p>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.calendar', $property_id)" :active="request()->routeIs('property.detail.calendar')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.calendar p="20" l="20" :active="request()->routeIs('property.detail.calendar')"></x-icon.calendar>
                                    <p>{{ __('Calendar') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.rent.overview', $property_id)" :active="request()->routeIs('property.detail.rent.overview')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.rent p="20" l="20" :active="request()->routeIs('property.detail.rent.overview')"></x-icon.property>
                                    <p>{{ __('Rents') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.task', $property_id)" :active="request()->routeIs('property.detail.task')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.task p="20" l="20" :active="request()->routeIs('property.detail.task')"></x-icon.property>
                                    <p>{{ __('Tasks') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.transaction', $property_id)" :active="request()->routeIs('property.detail.transaction')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.transaction p="20" l="20" :active="request()->routeIs('property.detail.transaction')"></x-icon.transaction>
                                    <p>{{ __('Transactions') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.reservation', $property_id)" :active="request()->routeIs('property.detail.reservation')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.booking p="20" l="20" :active="request()->routeIs('property.detail.reservation')"></x-icon.booking>
                                    <p>{{ __('Reservations') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                            <x-nav-div :href="route('property.detail.iuran', $property_id)" :active="request()->routeIs('property.detail.iuran')" class="relative w-full">
                                <div class="flex gap-[15px] items-center mx-5 ml-14 h-full p-[10px]">
                                    <x-icon.iuran p="20" l="20" :active="request()->routeIs('property.detail.iuran')"></x-icon.iuran>
                                    <p>{{ __('Iurans') }}</p>
                                </div>
                                <div class="dark:bg-[#464649] bg-gray-200  w-[1px] h-[calc(100%+10px)] absolute left-[47px] top-1/2 -translate-y-1/2">
                                    <div class="dark:bg-[#464649] bg-gray-200  w-[10px] h-[1px] absolute left-0 top-1/2 -translate-y-1/2">

                                    </div>
                                </div>
                            </x-nav-div>
                        @endif
                    </x-nav-dropdown>
                @endif
                <x-nav-dropdown name="Activity Management">
                    <x-nav-div :href="route('calendar')" :active="request()->routeIs('calendar')" class="w-full">
                        <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                            <x-icon.calendar p="20" l="20" :active="request()->routeIs('calendar')"></x-icon.calendar>
                            <p>{{ __('My Calendar') }}</p>
                        </div>

                    </x-nav-div>
                </x-nav-dropdown>
                <x-nav-dropdown name="Booking">
                    <x-nav-div :href="route('findproperty')" :active="request()->routeIs('findproperty')" class="w-full">
                        <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                            <x-icon.properties p="20" l="20" :active="request()->routeIs('findproperty')"></x-icon.properties>
                            <p>{{ __('Find Properties') }}</p>
                        </div>
                    </x-nav-div>
                    <x-nav-div :href="route('booking')" :active="request()->routeIs('booking')" class="w-full">
                        <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                            <x-icon.booking p="20" l="20" :active="request()->routeIs('booking')"></x-icon.booking>
                            <p>{{ __('My Bookings') }}</p>
                        </div>
                    </x-nav-div>
                    @if (Auth::user()->hasRole('Admin'))
                        <x-nav-div :href="route('all-booking')" :active="request()->routeIs('all-booking')" class="w-full">
                            <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                                <x-icon.booking p="20" l="20" :active="request()->routeIs('all-booking')"></x-icon.booking>
                                <p>{{ __('All Bookings') }}</p>
                            </div>
                        </x-nav-div>
                        <x-nav-div :href="route('all-booking')" :active="request()->routeIs('all-booking')" class="w-full">
                            <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                                <x-icon.transaction p="20" l="20" :active="request()->routeIs('all-booking')"></x-icon.transaction>
                                <p>{{ __('All Transactions') }}</p>
                            </div>
                        </x-nav-div>
                    @endif
                </x-nav-dropdown>
                <x-nav-dropdown name="Communication">
                    <x-nav-div :href="route('chat')" :active="request()->routeIs('chat')" class="w-full">
                        <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                            <x-icon.chat p="20" l="20" :active="request()->routeIs('chat')"></x-icon.chat>
                            <div class="flex">
                                <p>Chats</p><p class="text-[10px] leading-3">Beta</p><p></p>
                            </div>
                        </div>

                    </x-nav-div>
                    <x-nav-div :href="route('contact')" :active="request()->routeIs('contact')" class="w-full">
                        <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                            <x-icon.contact p="20" l="20" :active="request()->routeIs('contact')"></x-icon.contact>
                            <p>{{ __('Contacts') }}</p>
                        </div>

                    </x-nav-div>
                </x-nav-dropdown>
            @endauth
        </div>
    </div>
</nav> 
