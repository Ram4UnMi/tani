<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div id="myDIV">
            <div class = "w-[100vw] h-[100vh] px-3 sm:px-5 flex items-center justify-center absolute">
                <div
                    class = "w-full sm:w-1/2 lg:2/3 px-6 bg-gray-500 bg-opacity-20 bg-clip-padding backdrop-filter backdrop-blur-sm text-white z-50 py-4  rounded-lg">
                    <div class = "w-full flex justify-center text-[#00FF00] text-xl mb:2 md:mb-5">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </div>
                    {{-- name --}}
                    <div class="mb-6">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    {{-- email --}}
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    {{-- password --}}
                    <div class="mb-6">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    <!-- Role Selection -->
                    <div class="mb-6">
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-xs rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5 md:p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="user" selected>{{ __('User') }}</option>
                            <option value="owner">{{ __('Owner') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    {{-- button register --}}
                    <x-primary-button>
                        {{ __('Register') }}
                    </x-primary-button>
                    <div class = "flex justify-center text-[#96c496] text-sm md:text-md mt-4">
                        Already have an account?&nbsp;
                        <a class="underline text-sm text-[#96c496] hover:text-[#00FF00] rounded-md focus:outline-none"
                            href="{{ route('login') }}">
                            {{ __('Log in here!') }}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <script>
        const para = document.createElement("div");
        para.className = 'flex flex-wrap gap-0.5 h-screen items-center justify-center  relative';
        let el =
            '<div class = "  transition-colors duration-[1.5s] hover:duration-[0s] border-[#00FF00] h-[calc(5vw-2px)] w-[calc(5vw-2px)] md:h-[calc(4vw-2px)] md:w-[calc(4vw-2px)] lg:h-[calc(3vw-4px)] lg:w-[calc(3vw-4px)] bg-gray-900 hover:bg-[#00FF00]"></div>'
        for (var k = 1; k <= 1000; k++) {
            el +=
                '<div class = " transition-colors duration-[1.5s] hover:duration-[0s] border-[#00FF00] h-[calc(5vw-2px)] w-[calc(5vw-2px)] md:h-[calc(4vw-2px)] md:w-[calc(4vw-2px)] lg:h-[calc(3vw-4px)] lg:w-[calc(3vw-4px)] bg-gray-900 hover:bg-[#00FF00]"></div>';
        };

        para.innerHTML = el;
        document.getElementById("myDIV").appendChild(para);
    </script>
</x-guest-layout>
