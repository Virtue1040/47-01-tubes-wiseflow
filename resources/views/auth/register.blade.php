<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet">
    <!-- Jquery -->
    <x-default-global-js></x-default-global-js>
    <!-- Scripts -->
    @vite(['resources/css/app.css'])
    <script>
        let stage = 0;

        function prev() {
            let currentFrame = $("#nameSignUp");
            let nexts = $("#restSignUp");
            if (stage === 0) {
                return;
            }
            stage -= 1;
            $("#signup_desc").html("What Should We Call You?");
            $("[type='submit']").html('CONTINUE');
            currentFrame.animate({
                left: "110%"
            })
            nexts.toggleClass("hidden");
            nexts.animate({
                left: "110%"
            })
        }

        function next() {
            let currentFrame = $("#nameSignUp");
            let nexts = $("#restSignUp");
            if (stage === 1) {
                return;
            }
            if ($("[name='first_name']").val().length <= 0 || $("[name='last_name']").val().length <= 0) {
                return;
            }
            stage += 1;
            currentFrame.animate({
                left: "-110%"
            }, function() {
                // $("button[type='submit']").html('SIGN UP');
                $("#signup_desc").html("Fill your own credentials to continue.")
                nexts.toggleClass("hidden");
            })
            setTimeout(function() {
                nexts.animate({
                    left: "-100%"
                })
            }, 500);
        }

        function openRole() {
            stage += 1;
            let container = $("#loginContainer");
            let imgContainer = $("#imageContainer");
            $("#slideDefault").animate({
                opacity: '0'
            }, function() {
                container.css({
                    width: '100%'
                })
                imgContainer.css({
                    width: '0%'
                }, function() {

                })
                $("#slideRole").css({
                    display: 'flex'
                })
                $("#slideRole").animate({
                    opacity: '1'
                })
                $("#slideDefault").css({
                    display: 'none'
                })
                imgContainer.css({
                    display: 'none'
                })
                $("#signup_caption").html("Choose your Role!")
                $("#signup_desc").html("Please Select Your Role Between Property's Owner And Residence")
                $("[type='submit']").html('SIGN UP');

                // $("#slideDefault").animate({
                //     height: '0px'
                // }, function() {
                //     $("#slideDefault").css({
                //         display: 'none'
                //     })
                //     setTimeout(function() {
                //         container.css({
                //             width: '100%'
                //         })
                //         imgContainer.animate({
                //             width: '0%'
                //         }, function() {

                //             imgContainer.css("display", "none");
                //         })
                //     }, 1);
                // })
            })


            event.preventDefault();
        }

        function closeRole() {
            stage -= 1;

            event.preventDefault();
        }
        $(document).ready(function() {
            if ($("[name='first_name']").val().length <= 0 || $("[name='last_name']").val().length <= 0) {
                return;
            }
            next();
        });

        function control() {
            let valid = true;
            console.log($("#forms").serializeArray())
           
            $.each($("#forms").serializeArray(), function(i, v) {
                if (v.value.length <= 0) {
                    if (v.name === "first_name" || v.name === "last_name") {
                        prev();
                    } else {
                        next();
                    }
                    console.log(v.name)
                    event.preventDefault();
                    valid = false;
                }
            });
            if (valid === false) {
                return false;
            }
            if (stage === 2) {
                return true;
            }
            openRole();

        }
    </script>
</head>

