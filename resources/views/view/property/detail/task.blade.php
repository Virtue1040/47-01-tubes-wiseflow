@section('property_name', $property->property_name)
@section('property_id', $property->id_property)
@section('title', '- Task Management')

<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#task-list'), 'task', {
                'id_task': 'ID Task',
                'full_name': 'Name',
                'task_name': 'Task Name',
                'task_desc': 'Task Description',
                'rent_name': 'Rent Name',
            }, {
                "useAction": true,
                onEdit: function(data) {
                    editTask(data);
                },
                onDelete: function(data) {
                    askConfirmation('task/' + data.id_task, 'DELETE', [],
                        'Are you sure you want to delete this Task?');
                },
            });
            // handle_itemlist($('#iuran-list'), 'iuran',{
            //     'id_iuran': 'ID Iuran',
            //     'property_name': 'Property',
            //     'type_iuran': 'Type Iuran',
            //     'status': 'Status',
            //     'tenggat_iuran': 'Tenggat Iuran',
            // }, {});
        })

        function createTask() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("task", [{
                icon: 'detail',
                title: 'Select Rent'
            }, {
                title: "Create Task"
            }], [
                `
    
                        <div x-data="{ selectedRent: '' }" class="overflow-x-hidden hidden border-[1px] mt-2 border-gray-200 dark:border-[#464649] w-full rounded-xl dark:bg-[#18181B] bg-white flex p-2 flex-col gap-[15px] max-h-[205px] overflow-y-auto
                                                    [&::-webkit-scrollbar]:w-[2px]
                                                    [&::-webkit-scrollbar-track]:rounded-full
                                                    [&::-webkit-scrollbar-thumb]:rounded-full
                                                    [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]" name="select_container">
                                                    <input type="hidden" name="id_rent" id="id_rent">
                            @foreach ($property->rent as $rent)
                                <div onclick="$('#id_rent').val({{ $rent->id_rent }}).change()" @click="selectedRent='{{ $rent->id_rent }}'" x-bind:class="selectedRent == '{{ $rent->id_rent }}' ? '!bg-white !bg-opacity-10' : 'hover:bg-white hover:bg-opacity-10'" class="w-[135px] h-full flex flex-col justify-center cursor-pointer  rounded-xl p-2">
                                    <img onerror="this.src='{{ asset('img/placeholder.png') }}'"
                                                            src="{{ asset('storage/' . ($rent->album !== null ? $rent->album->imagePath : '')) }}"
                                                            alt="Cover Property"
                                                            class="object-cover w-[125px] h-[125px] rounded-xl">
                                    <x-a-label>{{ $rent->rent_name }}</x-a-label>
                                </div>
                            @endforeach
                        </div>
               
                `
                ,
                `       
                        
                            <div class="grid grid-cols-2 gap-6">
                                <input type="hidden" name="id_property" value="{{ $property->id_property }}">
                                <!-- User Name -->
                                <div class="mt-3">
                                    <input type="hidden" name="id_user">
                                        <div class="relative">
                                            <label class="text-black dark:text-gray-300" for="search_user">Search User <a class="text-red-700">*</a> </label>
                                            <input value="" autocomplete="off"   class="border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md  block mt-2 w-full h-full bg-gray-200" style=";" id="search_user" placeholder="Search User by Name" type="text" name="search_user" autofocus="autofocus">
                                            <div class="overflow-x-hidden hidden border-[1px] border-gray-200 dark:border-[#464649] w-full mt-2 rounded-xl dark:bg-[#18181B] bg-white flex p-2 flex-col gap-[15px] absolute top-100% left-0 max-h-[205px] overflow-y-auto
                                                [&::-webkit-scrollbar]:w-[2px]
                                                [&::-webkit-scrollbar-track]:rounded-full
                                                [&::-webkit-scrollbar-thumb]:rounded-full
                                                [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]" name="search_user">
                                                
                                            </div>
                                        </div>
                                </div>
                                <x-input-error :messages="$errors->get('id_user')" class="mt-1" />
                                
                                <!-- Task Name -->
                                <div class="mt-3">
                                    <label for="task_name" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Task Name <a class="text-red-700">*</a>
                                    </label>
                                    <x-text-input placeholder="Task name" name="task_name" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="task_name" required/>
                                </div>
                                <x-input-error :messages="$errors->get('task_name')" class="mt-1" />
                                    
                                <!-- Task Desc -->
                                <div class="mt-3">
                                    <label for="task_desc" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Task Description <a class="text-red-700">*</a> 
                                    </label>
                                    <x-text-area placeholder="Task Description" name="task_desc" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="task_desc" required/>
                                </div>
                                <x-input-error :messages="$errors->get('task_desc')" class="mt-1" />
                            </div>
                        
                    `,
            ], {
                1: ["id_rent"],
                2: ["id_user", "task_name", "task_desc"]
            }, {
                lastButton: "Create Task",
                onCreate: function(form) {
                    let input = $(form).find("input[name='search_user']");
                    input.onPause(function() {
                        let search = $(this).val();
                        $.ajax({
                            url: "/api/user/search",
                            type: 'GET',
                            data: {
                                q: search,
                                id_rent: form.find('input[name="id_rent"]').val()
                            },
                            success: function(response) {
                                if (response.success) {
                                    let searchUser = $(form).find('div[name="search_user"]');
                                    searchUser.empty();
                                    searchUser.removeClass("hidden");
                                    response.data.forEach(user => {
                                        let userElement = $(`
                                            <div class="p-1 rounded-lg dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 hover:bg-gray-100 flex items-center gap-[10px] cursor-pointer" >
                                                <div class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden">
                                                    <img onerror="let getFirst = '${user.name}'; $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')" class="w-[35px] h-[35px]">
                                                    <a class="text-black"></a>
                                                </div>
                                                <div class="flex flex-col truncate">
                                                    <div class="flex gap-[5px] items-center">
                                                        <a class="text-sm text-black dark:text-gray-300">
    ${user.name}
</a>
                                                        <span class="flex  justify-center items-center p-2 w-auto h-[20px] bg-[#5E93DA] rounded-lg"><a class="text-xs text-white">ID:${user.id_user}</a></span>
                                                    </div>
                                                    <a class="text-black dark:text-gray-300 text-xs !text-gray-500 w-full">
    ${user.email}
</a>
                                                </div>
                                            </div>
                                        `);
                                        userElement.click(function() {
                                            $(form).find(
                                                    'input[name="id_user"]')
                                                .val(user.id_user);
                                            $(form).find(
                                                'input[name="search_user"]'
                                                ).val(user.name);
                                            searchUser.empty();
                                            searchUser.addClass("hidden");
                                        })
                                        userElement.find('img').attr('name', user
                                            .name);
                                        userElement.find('img').attr('src', user
                                            .profile ? user.profile : 's');
                                        searchUser.append(userElement);
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        });
                    }, 100);
                    createBounced = false;
                },
            })
        }

        function editTask(data) {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("task/" + data.id_task, [{
                title: "Edit Task"
            }], [
                `       
                        
                            <div class="grid grid-cols-2 gap-6">
                                @method("PUT")
                                <input type="hidden" value="${data.id_rent}" name="id_rent" id="id_rent">
                                <input type="hidden" name="id_property" value="{{ $property->id_property }}">
                                <!-- User Name -->
                                <div class="mt-3">
                                    <input type="hidden" value="${data.id_user}" name="id_user">
                                        <div class="relative">
                                            <label class="text-black dark:text-gray-300" for="search_user">Search User <a class="text-red-700">*</a> </label>
                                            <input value="${data.full_name}" autocomplete="off"   class="border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md  block mt-2 w-full h-full bg-gray-200" style=";" id="search_user" placeholder="Search User by Name" type="text" name="search_user" autofocus="autofocus">
                                            <div class="overflow-x-hidden hidden border-[1px] border-gray-200 dark:border-[#464649] w-full mt-2 rounded-xl dark:bg-[#18181B] bg-white flex p-2 flex-col gap-[15px] absolute top-100% left-0 max-h-[205px] overflow-y-auto
                                                [&::-webkit-scrollbar]:w-[2px]
                                                [&::-webkit-scrollbar-track]:rounded-full
                                                [&::-webkit-scrollbar-thumb]:rounded-full
                                                [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]" name="search_user">
                                                
                                            </div>
                                        </div>
                                </div>
                                <x-input-error :messages="$errors->get('id_user')" class="mt-1" />
                                
                                <!-- Task Name -->
                                <div class="mt-3">
                                    <label for="task_name" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Description
                                    </label>
                                    <x-text-input values="${data.task_name}" placeholder="Task name" name="task_name" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="task_name" required/>
                                </div>
                                <x-input-error :messages="$errors->get('task_name')" class="mt-1" />
                                    
                                <!-- Task Desc -->
                                <div class="mt-3">
                                    <label for="task_desc" class="block mb-1 text-gray-700 dark:text-gray-200">
                                        Iuran Description
                                    </label>
                                    <x-text-area placeholder="Task Description" name="task_desc" class="block mt-2 h-[150px] w-full h-full bg-gray-200" id="task_desc" required>${data.task_desc}</x-text-area> 
                                </div>
                                <x-input-error :messages="$errors->get('task_desc')" class="mt-1" />
                            </div>
                        
                    `,
            ], {

            }, {
                lastButton: "Edit Task",
                onCreate: function(form) {
                    let input = $(form).find("input[name='search_user']");
                    
                    input.onPause(function() {
                        let search = $(this).val();
                        $.ajax({
                            url: "/api/user/search",
                            type: 'GET',
                            data: {
                                q: search,
                                id_rent: form.find('input[name="id_rent"]').val()
                            },
                            success: function(response) {
                                if (response.success) {
                                    let searchUser = $(form).find('div[name="search_user"]');
                                    searchUser.empty();
                                    searchUser.removeClass("hidden");
                                    response.data.forEach(user => {
                                        let userElement = $(`
                                            <div class="p-1 rounded-lg dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 hover:bg-gray-100 flex items-center gap-[10px] cursor-pointer" >
                                                <div class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden">
                                                    <img onerror="let getFirst = '${user.name}'; $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')" class="w-[35px] h-[35px]">
                                                    <a class="text-black"></a>
                                                </div>
                                                <div class="flex flex-col truncate">
                                                    <div class="flex gap-[5px] items-center">
                                                        <a class="text-sm text-black dark:text-gray-300">
    ${user.name}
</a>
                                                        <span class="flex  justify-center items-center p-2 w-auto h-[20px] bg-[#5E93DA] rounded-lg"><a class="text-xs text-white">ID:${user.id_user}</a></span>
                                                    </div>
                                                    <a class="text-black dark:text-gray-300 text-xs !text-gray-500 w-full">
    ${user.email}
</a>
                                                </div>
                                            </div>
                                        `);
                                        userElement.click(function() {
                                            $(form).find(
                                                    'input[name="id_user"]')
                                                .val(user.id_user);
                                            $(form).find(
                                                'input[name="search_user"]'
                                                ).val(user.name);
                                            searchUser.empty();
                                            searchUser.addClass("hidden");
                                        })
                                        userElement.find('img').attr('name', user
                                            .name);
                                        userElement.find('img').attr('src', user
                                            .profile ? user.profile : 's');
                                        searchUser.append(userElement);
                                    });
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        });
                    }, 100);
                    createBounced = false;
                },
            })
        }
    </script>
    
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Task Management') }}
        </h2>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        <x-card.list-item id="task-list" />
        {{-- <table class="overflow-hidden min-w-full bg-white rounded-lg shadow-md">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Email</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Room Number</th>
                    <th class="px-4 py-2 text-left">Booking Number</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">Charlotte Clark</td>
                    <td class="px-4 py-2 border">Charlotte@gmail.com</td>
                    <td class="px-4 py-2 border">-</td>
                    <td class="px-4 py-2 border">101</td>
                    <td class="px-4 py-2 border">BDC-5d017f...</td>
                    <td class="px-4 py-2 border"><a href="#" class="text-blue-600">View/Edit Profile</a></td>
                </tr>
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-2 border">William Smith</td>
                    <td class="px-4 py-2 border">Smith452@outlook.com</td>
                    <td class="px-4 py-2 border">-</td>
                    <td class="px-4 py-2 border">102</td>
                    <td class="px-4 py-2 border">BDC-38760...</td>
                    <td class="px-4 py-2 border"><a href="#" class="text-blue-600">View/Edit Profile</a></td>
                </tr>
            </tbody>
        </table> --}}
                <!-- Button to trigger modal -->
                <div class="mt-6">
                    <x-primary-button onclick="createTask();" type="button"
                        class="px-4 py-2 text-white bg-[#5E93DA] rounded-lg ">
                        Add Task
                    </x-primary-button>
                </div>
    </div>
</x-app-layout>
