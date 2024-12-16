<x-app-layout>
    <script>
        $(document).ready(function() {
            handle_itemlist($('#contacts-list'), 'contact', {
                'name': 'Name',
                'email': 'Email address',
                'no_hp': 'Phone',
            }, {
                useAction: true,
                onEdit: function(data) {
                    editContact(data);
                },
                onDelete: function(data) {
                    askConfirmation('contact/' + data.id_contact, 'DELETE', [], 'Are you sure you want to delete this contact?');
                }
            });
        })
    </script>
    <script>
        let oldInput = @json(old());
        $(document).ready(function() {
            if (oldInput['form_name'] === "contact") {
                createContact();
            }
            if (oldInput['form_name'].includes("contact/")) {
                editContact(data);
            }
        })

        function editContact(data) {
            console.log(data);
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("contact/" + data.id_contact, [{
                icon: 'detail',
                title: 'Contact Edit'
            }], [
                `
                            
                            <div>
                                @method("PUT")
                                <input name="form_name" value='a' type="hidden">
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="name">Nama <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="name" style="" values=${data.name} class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama"  type="text" name="name"
                                            :value="old('name')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="email">Email <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="email" style="" values=${data.email} class="block mt-2 w-full h-full bg-gray-200" placeholder="Email"  type="email" name="email"
                                            :value="old('email')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="no_hp">Phone Number <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="no_hp" style="" values=${data.no_hp} class="block mt-2 w-full h-full bg-gray-200" placeholder="Phone Number" type="tel" name="no_hp"
                                            :value="old('no_hp')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                            </div>
                        `
            ], {
                1: ['name', 'email', 'no_hp']
            }, {
                lastButton: "Edit Contact",
                hideStep: true,
                'min-width': '450px',
                onCreate: function() {
                    createBounced = false;
                },
            })
        }

        function createContact() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("contact", [{
                icon: 'detail',
                title: 'Contact Creation'
            }], [
                `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="name">Nama <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="name" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Nama"  type="text" name="name"
                                            :value="old('name')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="email">Email <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="email" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Email"  type="email" name="email"
                                            :value="old('email')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <x-input-label for="no_hp">Phone Number <a class="text-red-700">*</a></x-input-label>
                                        <x-text-input id="no_hp" style="" class="block mt-2 w-full h-full bg-gray-200" placeholder="Phone Number" type="tel" name="no_hp"
                                            :value="old('no_hp')"  autofocus/>
                                    </div>
                                    <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
                            </div>
                        `
            ], {
                1: ['name', 'email', 'no_hp']
            }, {
                lastButton: "Create Contact",
                'min-width': '450px',
                onCreate: function() {
                    createBounced = false;
                },
            })
        }
    </script>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Contacts') }}
        </h2>
    </x-slot>

    <div>
        <div class="mx-auto max-w-5xl">
            <div class="flex justify-end mb-6">
                <x-primary-button onclick="createContact();">New Contact</x-primary-button>
            </div>
            <x-card.list-item id="contacts-list" />
        </div>
    </div>
</x-app-layout>