<body class="bg-[#ececec] dark:bg-gray-900">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <div class="flex flex-col justify-center items-center w-screen h-screen">
        <div
            class=" flex flex-row w-full md:w-[800px] md:h-auto h-full  min-h-[600px] py-[10px] px-[10px] bg-white dark:bg-gray-800 bg-opacity-[.30] rounded-2xl shadow-2xl">
            <div class="w-[100%] hidden md:flex flex-col justify-center items-center bg-[#5E93DA] relative p-[10px] rounded-2xl"
                id="imageContainer"> {{-- bg-[url('/resources/image/cover.jpg')]  --}}
                <x-svg.rumah></x-svg.rumah>
                <x-icon.wiseflow-text class=""></x-icon.wiseflow-text>
            </div>
            <div class="flex w-full md:w-[85%] justify-center h-[100%] backdrop-blur-sm bg-opacity-2 rounded-2xl"
                id="loginContainer">
                <form id="forms" class="flex flex-col justify-center items-center w-[80%] pt-[50px] pb-[35px]"
                    autocomplete="off" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- First Name -->
                    <x-input-label class="text-3xl font-bold" id="signup_caption">Hello!</x-input-label>
                    <x-a-label class="text-center text-md" id="signup_desc">What Should We Call You?</x-a-label><br>
                    <div class="overflow-hidden w-full px-[5px]">
                        <div class="hidden relative w-auto py-[50px] opacity-0" id="slideRole">
                            <br>
                            <div class="flex gap-[35px] justify-center w-full ">
                                <x-card.choose-item class="w-[170px] h-[170px]" id="owner" name="role"
                                    value="1" :checked=true>
                                    <x-icon.owner p="65" l="65"></x-icon.owner>
                                    <x-a-label for="owner" class="text-lg font-bold">Owner</x-a-label>
                                </x-card.choose-item>
                                <x-card.choose-item class="w-[170px] h-[170px]" id="residents" name="role"
                                    value="2" :checked=false>
                                    <x-icon.residents p="65" l="65"></x-icon.residents>
                                    <x-a-label for="residents" class="text-lg font-bold">Residents</x-a-label>
                                </x-card.choose-item>
                            </div>
                            <br>
                        </div>
                        <div class="flex relative w-auto pb-[5px]" id="slideDefault">
                            <div class="relative gap-3 min-w-full" id="nameSignUp">
                                <div class="mt-3 w-full min-w-[0px] flex max-h-[47px]">
                                    <x-text-input id="first_name" style=""
                                        class="block mt-1 w-full h-full bg-gray-200" placeholder="First Name"
                                        type="text" name="first_name" :value="old('first_name')" autofocus />
                                </div>
                                <x-input-error :messages="$errors->get('first_name')" class="mt-1" />

                                <!-- Last Name -->
                                <div class="mt-3 w-full flex max-h-[47px]">
                                    <x-text-input id="last_name" style=""
                                        class="block mt-1 w-full h-full bg-gray-200" placeholder="Last Name"
                                        type="text" name="last_name" :value="old('last_name')" autofocus />
                                </div>
                                <x-input-error :messages="$errors->get('last_name')" class="mt-1" />

                            </div>
                            <div class="flex hidden relative flex-col min-w-full pb-[5px]" id="restSignUp">
                                <!-- Username -->
                                <div class="mt-3 w-full flex flex-col max-h-[47px]">
                                    <x-text-input id="username" style=""
                                        class="block mt-1 w-full h-full bg-gray-200" placeholder="Username"
                                        type="text" name="username" :value="old('username')" autofocus />

                                </div>
                                <x-input-error :messages="$errors->get('username')" class="mt-1" />
                                <!-- Email -->
                                <div class="mt-3 flex flex-col  w-full  max-h-[47px]">
                                    <x-text-input id="email" style=""
                                        class="block mt-1 w-full h-full bg-gray-200" placeholder="Email Address"
                                        type="email" name="email" :value="old('email')" autofocus />

                                </div>
                                <x-input-error :messages="$errors->get('email')" class="mt-1" />
                                <!-- No Telp -->
                                {{-- <div class="mt-3 flex flex-col  w-full  max-h-[47px]">
                                    <x-text-input id="ematelpil" style="" class="block mt-1 w-full h-full bg-gray-200" placeholder="No Telephone"   type="tel" name="telp"
                                        :value="old('telp')"  autofocus/>
                                    
                                </div>
                                <x-input-error :messages="$errors->get('telp')" class="mt-2" /> --}}
                                <!-- Password -->
                                <div class="mt-3 flex flex-col  w-full  max-h-[47px]">
                                    <!--x-input-label for="password" :value="__('Password')" /-->

                                    <x-text-input id="password" class="block mt-1 w-full h-full bg-gray-200"
                                        placeholder="Password" type="password" name="password" />

                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                <!-- Password Confirmation -->
                                <div class="mt-3 flex flex-col  w-full  max-h-[47px]">
                                    <x-text-input id="password-confirmation"
                                        class="block mt-1 w-full h-full bg-gray-200" placeholder="Confirm Password"
                                        type="password" name="password_confirmation" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-1" />
                                <br>
                                <x-input-label class="mt-2 text-xl font-bold text-center">What are you?</x-input-label>
                                <div
                                    class="mt-2 flex flex-row justify-center gap-[25px] w-full max-w-[350px] min-h-[35px]">

                                    <div class="flex flex-row items-center gap-[10px]">
                                        <input class="block mt-1 w-auto min-h-[35px] bg-gray-200" id="gender_male"
                                            value="male" type="radio" name="gender" checked />
                                        <x-input-label for="gender_male" class="text-xl"> Male </x-input-label>
                                    </div>
                                    <div class="flex flex-row items-center gap-[10px]"">
                                        <input class="block mt-1 w-auto min-h-[35px] bg-gray-200" id="gender_women"
                                            value="woman" type="radio" name="gender" />
                                        <x-input-label for="gender_women" class="text-xl"> Woman </x-input-label>
                                    </div>

                                </div>
                                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                            </div>

                        </div>
                    </div>

                    <!-- Remember Me -->
                    <!--div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-indigo-600 rounded border-gray-300 shadow-sm dark:bg-gray-900 dark:border-gray-700 focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                name="remember">
                            <span class="text-sm text-gray-600 ms-2 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div-->

                    <div class="flex w-full justify-end items-center mt-6  min-h-[45px]">
                        @if (Route::has('password.request'))
                            <!--a class="text-sm text-gray-600 underline rounded-md dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a-->
                        @endif

                        <x-primary-button onclick="control();" type="submit"
                            class=" w-full min-h-[40px] flex items-center justify-center">
                            {{ __('Continue') }}
                        </x-primary-button>
                    </div>
                    <br>
                    <x-input-label>Have an account? <x-a-label href="{{ route('login') }}" class="font-bold">Sign
                            In</x-a-label></x-input-label>
                </form>
            </div>
        </div>

    </div>
</body>

</html>
