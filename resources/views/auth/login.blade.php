<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <!-- Pesan Error -->
    @if(session('error'))
        <div class="mb-4 p-4 text-sm text-red-600 bg-red-100 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="relative z-50">
        @csrf
        <div class="w-full min-h-screen flex items-center justify-center px-4">
            <div class="w-full sm:w-[400px] md:w-[500px] lg:w-[400px] p-2 sm:p-4">
                <div class="bg-gray-500 bg-opacity-20 backdrop-filter backdrop-blur-sm text-white py-4 px-6 rounded-lg">
                    <div class="w-full flex justify-center text-xl mb-5">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </div>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-4 p-4 text-sm text-green-600 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- email --}}
                    <div class="mb-6">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        @error('email')
                            <div class="mt-2 text-sm text-red-600 bg-red-100 rounded-lg p-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- password --}}
                    <div class="mb-6">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                            autocomplete="current-password" />
                        @error('password')
                            <div class="mt-2 text-sm text-red-600 bg-red-100 rounded-lg p-2">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- remember me --}}
                    <div class="flex flex-row justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="ms-2 text-sm text-slate-300">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    {{-- forgot pass --}}
                    <div class="flex items-center mt-4">
                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-slate-400 hover:text-slate-500 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    {{-- login --}}
                    <x-primary-button class="w-full justify-center mt-4">
                        {{ __('Log in') }}
                    </x-primary-button>

                    <div class="flex justify-center text-[#96c496] text-sm md:text-md mt-4">
                        Don't have an account?&nbsp;
                        <a class="underline text-sm text-[#96c496] hover:text-[#00FF00] rounded-md focus:outline-none"
                            href="{{ route('register') }}">
                            {{ __('Sign up now!') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div id="myDIV" class="fixed inset-0 z-0">
        <script>
            const para = document.createElement("div");
            para.className = 'flex flex-wrap gap-0.5 h-screen items-center justify-center';
            let el = '<div class="transition-colors duration-[1.5s] hover:duration-[0s] border-[#00FF00] h-[calc(5vw-2px)] w-[calc(5vw-2px)] md:h-[calc(4vw-2px)] md:w-[calc(4vw-2px)] lg:h-[calc(3vw-4px)] lg:w-[calc(3vw-4px)] bg-gray-900 hover:bg-[#00FF00]"></div>'
            for (var k = 1; k <= 1000; k++) {
                el += '<div class="transition-colors duration-[1.5s] hover:duration-[0s] border-[#00FF00] h-[calc(5vw-2px)] w-[calc(5vw-2px)] md:h-[calc(4vw-2px)] md:w-[calc(4vw-2px)] lg:h-[calc(3vw-4px)] lg:w-[calc(3vw-4px)] bg-gray-900 hover:bg-[#00FF00]"></div>';
            };
            para.innerHTML = el;
            document.getElementById("myDIV").appendChild(para);
        </script>
    </div>
</x-guest-layout>
