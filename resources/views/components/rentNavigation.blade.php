<script>
    $(document).ready(function() {
        let rentContainer = $("#rentContainer");
        let facilityContainer = $("#facilityContainer");
        let property_id = @yield('property_id');
        $.ajax({
            url: getHost() + '/api/rent/byProperty/' + @yield('property_id'),
            type: "GET",
            dataType: "json",
            success: function(response) {
                for (let i = 0; i < response.data.length; i++) {
                    let rent = response.data[i];
                    let rentId = rent['id_rent']
                    rentContainer.append(`
                        <a href="${getHost() + "/view/property/" + property_id + "/overview/rent/" + rentId}">
                            <div class="dark:bg-[#FAFAFA] dark:bg-opacity-10 rounded-lg p-[5px] px-[15px]">
                                <p class="text-black dark:text-gray-300">${rent['rent_name']}</p>
                            </div>
                        </a>
                    `)
                }
            },
            error: function(error) {
                
            }
        })
    })
</script>
<div x-data="{ openedMenu: 'Rent' }" class="flex flex-col gap-2 h-full">
    <div class="h-full w-[300px] bg-[#18181D] border-r-[1px] dark:border-[#464649] border-gray-200 rounded-l-xl pt-[30px] px-[0px] flex flex-col">
         <h3 class=" px-[30px] flex justify-between items-center text-lg font-semibold text-gray-800  dark:text-gray-200">
             <x-a-label x-text="openedMenu"></x-a-label>
             <button 
                 class="w-auto h-auto p-[5px] text-3xl font-bold text-white bg-blue-500 rounded-full shadow-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                 <div class="flex relative justify-center items-center w-full h-full">
                     <a class="text-sm">+ Add New</a>
                 </div>
             </button>
         </h3>
         <div class="flex flex-col h-full">
             <div class="flex overflow-hidden mt-3 px-[15px] gap-[5px]">
                 <button @click="openedMenu = 'Rent'" x-bind:class="openedMenu === 'Rent' ? 'dark:bg-[#1f1f25] dark:bg-opacity-90' : 'hover:dark:bg-[#1f1f25] hover:dark:bg-opacity-40' " class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none"><x-a-label>Rent</x-a-label></button>
                 <button @click="openedMenu = 'Facility'" x-bind:class="openedMenu === 'Facility' ? 'dark:bg-[#1f1f25] dark:bg-opacity-90' : 'hover:dark:bg-[#1f1f25] hover:dark:bg-opacity-40' " class="w-full border-b-0 p-[5px] rounded-xl rounded-b-none"><x-a-label>Facility</x-a-label></button>
             </div>
             <div class="flex-grow dark:bg-[#1f1f25] dark:bg-opacity-90 rounded-bl-xl rounded-t-xl">
                 <div x-show="openedMenu === 'Rent'" class="h-full p-[25px] flex flex-col gap-[10px]" id="rentContainer">
                    <div class="flex gap-[10px]">
                        <x-search placeholder="Search"/>
                        <button class="bg-transparent">
                            <x-icon.filter p=20 l=20 />
                        </button>
                        <button class="bg-transparent">
                            <x-icon.column p=20 l=20 />
                        </button>
                    </div>
                    
                 </div>
                 <div x-show="openedMenu === 'Facility'" class="h-full p-[25px] flex flex-col gap-[10px]" id="facilityContainer">
                    <div class="flex gap-[10px]">
                        <x-search placeholder="Search"/>
                        <button class="bg-transparent">
                            <x-icon.filter p=20 l=20 />
                        </button>
                        <button class="bg-transparent">
                            <x-icon.column p=20 l=20 />
                        </button>
                    </div>  
                 </div>
             </div>
         </div>
    </div>
 </div>