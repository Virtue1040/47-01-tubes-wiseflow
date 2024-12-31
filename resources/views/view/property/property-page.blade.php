@section('title', '- Property Profile')
<x-app-layout>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env("MIDTRANS_CLIENT_KEY") }}"></script>
    <link rel="stylesheet" href={{ asset('css/style.css') }}>
    <script>
        $('#contentContainer').css('padding', '0px');
        $(document).ready(function() {
            let map
            let long = "{{ $property->getLongLat()['long'] }}"
            let lat = "{{ $property->getLongLat()['lat'] }}"
            map = setupMap('map', long, lat);
            const geocoder = new MapboxGeocoder({
                accessToken: mapboxgl.accessToken,
                mapboxgl: mapboxgl
            });
            const marker = new mapboxgl.Marker()
                .setLngLat([long, lat])
                .addTo(map);
        })

        function showRent(rent_id) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("booking", [{
                    icon: 'detail',
                    title: 'Detail'
                },
                {
                    icon: 'book',
                    title: 'Booking'
                }
            ], [
                `
                        <div>
                            <input type="hidden" name="id_rent"/>
                            <div class="flex gap-4">
                                <div class="flex flex-col gap-2 w-full h-full">
                                    <x-a-label class="text-xl font-bold" name="rent_name">Nama Rent</x-a-label>
                                    <x-a-label class="text-md" name="rent_description">Description</x-a-label>
                                </div>
                                <div class="flex flex-col w-full h-full">
                                    <div class="justify-between w-full">
                                        <div class="cd-slider-wrapper !w-full !m-0 h-full">
                                                <ul class="flex w-full h-full cd-slider"
                                                    data-step1="M1402,800h-2V0h1c0.6,0,1,0.4,1,1V800z"
                                                    data-step2="M1400,800H379L771.2,0H1399c0.6,0,1,0.4,1,1V800z"
                                                    data-step3="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z"
                                                    data-step4="M-2,800h2V0h-1c-0.6,0-1,0.4-1,1V800z"
                                                    data-step5="M0,800h1021L628.8,0L1,0C0.4,0,0,0.4,0,1L0,800z"
                                                    data-step6="M0,800h1400V0L1,0C0.4,0,0,0.4,0,1L0,800z" name="imageContainer">
                                                    
                                                </ul>
            
                                                <ul class="cd-slider-navigation">
                                                    <li><a href="#0" class="next-slide">Next</a></li>
                                                    <li><a href="#0" class="prev-slide">Prev</a></li>
                                                </ul>
            
                                                <ol class="cd-slider-controls" name="controlContainer">
                                                    <li class="selected"><a href="#0"><em>Item 1</em></a></li>
                                                    
                                                </ol>
            
                                        </div>
                                        <div class="flex gap-2 mt-4" name="rentTagContainer">
                                        </div>
                                    </div>
                                    <x-a-label class="mt-6 text-lg font-bold text-right" name="rent_price">IDR 100000</x-a-label>
                                </div>
                            </div>
                        </div>
                    `,
                `
                        <div>
                            <div class="hidden justify-center items-center w-full h-full" id="snap-container">
                            </div>
                            <div name="checking">
                                <x-input-label for="checkin">Check In <a class="text-red-700">*</a></x-input-label>
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-text-input id="checkin" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Checkin Date"  type="date" name="checkin_date"
                                            :value="old('checkin_date')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('checkin')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-text-input id="checkin" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Checkin Time"  type="time" name="checkin_time"
                                            :value="old('checkin_time')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('checkin_time')" class="mt-1" />
                                </div>
                                <br>
                                <x-input-label for="checkout">Check Out <a class="text-red-700">*</a></x-input-label>
                                <div class="flex justify-between gap-[15px] ">
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-text-input id="checkout" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Checkout Date"  type="date" name="checkout_date"
                                            :value="old('checkout_date')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('checkout')" class="mt-1" />
                                    <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-text-input id="checkout" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Checkout Time"  type="time" name="checkout_time"
                                            :value="old('checkout_time')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('checkout_time')" class="mt-1" />
                                </div>
                            </div>
                        </div>
                `,
            ], {
                2: ['checkin_date', 'checkin_time', 'checkout_date', 'checkout_time'],
            }, {
                lastButton: "Book Rent",
                onCreate: function(form, div) {
                    let controlContainer = form.find('[name="controlContainer"]');
                    let imageContainer = form.find('[name="imageContainer"]');
                    let rentTagContainer = form.find('[name="rentTagContainer"]');
                    let rent_name = form.find('[name="rent_name"]');
                    let rent_description = form.find('[name="rent_description"]');
                    let rent_price = form.find('[name="rent_price"]');
                    let id_rent = form.find('[name="id_rent"]');
                    let checking = form.find('[name="checking"]');
                    let snapcontainer = form.find('#snap-container');
                    $.ajax({
                        url: "/api/rent/" + rent_id,
                        type: "GET",
                        success: function(response) {
                            if (response.success) {
                                let data = response.data
                                let album = data.album;
                                let rentTag = data.get_rent_tag;
                                let rentTagHTML = "";

                                console.log(rent_name);
                                console.log(data);

                                rentTag.forEach((tag) => {
                                    rentTagHTML +=
                                        `<p class="bg-[#5E93DA] py-[5px] text-xs px-[10px]  text-white w-fit rounded-full align-middle">${tag.tag}</p>`;
                                });
                                
                                rentTagContainer.append(rentTagHTML);
                                rent_name.html(data.rent_name);
                                rent_description.html(data.rent_desc);
                                rent_price.html(`IDR ${data.rent_price}`);
                                id_rent.val(data.id_rent);
                                
                                if (album !== null) {
                                    album.forEach((albums, index) => {
                                        imageContainer.append(`
                                                <li class="${index === 0 ? 'visible' : ''} w-full h-full">
                                                    <div class="w-full h-full bg-white bg-opacity-10 cd-svg-wrapper">
                                                        <svg viewBox="0 0 1400 800">
                                                            <defs>
                                                                <clipPath id="cd-image-${index + 1}">
                                                                    <path id="cd-changing-path-${index + 1}"
                                                                        d="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z" />
                                                                </clipPath>
                                                            </defs>
    
                                                            <image height='100%' width="100%"
                                                                clip-path="url(#cd-image-${index + 1})"
                                                                xlink:href="{{ asset('storage/') }}/${albums.imagePath}">
                                                            </image>
                                                        </svg>
                                                    </div>
                                                </li>
                                            `);
                                        if (index != 0) {
                                            controlContainer.append(`
                                                <li><a href="#0"><em>Item ${controlContainer.children().length + 1}</em></a></li>
                                            `);
                                        }
                                    })
                                } else {
                                    imageContainer.append(`
                                                <li class="visible w-full h-full">
                                                    <div class="w-full h-full bg-white bg-opacity-10 cd-svg-wrapper">
                                                        <svg viewBox="0 0 1400 800">
                                                            <defs>
                                                                <clipPath id="cd-image-1">
                                                                    <path id="cd-changing-path-1"
                                                                        d="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z" />
                                                                </clipPath>
                                                            </defs>
    
                                                            <image height='100%' width="100%"
                                                                clip-path="url(#cd-image-1)"
                                                                xlink:href="{{ asset('img/placeholder.png') }}">
                                                            </image>
                                                        </svg>
                                                    </div>
                                                </li>
                                            `);
                                }
                            }
                        }
                    })
                    form.on("submit", function() {
                        event.preventDefault();
                        let data = form.serialize();
                        $.ajax({
                            url: "/api/booking",
                            type: "POST",
                            data: data,
                            success: function(response) {
                                if (response.success) {
                                    checking.addClass('hidden');
                                    snapcontainer.removeClass('hidden');
                                    snapcontainer.addClass('flex');
                                    let buttonContinue = div.find("button[name='continue']");
                                    let buttonBack = div.find("button[name='back']");
                                    buttonBack.addClass("hidden");
                                    buttonContinue.addClass("hidden");
                                    window.snap.embed(response.token, {
                                        embedId: 'snap-container',
                                        onSuccess: function (result) {
                                            alert("payment success!"); console.log(result);
                                        },
                                        onPending: function (result) {
                                       
                                            alert("wating your payment!"); console.log(result);
                                        },
                                        onError: function (result) {
                                        
                                            alert("payment failed!"); console.log(result);
                                        },
                                        onClose: function () {
                                        
                                            alert('you closed the popup without finishing the payment');
                                        }
                                    });
                                    $("#snap-midtrans").css("width", "564px");
                                    $("#snap-midtrans").addClass("w-[564px]");
                                } else {

                                }
                            }
                        })
                    })
                    createBounced = false;
                },
            })
        }
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __($property->property_name . ' - Profile') }}
        </h2>
    </x-slot>

    <div class="flex flex-col gap-[25px] mt-4">
        <div class="p-6 max-w-[65%] w-full mx-auto mt-2">
            <div class="w-full  h-[180px] p-1 flex gap-4">
                <div class="w-[250px] h-full">
                    <img src="{{ asset('storage/') }}/{{ $property->album->imagePath }}"
                        onerror="$(this).attr('src', '{{ asset('img/placeholder.png') }}')" alt="Cover Property"
                        class="object-cover w-full h-full rounded-xl">
                </div>
                <div class="flex flex-col justify-center gap-[2px] w-full h-full">
                    <x-a-label class="text-[32px] font-bold">{{ $property->property_name }}</x-a-label>
                    <x-a-label class="font-bold text-md">{{ $property->getLocation() }}</x-a-label>
                    <div class="flex gap-[10px] mt-6">
                        <div class="flex gap-[10px] items-center">
                            <div
                                class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                <x-icon.eye p="20" l="20" />
                            </div>
                            <x-a-label class="text-sm">{{ $property->getView->count() }}</x-a-label>
                        </div>
                        <div class="flex gap-[10px] items-center">
                            <div
                                class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                <x-icon.love p="20" l="20" />
                            </div>
                            <x-a-label class="text-sm">{{ $property->getFavorite->count() }}</x-a-label>
                        </div>
                        <div class="flex gap-[10px] items-center">
                            <div
                                class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                <x-icon.chat p="20" l="20" />
                            </div>
                            <x-a-label class="text-sm">{{ $property->getComment->count() }}</x-a-label>
                        </div>
                        <div class="flex gap-[10px] items-center">
                            <div
                                class="dark:bg-[#464649] bg-gray-100 rounded-full w-[25px] h-[25px] flex justify-center items-center p-1">
                                <x-icon.rent p="20" l="20" />
                            </div>
                            <x-a-label class="text-sm">{{ $property->rent->count() }}</x-a-label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div x-data="{ openedMenu: 'Profile' }">
            <div
                class=" h-full w-full dark:bg-[#18181B]  bg-[#f0f0f3] border-r-[1px] shadow-[rgba(0,0,15,0.1)_0px_0px_5px_0px] dark:border-[#272729] border-gray-200 rounded-l-xl pt-[20px] px-[0px] flex flex-col">
                <div class="flex flex-col items-center h-full">
                    <div class="flex overflow-hidden mt-3 w-full  max-w-[62%] gap-[5px] flex-shrink-0">
                        <button @click="openedMenu = 'Profile'"
                            x-bind:class="openedMenu === 'Profile' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                                'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                            class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none "><a
                                class="text-black dark:text-gray-300">
                                Property Profile
                            </a>
                        </button>
                        <button @click="openedMenu = 'Group'"
                            x-bind:class="openedMenu === 'Group' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                                'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                            class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none  "><a
                                class="text-black dark:text-gray-300">
                                Description
                            </a>
                        </button>
                    </div>
                    <div
                        class="flex flex-col h-[320px] w-full items-center rounded-t-xl rounded-bl-xl dark:bg-[#27272a] bg-white dark:bg-opacity-30">
                        <div x-show="openedMenu === 'Profile'"
                            class="h-full p-[25px] px-0 max-w-[62%] w-full pb-[30px]">
                            <div class="flex gap-[25px] w-full h-full">
                                <div class="cd-slider-wrapper !w-full !m-0 h-full">
                                    <ul class="flex w-full h-full cd-slider"
                                        data-step1="M1402,800h-2V0h1c0.6,0,1,0.4,1,1V800z"
                                        data-step2="M1400,800H379L771.2,0H1399c0.6,0,1,0.4,1,1V800z"
                                        data-step3="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z"
                                        data-step4="M-2,800h2V0h-1c-0.6,0-1,0.4-1,1V800z"
                                        data-step5="M0,800h1021L628.8,0L1,0C0.4,0,0,0.4,0,1L0,800z"
                                        data-step6="M0,800h1400V0L1,0C0.4,0,0,0.4,0,1L0,800z">
                                        <li class="visible w-full h-full">
                                            <div class="w-full h-full bg-white bg-opacity-10 cd-svg-wrapper">
                                                <svg viewBox="0 0 1400 800">
                                                    <defs>
                                                        <clipPath id="cd-image-1">
                                                            <path id="cd-changing-path-1"
                                                                d="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z" />
                                                        </clipPath>
                                                    </defs>

                                                    <image height='100%' width="100%" clip-path="url(#cd-image-1)"
                                                        xlink:href="{{ asset('storage/') }}/{{ $property->getAlbum->first()->imagePath }}">
                                                    </image>
                                                </svg>
                                            </div>
                                        </li>
                                        @for ($i = 2; $i <= count($property->getAlbum); $i++)
                                            <li class="w-full h-full">
                                                <div class="w-full h-full bg-white bg-opacity-10 cd-svg-wrapper">
                                                    <svg viewBox="0 0 1400 800">
                                                        <defs>
                                                            <clipPath id="cd-image-{{ $i }}">
                                                                <path id="cd-changing-path-{{ $i }}"
                                                                    d="M1400,800H0V0h1399c0.6,0,1,0.4,1,1V800z" />
                                                            </clipPath>
                                                        </defs>

                                                        <image height='100%' width="100%"
                                                            clip-path="url(#cd-image-{{ $i }})"
                                                            xlink:href="{{ asset('storage/') }}/{{ $property->getAlbum[$i - 1]->imagePath }}">
                                                        </image>
                                                    </svg>
                                                </div>
                                            </li>
                                        @endfor
                                    </ul>

                                    <ul class="cd-slider-navigation">
                                        <li><a href="#0" class="next-slide">Next</a></li>
                                        <li><a href="#0" class="prev-slide">Prev</a></li>
                                    </ul>

                                    <ol class="cd-slider-controls">
                                        <li class="selected"><a href="#0"><em>Item 1</em></a></li>
                                        @for ($i = 2; $i <= count($property->getAlbum); $i++)
                                            <li><a href="#0"><em>Item {{ $i }}</em></a></li>
                                        @endfor
                                    </ol>
                                </div>
                                <div id="map" class="w-full h-[100%] bg-white rounded-xl">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 max-w-[64%] w-full mx-auto mt-2">
            <div class="w-full">
                <x-a-label class="text-xl font-bold">The Property</x-a-label><br>
                <x-a-label class="!text-gray-400 text-md">Detailed data about this property</x-a-label>
                <div class="flex gap-6 mt-8 w-full">
                    <x-box-dropdown class="w-[70%] h-full" name="Property details">
                        <div class="flex justify-between">
                            <div class="flex flex-col gap-[30px]">
                                <div>
                                    <x-a-label class="!text-gray-400">Propery type</x-a-label><br>
                                    <x-a-label class="mt-4">{{ $property->property_category }}</x-a-label>
                                </div>
                                <div>
                                    <x-a-label class="!text-gray-400">Propery type</x-a-label><br>
                                    <x-a-label class="mt-4">{{ $property->property_category }}</x-a-label>
                                </div>
                            </div>
                            <div class="flex flex-col gap-[30px]">
                                <div>
                                    <x-a-label class="!text-gray-400">Propery type</x-a-label><br>
                                    <x-a-label class="mt-4">{{ $property->property_category }}</x-a-label>
                                </div>
                                <div>
                                    <x-a-label class="!text-gray-400">Propery type</x-a-label><br>
                                    <x-a-label class="mt-4">{{ $property->property_category }}</x-a-label>
                                </div>
                            </div>
                        </div>
                    </x-box-dropdown>
                    <x-box-dropdown class="w-full" name="Rents">
                        <div class="flex gap-[15px] flex-col">
                            @foreach ($property->rent as $rent)
                                <div class="flex flex-col w-full">
                                    <div
                                        class="dark:bg-[#09090B] dark:bg-opacity-50 bg-gray-100 rounded-t-2xl overflow-hidden">
                                        <div
                                            class="flex w-full gap-[15px] p-3 border-gray-200 dark:border-[#272729] border-[1px] bg-white h-[150px] dark:bg-[#18181B] rounded-2xl">
                                            <div class="flex flex-row gap-[15px] w-full">
                                                <div class="flex-shrink-0 h-full">
                                                    <img onerror="this.src='{{ asset('img/placeholder.png') }}'"
                                                        src="{{ asset('storage/' . ($rent->album !== null ? $rent->album->imagePath : '')) }}"
                                                        alt="Cover Property"
                                                        class="object-cover w-[124px] h-full rounded-xl">
                                                </div>
                                                <div class="flex flex-col justify-between w-full h-full">
                                                    <div class="flex flex-col gap-[10px] w-full">
                                                        <div class="flex justify-between w-full">
                                                            <x-a-label>{{ $rent->rent_name }}</x-a-label>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            @foreach ($rent->getRentTag as $rentTag)
                                                                <p
                                                                    class="bg-[#5E93DA] py-[5px] text-xs px-[10px]  text-white w-fit rounded-full align-middle">
                                                                    {{ $rentTag->tag }}</p>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-between">
                                                        <div>
                                                            @php
                                                                $price = number_format($rent->rent_price, 2, ',', '.');
                                                            @endphp
                                                            <x-a-label>IDR {{ $price }}</x-a-label>
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
                                    <div
                                        class="flex w-full justify-between gap-[15px] items-center p-3 bg-gray-100 h-[40px] dark:bg-[#09090B] dark:bg-opacity-50 rounded-b-2xl">
                                        <div>
                                            <x-a-label class="text-sm !text-gray-400">Added {{ date('d M, Y', strtotime($rent->created_at)) }}</x-a-label>
                                        </div>
                                        <button onclick="showRent({{ $rent->id_rent }})"
                                            class="hover:bg-gray-100 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 rounded-xl p-1 cursor-pointer px-2">
                                            <div class=" flex gap-[10px]">
                                                <x-icon.eye p="20" l="20" />
                                                <x-a-label class="text-sm">Show Details</x-a-label>
                                            </div>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-box-dropdown>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
