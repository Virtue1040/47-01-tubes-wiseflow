@section('title', '- Chat')
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Chats') }}
        </h2>
    </x-slot>
    <script>
flex flex-col gap-[25px] 
        $("#contentContainer").css("overflow", 'hidden');
    </script>
    <script>
        let cardContact = [];
        let activeChannel = null;
        let activedUser = [];
        let pendingMessage = [];

        client.on("user.presence.changed", async (event) => {
            activedUser[event.user.id] = event.user.online;
            Object.keys(cardContact).forEach(key => {
                let data = cardContact[key];
                if (data.type === 'messaging') {
                    if (data.channel.state.members[event.user.id] !== undefined) {
                        if (event.user.online) {
                            data.object.find('[name="onlineIndicator"]').removeClass('hidden');
                        } else {
                            data.object.find('[name="onlineIndicator"]').addClass('hidden');
                        }
                        if (activeChannel !== null && activeChannel.id === key && activeChannel.channel
                            .type === 'messaging') {
                            $("#channelStatus").html(event.user.online ? 'Online' : '');
                        }
                    }
                }
            });
        });

        function createChannel(getOpponentName, imagePath, data) {
            let messages = data.messages
            let getLastChatTime = messages.length > 0 ?
                formatLastChatTime(messages[
                    messages.length - 1].updated_at) : '00:00'
            let getLastMessage = messages.length > 0 ? messages[
                    messages.length - 1]
                .text : 'No message'
            $("#channel-" + data.channel.id).find(
                '[name="animationPulse"]').addClass(
                'hidden');
            let getUnreadMessage = cardContact[data.channel.id]['channel'].state.read[userId]['unread_messages'];
            let hideUnread = 'hidden';
            let online = 'hidden';
            if (getUnreadMessage > 0) {
                hideUnread = '';
            }
            if (data.channel.type === 'messaging') {
                let opponent = data.members.filter(members => members.user_id !== userId)[0];
                activedUser[opponent.user.id] = opponent.user.online;
                online = activedUser[opponent.user.id] === true ? '' : 'hidden';
                $('#openProfileLink').attr('href', getHost() + `/view/profile/${opponent.user.id}/overview`)
            } else {
                $('#openProfileLink').attr('href', null)
            }
            $("#channel-" + data.channel.id).append(`
                                                    <div class="relative">
                                                        <div class="flex justify-center items-center rounded-full min-w-[40px] h-[40px] bg-white overflow-hidden">
                                                            <img onerror="let getFirst = '${getOpponentName}'; $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')" class="w-[40px] h-[40px]">
                                                            <a class="text-black"></a>
                                                        </div>
                                                        <span class="inline-flex absolute bottom-0 right-0 w-[12px] h-[12px] bg-[#1DAA61] rounded-full ${online}" name='onlineIndicator'></span>
                                                    </div>
                                                    
                                                        <div class="flex flex-col w-full max-w-[170px] 2xl:max-w-[275px] pr-[10px]">
                                                            <div class="flex justify-between w-full">
                                                                <a class="text-black dark:text-gray-300" name="username">
    ${getOpponentName}
</a>
                                                                <a class="text-sm text-black dark:text-gray-300" name="last_update">
    ${getLastChatTime}
</a>
                                                            </div>
                                                            <div class="flex justify-between">
                                                                <a class="w-full text-sm text-black text-gray-400 truncate dark:text-gray-300 dark:text-gray-400" name="message">
    ${getLastMessage}
</a>
                                                                <div class="w-[20px] h-[20px] relative ${hideUnread}" name="channel_unread">
                                                                    <span class="inline-flex absolute top-0 right-0 w-[20px] h-full bg-sky-400 rounded-full opacity-100 animate-ping hidden"></span>
                                                                        <span class="flex inline-flex absolute right-0 justify-center items-center p-2 w-[20px] h-[20px] bg-[#5E93DA] rounded-full"><a class="text-sm text-white">${getUnreadMessage}</a></span>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    
                                                `)
            $("#channel-" + data.channel.id).click(function() {
                initializeChat(data.channel.id,
                    getOpponentName, imagePath);
            })


            if (imagePath === null || imagePath === '' || imagePath === undefined) {
                $("#channel-" + data.channel.id).find('img').attr('name', getOpponentName);
                $("#channel-" + data.channel.id).find('img')
                    .trigger('error');
            } else {
                $("#channel-" + data.channel.id).find('img')
                    .attr("src", imagePath);
            }
        }

        function updateChannel() {
            $.ajax({
                url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/chat/get-channels",
                type: 'GET',
                data: {
                    id: userId
                },
                success: function(response) {
                    if (response.channels.length > 0) {
                        console.log(response);
                        response.channels.forEach(data => {
                            let channelContainer = $("#channelContainer");
                            if (data.channel.type !== 'messaging' && data.channel.type !== 'team') {
                                return;
                            }
                            if (cardContact[data.channel.id] !== undefined) {
                                return;
                            }

                            let channel = data.channels
                            let member = data.members
                            let messages = data.messages
                            let getOpponentName = data.channel.name;
                            let id_channel = data.channel.id;
                            let imagePath = null;
                            if (data.channel.type === 'team') {
                                channelContainer = $("#channelContainerGroup")
                            }
                            channelContainer.append(`
                            <div @click="selectedChannel='${data.channel.id}'" x-bind:class="selectedChannel == '${data.channel.id}' ? 'dark:!bg-[#FAFAFA] dark:!bg-opacity-10 !bg-gray-100 !bg-opacity-50' : ''" id="channel-${data.channel.id}" class="active:dark:bg-[#FAFAFA] active:dark:bg-opacity-10 active:bg-gray-100 active:bg-opacity-50 flex  items-center p-3 w-full gap-[18px] rounded-xl cursor-pointer hover:bg-gray-100 hover:bg-opacity-50 dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 relative">
                                <div class="mx-auto w-full max-w-sm rounded-md shadow" name="animationPulse">
                                <div class="flex space-x-4 h-[45px] animate-pulse">
                                    <div class="w-10 h-10 rounded-full bg-slate-700"></div>
                                    <div class="flex-1 py-1 space-y-6">
                                    <div class="h-2 rounded bg-slate-700"></div>
                                    <div class="space-y-3">
                                        <div class="grid grid-cols-3 gap-4">
                                        <div class="col-span-2 h-2 rounded bg-slate-700"></div>
                                        <div class="col-span-1 h-2 rounded bg-slate-700"></div>
                                        </div>
                                        <div class="h-2 rounded bg-slate-700"></div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                                                `)

                            cardContact[data.channel.id] = {
                                object: $("#channel-" + id_channel),
                                type: data.channel.type,
                                update: function(data) {
                                    this.object.find(
                                            'a[name="last_update"]')
                                        .html(
                                            formatLastChatTime(data
                                                .message
                                                .updated_at));
                                    this.object.find(
                                            'a[name="message"]')
                                        .html(data.message
                                            .text);
                                    let getUnreadMessage = cardContact[id_channel]['channel']
                                        .state.read[userId]['unread_messages'];

                                    if (getUnreadMessage > 0) {
                                        this.object.find(`[name='channel_unread']`).removeClass(
                                            'hidden');
                                        this.object.find(`[name='channel_unread']`).find('a')
                                            .html(getUnreadMessage);
                                    } else {
                                        this.object.find(`[name='channel_unread']`).addClass(
                                            'hidden');
                                    }
                                    channelContainer.prepend(this
                                        .object);
                                },
                                read: function() {
                                    this.object.find(`[name='channel_unread']`).addClass(
                                        'hidden');
                                }
                            };

                            async function onMessageNew() {
                                let channels = client.channel(cardContact[id_channel]['type'],
                                    id_channel);
                                let states = await channels.watch({
                                    presence: true
                                });
                                cardContact[id_channel]['channel'] = channels;
                                channels.on('message.new', async (event) => {
                                    cardContact[event.channel_id].update(event);
                                });
                                channels.on('typing.start', async (event) => {
                                    if (event.user.id === userId) {
                                        return;
                                    }
                                    cardContact[event.channel_id].object.find(
                                        'a[name="message"]').html('Typing...');
                                    cardContact[event.channel_id].object.find(
                                        'a[name="message"]').addClass(
                                        '!text-[#5E93DA]');
                                });
                                channels.on("typing.stop", (event) => {
                                    if (event.user.id === userId) {
                                        return;
                                    }
                                    cardContact[event.channel_id].object.find(
                                        'a[name="message"]').html(channels.state
                                        .messages[channels.state.messages.length - 1]
                                        .text);
                                    cardContact[event.channel_id].object.find(
                                        'a[name="message"]').removeClass(
                                        '!text-[#5E93DA]');
                                });
                                setTimeout(() => {
                                    if (data.channel.type === 'messaging') {
                                        let opponent = member.filter(
                                            members => members.user_id !== userId)[0];
                                        getOpponentName = opponent.user.name;
                                        imagePath = opponent.user.image;
                                        createChannel(getOpponentName, imagePath, data);
                                    } else if (data.channel.type === 'team') {
                                        createChannel(getOpponentName, imagePath, data);
                                    }
                                }, 1000);
                            }
                            onMessageNew();

                        });
                    }
                }
            })
        }
        updateChannel();
        setInterval(() => {
            updateChannel();
        }, 5000);

        function createChannelPrivate() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("channel", [{
                icon: 'detail',
                title: 'Channel Creation'
            }], [
                `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <input type="hidden" name="id_user">
                                        <div class="relative">
                                            <label class="text-black dark:text-gray-300" for="search_user">
    Search User <a class="text-red-700">*</a>
</label>
                                            <input value="" autocomplete="off"   class="border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md  block mt-2 w-full h-full bg-gray-200" style=";" id="search_user" placeholder="Search User by Name" type="text" name="search_user" autofocus="autofocus">
                                            <div class="overflow-x-hidden border-[1px] border-gray-200 dark:border-[#464649] w-full mt-2 rounded-xl dark:bg-[#18181B] bg-white flex p-2 flex-col gap-[15px] absolute top-100% left-0 max-h-[205px] overflow-y-auto
                                            [&::-webkit-scrollbar]:w-[2px]
                                            [&::-webkit-scrollbar-track]:rounded-full
                                            [&::-webkit-scrollbar-thumb]:rounded-full
                                            [&::-webkit-scrollbar-thumb]:bg-[#5E93DA]" name="search_user">
                                                
                                            </div>
                                        </div>
                                    </div>
                                                                </div>
                        `
            ], {
                1: ['id_user']
            }, {
                lastButton: "Start Chat",
                'min-width': '450px',
                onCreate: function(form, div) {
                    createBounced = false;
                    let input = $(form).find("input[name='search_user']");
                    input.onPause(function() {
                        let search = $(this).val();
                        $.ajax({
                            url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/user/search",
                            type: 'GET',
                            data: {
                                q: search
                            },
                            success: function(response) {
                                if (response.success) {
                                    let searchUser = $(form).find(
                                    'div[name="search_user"]');
                                    searchUser.empty();
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

                    $(form).on('submit', function(e) {
                        e.preventDefault();
                        let id_user = $(form).find('input[name="id_user"]').val();
                        console.log(id_user);
                        $.ajax({
                            url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/chat/create-channel-private",
                            type: 'POST',
                            data: {
                                id_user: id_user
                            },
                            success: function(response) {
                                if (response.success) {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'Chat Created'
                                    })
                                    div.remove();
                                    updateChannel();
                                } else {

                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        })
                    })
                },
            })
        }

        function createChannelGroup() {
            if (createBounced) {
                return;
            }
            createBounced = true;
            let returns = init_create_modal("channel", [{
                icon: 'detail',
                title: 'Channel Creation'
            }], [
                `
                            <div>
                                <input name="form_name" value='a' type="hidden">
                                <div class="mt-3 w-full h-full min-w-[0px]">
                                        <label class="text-black dark:text-gray-300" for="id_user">
    ID User <a class="text-red-700">*</a>
</label>
                                        <input value="" autocomplete="off"   class="border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md  block mt-2 w-full h-full bg-gray-200" style=";" id="id_user" placeholder="ID User" type="text" name="id_user" autofocus="autofocus">
                                    </div>
                                                                </div>
                        `
            ], {
                1: ['id_user']
            }, {
                lastButton: "Create Group",
                'min-width': '450px',
                onCreate: function(form) {
                    createBounced = false;
                    $(form).on('submit', function(e) {
                        e.preventDefault();
                        let id_user = $(form).find('input[name="id_user"]').val();
                        $.ajax({
                            url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/chat/create-channel-private",
                            type: 'POST',
                            data: {
                                id_user: id_user
                            },
                            success: function(response) {
                                if (response.success) {
                                    window.location.reload();
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr) {
                                console.log(xhr);
                            }
                        })
                    })
                },
            })
        }

        function scrollBottom() {
            $("#chatContainer").parent().animate({
                scrollTop: $("#chatContainer").height()
            }, 0);
        }

        let bounceChat = false;
        let intervalBounce = false;
        async function initializeChat(id_channel, getOpponentName, imagePath) {
            pendingMessage = [];
            if (bounceChat) {
                if (!intervalBounce) {
                    intervalBounce = setInterval(() => {
                        if (!bounceChat) {
                            clearInterval(intervalBounce)
                            intervalBounce = false;
                            initializeChat(id_channel, getOpponentName, imagePath);
                        }
                    }, 10);
                }
                return;
            }
            bounceChat = true;
            const onMessageNew = async (event) => {
                await activeChannel.channel.markRead();
                let content = `
                            <div name="opponent" class="flex gap-[10px]">
        <div class="p-3 max-w-2xl bg-white rounded-lg dark:bg-[#18181B] flex flex-col gap-[5px] min-w-24">
                <p class="text-gray-900 break-words dark:text-gray-100 mr-[+50px]" name="message">${event.message.text}</p>
        <div class="flex items-end justify-end w-full mb-[-7px] ">
            <p class="text-xs text-gray-300">${formatLastChatTime(event.message.updated_at)}</p>
        </div>
    </div>
</div>                `
                if (event.user.id === userId) {
                    let pendObject = pendingMessage[0].object;
                    pendingMessage.pop();
                    if (channel.type === 'messaging') {
                        pendObject.find('[name="signal"]').removeClass('hidden');
                        pendObject.attr('id', event.id);
                    }
                } else {
                    if (event.channel_type === 'team') {
                        content = `
                                        <div name="opponent" class="flex gap-[10px]">
            <div class="flex justify-center items-center rounded-full flex-shrink-0 flex-grow-0 w-[35px] h-[35px] bg-white overflow-hidden">
            <img id="username_image"
                onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                alt="Profile Image" src="${event.message.user.image}" class="" name="${event.message.user.name}">
            <a class="text-black"></a>
        </div>
        <div class="p-3 max-w-2xl bg-white rounded-lg dark:bg-[#18181B] flex flex-col gap-[5px] min-w-24">
                    <div>
                <p class="text-xs text-gray-300">${event.message.user.name}</p>
            </div>
                <p class="text-gray-900 break-words dark:text-gray-100 mr-[+50px]" name="message">${event.message.text}</p>
        <div class="flex items-end justify-end w-full mb-[-7px] ">
            <p class="text-xs text-gray-300">${formatLastChatTime(event.message.updated_at)}</p>
        </div>
    </div>
</div>                                    `
                        chatContainer.append(content);
                    } else {
                        chatContainer.append(content);
                    }
                }
                scrollBottom();
            }
            const onMessageRead = async (event) => {
                if (event.user.id === userId) {
                    return;
                }

                setTimeout(function() {
                    $("#chatContainer").find('div[name="local"]').each(function() {
                        $(this).find('[name="signal"]').addClass('!fill-white');
                    });
                }, 1000)
            }

            if (activeChannel !== undefined && activeChannel !== null) {
                activeChannel.channel.off('message.new', activeChannel.event);
                activeChannel.channel.off('message.read', activeChannel.eventRead);
            }

            const channel = client.channel(cardContact[id_channel]['type'], id_channel);
            const state = await channel.watch({
                presence: true
            });

            await channel.markRead();
            cardContact[id_channel].read();
            refreshUnread();

            activeChannel = {
                id: id_channel,
                state: state,
                channel: channel,
            }

            let chatContainer = $("#chatContainer")
            chatContainer.empty();

            function createText(event) {
                let content = `
                            <div name="opponent" class="flex gap-[10px]">
        <div class="p-3 max-w-2xl bg-white rounded-lg dark:bg-[#18181B] flex flex-col gap-[5px] min-w-24">
                <p class="text-gray-900 break-words dark:text-gray-100 mr-[+50px]" name="message">${event.text}</p>
        <div class="flex items-end justify-end w-full mb-[-7px] ">
            <p class="text-xs text-gray-300">${formatLastChatTime(event.updated_at)}</p>
        </div>
    </div>
</div>                `
                if (event.user.id === userId) {
                    content = $(`
                            <div id="${event.id}" name="local" class="flex justify-end">
    <div class="p-3 max-w-2xl text-white bg-blue-500 rounded-lg dark:bg-[#5E93DA] flex flex-col">
        <p class="mr-[50px] w-full break-words">${event.text}</p>
        <div class="flex justify-end w-full mb-[-7px] gap-[5px] items-end">
            <p class="text-xs text-gray-300">${formatLastChatTime(event.updated_at)}</p>
            <div name="signal" class="hidden fill-black">
                <svg class="" height="20"  width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-160v-240h120v240H200Zm240 0v-440h120v440H440Z"/></svg>            </div>
        </div>
    </div>
</div>                    `)

                    if (channel.type === 'messaging') {
                        content.find('[name="signal"]').removeClass('hidden');
                        Object.keys(channel.state.members).forEach(key => {
                            if (key === userId) {
                                return true;
                            }
                            const member = channel.state.members[key];
                            const messageTimestamp = new Date(event.created_at);
                            const userLastRead = new Date(channel.state.read[member.user.id].last_read);
                            if (messageTimestamp <= userLastRead) {
                                content.find('[name="signal"]').addClass("!fill-white")
                            } else {
                                content.find('[name="signal"]').removeClass('!fill-white');
                            }
                        });

                    }
                    chatContainer.append(content);
                } else {
                    if (channel.type === 'team') {
                        content = `
                                        <div name="opponent" class="flex gap-[10px]">
            <div class="flex justify-center items-center rounded-full flex-shrink-0 flex-grow-0 w-[35px] h-[35px] bg-white overflow-hidden">
            <img id="username_image"
                onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                alt="Profile Image" src="${event.user.image}" class="" name="${event.user.name}">
            <a class="text-black"></a>
        </div>
        <div class="p-3 max-w-2xl bg-white rounded-lg dark:bg-[#18181B] flex flex-col gap-[5px] min-w-24">
                    <div>
                <p class="text-xs text-gray-300">${event.user.name}</p>
            </div>
                <p class="text-gray-900 break-words dark:text-gray-100 mr-[+50px]" name="message">${event.text}</p>
        <div class="flex items-end justify-end w-full mb-[-7px] ">
            <p class="text-xs text-gray-300">${formatLastChatTime(event.updated_at)}</p>
        </div>
    </div>
</div>                                    `
                        chatContainer.append(content);
                    } else {
                        chatContainer.append(content);
                    }
                }
            }

            activeChannel.channel.state.messages.forEach(event => {
                createText(event)
            });
            activeChannel.event = onMessageNew;
            activeChannel.eventRead = onMessageRead;
            activeChannel.channel.on('message.new', activeChannel.event);
            activeChannel.channel.on('message.read', activeChannel.eventRead);
            let profileChannel = $("#profileChannel");
            profileChannel.attr('type', activeChannel.channel.type);

            $("#channelName").html(getOpponentName)
            $("#username_chat").html(getOpponentName)
            $("#username_image").attr('name', getOpponentName)
            $("#username_profile").attr('name', getOpponentName)
            if (imagePath === null || imagePath === '' || imagePath === undefined) {
                $("#username_image").trigger('error')
                $("#username_profile").trigger('error');
            } else {
                $("#username_image").attr('src', imagePath)
                $("#username_image").css('display', 'block')
                $("#username_profile").css('display', 'block')
                $("#username_image").parent().find('a').html('');
                $("#username_profile").parent().find('a').html('');
                $("#username_profile").attr('src', imagePath)
            }
            $("#extended_info").empty();
            if (activeChannel.channel.type === 'team') {
                $("#chat_type").html('Group')
                // $("#deleteChat").addClass('hidden');
                $("#channelStatus").html('')
                $("#leaveChannel").removeClass('hidden');
                $("#extended_info").append(`
                    <div class="flex gap-[15px] items-center w-auto">
                                        <hr class="dark:border-[#464649] border-gray-200 w-full">
                                        <a class="text-black dark:text-gray-300 text-nowrap">
    Group Members
</a>
                                        <hr class="dark:border-[#464649] border-gray-200 w-full">
                                    </div>
                `)
                Object.keys(activeChannel.channel.state.members).forEach(key => {
                    let getMember = activeChannel.channel.state.members[key];
                    let profile = $(`
                        <div class="h-[50px] mt-[2px] px-2 flex items-center gap-[10px]">
                            <div
                                class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden">
                                <img
                                    onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                                    alt="Profile Image" class="" name="${getMember.user.name}" src="${getMember.user.image}">
                                <a class="text-black"></a>
                            </div>
                            <div class="flex flex-col truncate">
                                            <div class="flex gap-[5px] items-center">
                                                <a class="text-sm text-black dark:text-gray-300">
    ${getMember.user.name}
</a>
                                            </div>
                                            <a class="text-black dark:text-gray-300 text-xs !text-gray-500 w-full" id="chat_type">
    ${toUpperCase(getMember.role)}
</a>
                                        </div>
                        </div>
                    `);
                    $("#extended_info").append(profile)
                });
                profileChannel.attr('userId', null);
            } else {
                $("#chat_type").html('Private')
                $("#leaveChannel").addClass('hidden');

                Object.keys(activeChannel.channel.state.members).forEach(key => {
                    if (key === userId) {
                        return true;
                    }
                    let getMember = activeChannel.channel.state.members[key];
                    profileChannel.attr('userId', getMember.user.id);
                    $("#channelStatus").html(activedUser[getMember.user.id] === true ? 'Online' : '');
                });

                // $("#deleteChat").removeClass('hidden');
            }

            $("#overview").removeClass('hidden');
            scrollBottom();
            bounceChat = false;
        }

        $(document).ready(function() {
            async function sendMessage() {
                if (activeChannel === null) {
                    return;
                }
                const messageInput = $("#chatBox")
                const text = messageInput.val();
                if (text) {
                    let content = $(`
                            <div id="" name="local" class="flex justify-end">
    <div class="p-3 max-w-2xl text-white bg-blue-500 rounded-lg dark:bg-[#5E93DA] flex flex-col">
        <p class="mr-[50px] w-full break-words">${text}</p>
        <div class="flex justify-end w-full mb-[-7px] gap-[5px] items-end">
            <p class="text-xs text-gray-300">${formatLastChatTime(new Date())}</p>
            <div name="signal" class="hidden fill-black">
                <svg class="" height="20"  width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-160v-240h120v240H200Zm240 0v-440h120v440H440Z"/></svg>            </div>
        </div>
    </div>
</div>                    `)
                    pendingMessage.push({
                        object: content
                    });

                    chatContainer.append(content[0]);
                    scrollBottom();
                    $.ajax({
                        url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/chat/send-message",
                        type: 'POST',
                        data: {
                            channel_type: activeChannel.channel.type,
                            id_channel: activeChannel.id,
                            message: text
                        },
                        success: function(response) {
                            if (response.success) {

                            }
                        },
                        error: function(xhr) {
                            console.log(xhr);
                        }
                    })
                    messageInput.val('');
                }
            }

            async function onChatChange() {
                if (activeChannel !== null) {
                    if (!isTyping) {
                        clearTimeout(isTyping);
                        isTyping = setTimeout(async () => {
                            await activeChannel.channel.stopTyping();
                            isTyping = false;
                        }, 2000);
                    }

                    await activeChannel.channel.keystroke();
                }
            }

            $("#chatSubmit").click(function() {
                sendMessage();
            });
            $("#chatBox").onEnter(function() {
                sendMessage();
            });
            let isTyping = false;
            $("#chatBox").on('input', function() {
                onChatChange();
            });

        })

        async function clearChannel(id_channel) {
            let chatContainer = $("#chatContainer")
            chatContainer.empty();
            await channel.removeMembers([userId]);
        }

        async function outChannel(id_channel) {
            if (cardContact[id_channel]['type'] === 'team') {
                return;
            }
            let chatContainer = $("#chatContainer")
            chatContainer.empty();
            $("#overview").addClass('hidden');
            activeChannel.channel.off('message.new');
            await activeChannel.channel.hide(null, true);
            activeChannel = null;
            cardContact[id_channel].object.remove();
            cardContact[id_channel] = undefined;
        }

        function formatLastChatTime(updatedAt) {
            const now = new Date();
            const lastChatTime = new Date(updatedAt);

            const isToday =
                lastChatTime.toDateString() === now.toDateString();
            const isYesterday =
                new Date(now.setDate(now.getDate() - 1)).toDateString() === lastChatTime.toDateString();

            if (isToday) {
                return lastChatTime.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } else if (isYesterday) {
                return "Yesterday";
            } else {
                return lastChatTime.toLocaleDateString();
            }
        }

        function resetChannel() {
            $.ajax({
                url: "https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/api/chat/reset-channel",
                type: 'POST',
                success: function(response) {
                    console.log(response);
                    if (response.success) {
                        Toast.fire({
                            icon: 'success',
                            title: 'All Channel Reset'
                        })
                        Object.keys(cardContact).forEach(key => {
                            if (cardContact[key] !== undefined) {
                                cardContact[key].object.remove();
                                cardContact[key] = undefined;
                            }
                        });
                        cardContact = [];
                        updateChannel();
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            })
        }

        let activeChat = undefined;
    </script>
    <div x-data="{ openSideContact: true }" class="flex w-full">
        <div x-data="{ openedMenu: 'Chat' }" x-show="openSideContact"
            x-transition:enter="transition-transform ease-out duration-300" x-transition:enter-start="translate-x-[-100%]"
            x-transition:enter-end="translate-x-0" x-transition:leave="transition-transform ease-in duration-200"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-[-100%]"
            class="flex float-left flex-col gap-2 h-full" style="">
            <div
                class=" h-full w-[300px] 2xl:w-[400px] dark:bg-[#18181B]  bg-[#f0f0f3] border-r-[1px] shadow-[rgba(0,0,15,0.1)_0px_0px_5px_0px] dark:border-[#272729] border-gray-200 rounded-l-xl pt-[30px] px-[0px] flex flex-col">
                <h3
                    class=" px-[30px] flex justify-between items-center text-lg font-semibold text-gray-800  dark:text-gray-200">
                    <a class="text-black dark:text-gray-300" x-text="openedMenu">Chat</a>
                    <div class="flex gap-[10px]">
                        <button
                            class="disabled:bg-gray-300 disabled:text-gray-500 disabled:dark:bg-gray-800 disabled:cursor-not-allowed inline-flex items-center px-4 py-2 border-[1px] border-gray-200 bg-[#5E93DA] dark:bg-[#5E93DA] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-[#315079] focus:bg-gray-700 dark:focus:bg-[#5E93DA] active:bg-gray-900 dark:active:bg-[#5E93DA] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 !rounded-full !p-[8px] !py-[5px]"
                            onclick="createChannelPrivate();">
                            <div class="flex relative justify-center items-center w-full h-full">
                                <a class="text-sm">+ Chat</a>
                            </div>
                        </button>
                        <button
                            class="disabled:bg-gray-300 disabled:text-gray-500 disabled:dark:bg-gray-800 disabled:cursor-not-allowed inline-flex items-center px-4 py-2 border-[1px] border-gray-200 bg-[#5E93DA] dark:bg-[#5E93DA] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-[#315079] focus:bg-gray-700 dark:focus:bg-[#5E93DA] active:bg-gray-900 dark:active:bg-[#5E93DA] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 !rounded-full !bg-red-500 hover:!bg-red-600 !p-[8px] !py-[5px] !bg-opacity-90">
                            <div class="flex relative justify-center items-center w-full h-full">
                                <a class="text-sm" onclick="resetChannel();">Reset</a>
                            </div>
                        </button>

                    </div>
                </h3>
                <div class="flex flex-col h-full">
                    <div class="flex overflow-hidden mt-3 px-[15px] gap-[5px] flex-shrink-0">
                        <button @click="openedMenu = 'Chat'"
                            x-bind:class="openedMenu === 'Chat' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                                'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                            class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none "><a
                                class="text-black dark:text-gray-300">
                                Private
                            </a>
                        </button>
                        <button @click="openedMenu = 'Group'"
                            x-bind:class="openedMenu === 'Group' ? 'dark:bg-[#27272a] bg-white dark:bg-opacity-30' :
                                'hover:dark:bg-[#27272a] hover:dark:bg-opacity-10 hover:bg-white hover:bg-opacity-30'"
                            class="w-full border-b-0 border-gray-200 p-[5px] rounded-xl rounded-b-none  "><a
                                class="text-black dark:text-gray-300">
                                Group
                            </a>
                        </button>
                    </div>
                    <div x-data="{ selectedChannel: '' }"
                        class="flex flex-col h-full rounded-t-xl rounded-bl-xl dark:bg-[#27272a] bg-white dark:bg-opacity-30">
                        <div x-show="openedMenu === 'Chat'"
                            class="h-full p-[25px] flex flex-col gap-[10px] flex-grow-0 flex-1 pb-[95px]">
                            <div class="flex gap-[10px] ">
                                <div
                                    class="w-full flex relative border-gray-200 dark:border-[#464649] border-[1px] h-[36px] bg-[#FAFAFA] dark:bg-white dark:bg-opacity-10 dark:text-gray-300 rounded-lg">
                                    <div
                                        class="flex justify-center items-center absolute top-1/2 -translate-y-1/2 left-[10px]">
                                        <svg width="20" height="20" class="fill-black dark:fill-white"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="#e8eaed">
                                            <path
                                                d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input autocomplete="off" type="text" placeholder="Search"
                                        class="bg-transparent pl-[35px] w-full focus:outline-[#5E93DA] focus:outline focus:outline-2 rounded-lg">
                                </div>




                            </div>
                            <div class="flex flex-col gap-[10px] overflow-y-auto h-fit flex-1 flex-grow py-[10px] [&amp;::-webkit-scrollbar]:w-[2px]
                            [&amp;::-webkit-scrollbar-track]:rounded-full
                            [&amp;::-webkit-scrollbar-thumb]:rounded-full
                            [&amp;::-webkit-scrollbar-thumb]:bg-[#5E93DA] pr-1"
                                id="channelContainer">
                            </div>
                        </div>
                        <div x-show="openedMenu === 'Group'"
                            class="h-full p-[25px] flex flex-col gap-[10px] flex-grow-0 flex-1 pb-[95px]"
                            style="display: none;">
                            <div class="flex gap-[10px] ">
                                <div
                                    class="w-full flex relative border-gray-200 dark:border-[#464649] border-[1px] h-[36px] bg-[#FAFAFA] dark:bg-white dark:bg-opacity-10 dark:text-gray-300 rounded-lg">
                                    <div
                                        class="flex justify-center items-center absolute top-1/2 -translate-y-1/2 left-[10px]">
                                        <svg width="20" height="20" class="fill-black dark:fill-white"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"
                                            fill="#e8eaed">
                                            <path
                                                d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input autocomplete="off" type="text" placeholder="Search"
                                        class="bg-transparent pl-[35px] w-full focus:outline-[#5E93DA] focus:outline focus:outline-2 rounded-lg">
                                </div>




                            </div>
                            <div class="flex flex-col gap-[10px] overflow-y-auto h-fit flex-1 flex-grow py-[10px] 
                            [&amp;::-webkit-scrollbar]:w-[2px]
                                [&amp;::-webkit-scrollbar-track]:rounded-full
                                [&amp;::-webkit-scrollbar-thumb]:rounded-full
                                [&amp;::-webkit-scrollbar-thumb]:bg-[#5E93DA] pr-1"
                                id="channelContainerGroup">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex hidden relative flex-col w-full h-full" id="overview">
            <div
                class="flex items-center justify-between p-2 px-[35px] bg-[#f0f0f3] rounded-tr-xl border-b-[1px] dark:border-[#272729] border-gray-200 dark:bg-[#18181B]">
                <div class="flex items-center gap-[15px] cursor-pointer">
                    <div class="hidden items-center -me-2 ml-[-15px] md:flex">
                        <button @click="openSideContact = ! openSideContact"
                            class="inline-flex justify-center items-center p-2 text-gray-400 rounded-md transition duration-150 ease-in-out dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400"
                            id="sideBarHumberger">
                            <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': openSideContact, 'inline-flex': !openSideContact }"
                                    class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                                <path :class="{ 'hidden': !openSideContact, 'inline-flex': openSideContact }"
                                    class="inline-flex" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <a class="p-1 rounded-xl  dark:hover:bg-[#FAFAFA] dark:hover:bg-opacity-10 hover:bg-gray-100"
                        id="openProfileLink"
                        href="https://8000-idx-tubes-semester-3-1728983615977.cluster-e3wv6awer5h7kvayyfoein2u4a.cloudworkstations.dev/view/profile/4/overview">
                        <div class="flex gap-[15px] items-center">
                            <div id="profileChannel"
                                class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden"
                                type="messaging" userid="4">
                                <img class="" id="username_image"
                                    onerror="let getFirst = $(this).attr('name'); $(this).parent().find('p').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                                    alt="Profile Image" name="Rafi Hidayat"
                                    src="https://lh3.googleusercontent.com/a/ACg8ocIQCtG3ch_RzIDd1_vy6LdLNrt8_7TNtjtOBKqMvUIzNFhDm9g=s96-c"
                                    style="display: block;">
                                <p class="text-black"></p>
                            </div>
                            <div class="flex flex-col gap-[1px]">
                                <span class="font-semibold text-gray-900 dark:text-gray-200" id="channelName">Rafi
                                    Hidayat</span>
                                <span class="text-[12px] text-[#1DAA61] font-semibold " id="channelStatus"></span>
                            </div>
                        </div>
                    </a>
                </div>
                <div>
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false"
                        @close.stop="open = false">
                        <div @click="open = ! open">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 rounded-md border border-transparent dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                <div class="flex items-center gap-[10px]">
                                    <svg class="fill-black dark:fill-white" height="30" width="30"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                        <path
                                            d="M240-400q-33 0-56.5-23.5T160-480q0-33 23.5-56.5T240-560q33 0 56.5 23.5T320-480q0 33-23.5 56.5T240-400Zm240 0q-33 0-56.5-23.5T400-480q0-33 23.5-56.5T480-560q33 0 56.5 23.5T560-480q0 33-23.5 56.5T480-400Zm240 0q-33 0-56.5-23.5T640-480q0-33 23.5-56.5T720-560q33 0 56.5 23.5T800-480q0 33-23.5 56.5T720-400Z">
                                        </path>
                                    </svg>
                                </div>
                            </button>
                        </div>

                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute z-50 mt-2 min-w-[250px] w-auto shadow-lg ltr:origin-top-right rtl:origin-top-left end-0"
                            style="display: none;" @click="open = false">
                            <div
                                class="rounded-2xl ring-1 ring-black ring-opacity-5 bg-white dark:bg-[#18181B] p-1 border-gray-200 dark:border-[#464649] border-[1px]">
                                <div class="flex flex-col px-1 pb-[5px]">
                                    <div class="h-[50px] mt-[2px] flex items-center px-3 gap-[10px] py-[5px]">
                                        <div
                                            class="flex justify-center items-center rounded-full w-[35px] h-[35px] bg-white overflow-hidden">
                                            <img id="username_profile"
                                                onerror="let getFirst = $(this).attr('name'); $(this).parent().find('a').text(getFirst.charAt(0)); $(this).css('display', 'none')"
                                                alt="Profile Image" class="" name="Rafi Hidayat"
                                                src="https://lh3.googleusercontent.com/a/ACg8ocIQCtG3ch_RzIDd1_vy6LdLNrt8_7TNtjtOBKqMvUIzNFhDm9g=s96-c"
                                                style="display: block;">
                                            <a class="text-black"></a>
                                        </div>
                                        <div class="flex flex-col truncate">
                                            <div class="flex gap-[5px] items-center">
                                                <a class="text-sm text-black dark:text-gray-300"
                                                    id="username_chat">Rafi Hidayat</a>
                                            </div>
                                            <a class="text-black dark:text-gray-300 text-xs !text-gray-500 w-full"
                                                id="chat_type">Private</a>
                                        </div>
                                    </div>
                                    <div id="extended_info" class="flex flex-col px-1"></div>
                                    <hr class="dark:border-[#464649] border-gray-200 mt-2">
                                    <!-- Authentication -->
                                    <a class="rounded-md block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#242427] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out mt-2 flex gap-[5px] cursor-pointer hidden"
                                        id="leaveChannel" onclick="clearChannel(activeChannel.id)"><svg
                                            class="fill-black dark:fill-white" height="20" width="20"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                            <path
                                                d="m376-400 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56ZM80-80v-720q0-33 23.5-56.5T160-880h640q33 0 56.5 23.5T880-800v480q0 33-23.5 56.5T800-240H240L80-80Zm126-240h594v-480H160v525l46-45Zm-46 0v-480 480Z">
                                            </path>
                                        </svg> Leave Group</a>
                                    <a class="rounded-md block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-[#242427] focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out mt-2 flex gap-[5px] cursor-pointer"
                                        id="clearChat" onclick="outChannel(activeChannel.id)"><svg
                                            class="fill-black dark:fill-white" height="20" width="20"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                            <path
                                                d="m376-300 104-104 104 104 56-56-104-104 104-104-56-56-104 104-104-104-56 56 104 104-104 104 56 56Zm-96 180q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520Zm-400 0v520-520Z">
                                            </path>
                                        </svg> Delete Chat</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Messages -->
            <div
                class="overflow-y-auto flex-grow h-full px-[85px] py-[45px] bg-[url('/public/img/chat-bg.png')]  dark:bg-black dark:bg-opacity-90 dark:bg-blend-multiply
                                [&amp;::-webkit-scrollbar]:w-2
                                [&amp;::-webkit-scrollbar-track]:rounded-full
                                [&amp;::-webkit-scrollbar-thumb]:rounded-full
                                [&amp;::-webkit-scrollbar-thumb]:bg-[#5E93DA]">
                <div class="flex flex-col space-y-4" id="chatContainer">

                </div>
            </div>

            <!-- Input Message (Fixed at Bottom) -->
            <div
                class="p-4 bg-white rounded-br-xl border-t border-b-[1px] dark:border-[#272729] border-gray-200 dark:bg-[#18181B] w-full flex">
                <input value="" autocomplete="off"
                    class="border-[1px] border-gray-200 dark:border-[#464649] bg-[#FAFAFA] p-2 dark:bg-white dark:bg-opacity-10 dark:text-gray-300  rounded-md  flex-grow px-4 py-2 mr-4 w-full rounded-lg border focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-white"
                    type="text" placeholder="Type a message..." id="chatBox" maxlength="255">
                <button
                    class="disabled:bg-gray-300 disabled:text-gray-500 disabled:dark:bg-gray-800 disabled:cursor-not-allowed inline-flex items-center px-4 py-2 border-[1px] border-gray-200 bg-[#5E93DA] dark:bg-[#5E93DA] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-[#315079] focus:bg-gray-700 dark:focus:bg-[#5E93DA] active:bg-gray-900 dark:active:bg-[#5E93DA] focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 !relative !px-4 !py-3 font-semibold text-white rounded-lg focus:outline-none"
                    id="chatSubmit">
                    Send
                </button>
            </div>
        </div>
        <!-- Chat Container -->
        <div class="flex">





        </div>
    </div>
    </div>
</x-app-layout>
