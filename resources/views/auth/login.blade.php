<x-guest-layout>
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- CHANGE TO IC -->

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ml-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form> --}}

    <div class="flex w-full min-h-screen">
        {{-- Left Side: Logo and info --}}
        <section class="relative flex items-center justify-center w-full max-h-screen overflow-hidden">

            {{-- Background overlay top --}}
            <img src="{{ asset('assets/images/bg-toppart.png') }}" alt=""
                class="absolute top-0 self-center w-full">
            {{-- Background image --}}
            <img src="{{ asset('assets/images/menara-pmint.png') }}" alt="" class="absolute bottom-0 w-2/3">
            {{-- Background overlay bottom --}}
            <img src="{{ asset('assets/images/bg-bottompart.png') }}" alt=""
                class="absolute bottom-0 self-center w-full">

            <div class="z-10 flex items-center w-full gap-4 bg-[#B8E3DB] bg-opacity-75 h-fit py-12 px-20">
                <img src="{{ asset('assets/images/logo.png') }}" alt="" class="w-36 h-fit">
                <div>
                    <h1 class="text-3xl font-black">SISTEM LOG KERJA</h1>
                    <div class="h-2 bg-[#50C0C7] my-3 w-16 rounded"></div>
                    <h2 class="text-lg font-bold">PERBADANAN MEMAJUKAN IKTISAD<br>NEGERI TERENGGANU</h2>
                </div>
            </div>
        </section>

        {{-- Right Side: Login form --}}
        <div class="flex flex-col justify-center w-8/12 px-24 bg-gray-100">
            <form method="POST" action="{{ route('login') }}">
                <h1 class="text-5xl font-black mb-14">Log Masuk</h1>
                {{-- Login Form --}}
                <div class="w-full mb-12">
                    @csrf
                    <label class="mb-3 form-control">
                        <div class="label">
                            <span class="label-text">E-mel</span>
                        </div>
                        <input type="text" placeholder="Isi e-mel" class="w-full input input-bordered" name="email"
                            :value="old('email')" required autofocus autocomplete="email" />
                        <x-input-login-error :messages="$errors->get('email')" />
                    </label>
                    <label class="form-control">
                        <div class="label">
                            <span class="label-text">Kata Laluan</span>
                        </div>
                        <input type="password" name="password" placeholder="Isi kata laluan"
                            class="w-full input input-bordered" required autocomplete="current-password" />
                        <x-input-login-error :messages="$errors->get('password')" />
                    </label>
                </div>
                {{-- Forget password --}}
                {{-- <a href="#" class="mb-12 link-hover link-neutral link">Lupa kata laluan?</a> --}}
                <button type="submit" class="btn btn-primary btn-block">Log Masuk</button>
            </form>
            <div class="mx-auto mt-16">@ UiTM Cawangan Terengganu</div>
        </div>

    </div>


</x-guest-layout>
