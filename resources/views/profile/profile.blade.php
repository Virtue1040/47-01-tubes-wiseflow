@section('title', '- ' . $user->contactInformation->first_name . ' ' . $user->contactInformation->last_name . ' Profile')
<x-app-layout>
    @php
        function formatNumber($number) {
            if (!is_numeric($number)) {
                return "Invalid number";
            }

            $suffixes = ['', 'K', 'M', 'B', 'T'];
            $index = 0;

            while ($number >= 1000 && $index < count($suffixes) - 1) {
                $number /= 1000;
                $index++;
            }

            $formatted = ($index === 0) ? $number : number_format($number, 1);

            return $formatted . $suffixes[$index];
        }
    @endphp
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Profile') }}
        </h2>
    </x-slot>
    <script>
        $('#contentContainer').css('padding', '0px');
        $('#contentContainer').css('display', 'flex');
    </script>

    <div class="flex sticky top-0 h-full w-fit">
        <div class="flex float-left flex-col gap-2 h-full">
            <div
                class="h-full w-[300px] dark:bg-[#18181B]  bg-white border-r-[1px] shadow-[rgba(0,0,15,0.1)_0px_0px_5px_0px] dark:border-[#272729] border-gray-200 rounded-l-xl px-4">
                <div class="flex flex-col justify-between h-full pt-[30px] pb-[15px]">
                    <div>
                        <div class="py-[10px] px-7 flex flex-col">
                            <x-a-label
                                class="text-2xl font-bold">{{ $user->contactInformation->first_name . ' ' . $user->contactInformation->last_name }}</x-a-label>
                            <x-a-label class="text-sm !text-gray-500">{{ $user->getRoleNames()[0] }}</x-a-label>
                        </div>
                        <div class="mt-2 flex flex-col gap-[10px]">
                            <x-nav-div :href="route('profile.overview', $user->id_user)" :active="request()->routeIs('profile.overview')" class="w-full">
                                <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                                    <x-icon.overview p="20" l="20" :active="request()->routeIs('profile.overview')"></x-icon.overview>
                                    <p>{{ __('Overview') }}</p>
                                </div>
                            </x-nav-div>
                            {{-- <x-nav-div :href="route('profile.property', $user->id_user)" :active="request()->routeIs('profile.property')" class="w-full">
                                <div class="flex gap-[15px] items-center mx-5  h-full p-[10px]">
                                    <x-icon.property p="20" l="20" :active="request()->routeIs('profile.property')"></x-icon.property>
                                    <p>{{ __('Property') }}</p>
                                </div>
                            </x-nav-div> --}}
                        </div>
                    </div>
                    <div class="flex flex-col" name="footer">
                        <div class="flex flex-col gap-[20px] mb-6 px-4">
                            <div class="flex gap-[10px] w-full">
                                <x-icon.location class="!fill-gray-400" p="20" l="20"></x-icon.email>
                                    <p class="text-sm text-gray-400">{{ __('Cikarang') }}</p>
                            </div>
                            <div class="flex gap-[10px] w-full">
                                <x-icon.email class="!fill-gray-400" p="20" l="20"></x-icon.email>
                                <p class="text-sm text-gray-400">{{ $user->contactInformation->email }}</p>
                            </div>
                            <hr class="dark:border-[#464649] border-gray-200 w-full">
                            <div class="flex gap-[10px] w-full items-center">
                                <div class="flex gap-[5px] items-center">
                                    <x-icon.people p="18" l="18"></x-icon.people>
                                    <x-a-label class="ml-1 text-xs">{{ formatNumber(count($user->getFollowers)) }}</x-a-label>
                                    <a class="text-xs !text-gray-400">{{ __('followers') }}</a>
                                </div>
                                <x-a-label class="text-xs font-bold">•</x-a-label>
                                <div class="flex gap-[5px] items-center">
                                    <x-a-label class="text-xs">{{ formatNumber(count($user->getFollowings)) }}</x-a-label>
                                    <a class="text-xs !text-gray-400">{{ __('following') }}</a>
                                </div>
                            </div>
                        </div>
                        <x-primary-button class="flex justify-center">
                            Follow
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <div class="p-[45px] py-[25px] w-full flex gap-[20px] flex-col">
        <div class="flex gap-[20px]">
            <x-box-dropdown padding="0px" name='null' class="w-fit h-fit">
                <div
                    class="flex overflow-hidden flex-grow-0 flex-shrink-0 justify-center items-center w-[250px] h-[250px] bg-white rounded-2xl">
                    <img onerror="$(this).parent().find('a').text('{{ substr($user->contactInformation->first_name, 0, 1) }}'); $(this).css('display', 'none')"
                        src="@php echo $user->contactInformation->profilePath == null ? $user->social_avatar : asset($user->contactInformation->profilePath) @endphp"
                        class="w-full h-full">
                    <a class="text-black"></a>
                </div>
            </x-box-dropdown>
            <x-box-dropdown class="flex flex-col w-full gap-[10px] h-full" name='null'>
                <x-a-label class="text-xl font-bold">Hallo!</x-a-label>
                <br><br>
                <x-a-label class="truncate text-md text-wrap">{{ $user->contactInformation->description }}</x-a-label>
            </x-box-dropdown>
        </div>
        <div class="flex gap-[20px] h-auto pb-6">
            @if (count($user->getProperty) > 0)
                <x-box-dropdown class="flex flex-col w-full gap-[20px]" name='null'>
                    <x-a-label class="text-xl font-bold">Property</x-a-label>
                    <div class="flex gap-[15px] flex-col mt-4">
                        @foreach ($user->getProperty as $property)
                            <div class="flex flex-col w-full">
                                <div class="dark:bg-[#09090B] dark:bg-opacity-50 bg-gray-100 rounded-t-2xl overflow-hidden">
                                    <div class="flex w-full gap-[15px] p-3 border-gray-200 dark:border-[#272729] border-[1px] bg-white h-[150px] dark:bg-[#18181B] rounded-2xl">
                                        <div class="flex flex-row gap-[15px] w-full">
                                            <div class="flex-shrink-0 h-full">
                                                <img src="{{ asset('storage/' . $property->album->imagePath) }}" alt="Cover Property" class="object-cover w-[124px] h-full rounded-xl">
                                            </div>
                                            <div class="flex flex-col justify-between w-full h-full">
                                                <div class="flex flex-col gap-[10px] w-full">
                                                    <div class="flex justify-between w-full">
                                                        <x-a-label>{{ $property->property_name }}</x-a-label>
                                                        @if ($property->getAvailabelityBasedOnRent())
                                                            <p class="bg-[#5eda73] py-[5px] text-xs px-[10px]  text-white w-fit rounded-full align-middle">Available</p>
                                                        @else
                                                            <p class="bg-red-600 py-[5px] text-xs px-[10px]  text-white w-fit rounded-full align-middle">Not Available</p>
                                                        @endif
                                                    </div>
                                                    
                                                    <x-a-label class="text-sm !text-gray-400 truncate">{{ $property->property_address->street_name }}</x-a-label>
                                                    <p class="bg-[#5E93DA] py-[5px] text-xs px-[10px]  text-white w-fit rounded-full align-middle">{{ $property->property_category }}</p>
                                                </div>
                                                <div class="flex justify-between">
                                                    <div class="flex gap-[10px]">
                                                        <div class="flex gap-[10px] items-center">
                                                            <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                                                <x-icon.eye p="20" l="20"/>
                                                            </div>
                                                            <x-a-label class="text-sm">{{ $property->getView->count() }}</x-a-label>
                                                        </div>
                                                        <div class="flex gap-[10px] items-center">
                                                            <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                                                <x-icon.love p="20" l="20"/>
                                                            </div>
                                                            <x-a-label class="text-sm">{{ $property->getFavorite->count()  }}</x-a-label>
                                                        </div>
                                                        <div class="flex gap-[10px] items-center">
                                                            <div class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                                                <x-icon.chat p="20" l="20"/>
                                                            </div>
                                                            <x-a-label class="text-sm">{{ $property->getComment->count() }}</x-a-label>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        @if ($property->getPriceRange() !== null)
                                                            @php
                                                                $rangePrice = $property->getPriceRange();
                                                                
                                                                $maxPrice = number_format($rangePrice['max'], 2, ",", ".");
                                                                $minPrice = number_format($rangePrice['min'], 2, ",", ".");
                                                                $totalText = $minPrice === $maxPrice || $maxPrice === null ? $minPrice : $minPrice . ' ~ ' . $maxPrice;
                                                            @endphp
                                                            <x-a-label>IDR {{ $totalText }}</x-a-label>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="flex gap-[10px] w-[100%] items-center">
                                                        <div class="dark:bg-[#464649] rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                                            <x-icon.rent p="20" l="20"/>
                                                        </div>
                                                        <x-a-label class="text-sm">2</x-a-label>
                                                    </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex w-full justify-between gap-[15px] items-center p-3 bg-gray-100 h-[40px] dark:bg-[#09090B] dark:bg-opacity-50 rounded-b-2xl">
                                    <div>
                                        <x-a-label class="text-sm !text-gray-400">Added {{ date("d M, Y", strtotime($property->created_at)) }}</x-a-label>
                                    </div>
                                    <button onclick="window.location.href='{{ route('property.profile', $property->id_property) }}'" class="hover:bg-gray-100 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 rounded-xl p-1 cursor-pointer px-2">
                                        <div class=" flex gap-[10px]">
                                            <x-icon.eye p="20" l="20"/>
                                            <x-a-label class="text-sm">Show Details</x-a-label>
                                        </div>
                                    </button>  
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-box-dropdown>
            @endif
            <div class="@if (count($user->getProperty) <= 0))
                w-[100%]
                @else
                w-[40%]
                @endif h-fit">
                @if ($user->hasAnyRole(['Owner', 'Admin']) && count($user->getProperty) > 0)
                    <x-box-dropdown class="flex flex-col gap-[10px] h-[300px]" name='null'>
                        <x-a-label class="text-xl font-bold">Reviews</x-a-label>
                        <div class="flex flex-col justify-center p-4">
                            <div class="flex gap-[5px] items-center justify-center mt-4">
                                <x-a-label class="text-[58px]">{{ $user->getAvgRatings() + 0 }}</x-a-label>
                                <x-icon.star p="58" l="58" filled/>
                            </div>
                            <x-a-label class="mx-auto w-full text-center">(from {{ $user->getTotalComment() }} votes)</x-a-label>
                        </div>
                    </x-box-dropdown>
                @endif
                </div>
            </div>
                
    </div>
    {{-- <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
