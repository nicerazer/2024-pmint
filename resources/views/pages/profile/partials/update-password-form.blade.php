<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Kemaskini Kata Laluan
        </h2>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div class="form-control">
            <x-input-label for="current_password" :value="'Password Semasa'" />
            <x-text-input id="current_password" name="current_password" type="password" class="block w-full mt-1"
                autocomplete="current-password" />
            <x-input-general-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="form-control">
            <x-input-label for="password" :value="'Kata Laluan Baharu'" />
            <x-text-input id="password" name="password" type="password" class="block w-full mt-1"
                autocomplete="new-password" />
            <x-input-general-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="form-control">
            <x-input-label for="password_confirmation" :value="'Sahkan Kata Laluan Baharu'" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                class="block w-full mt-1" autocomplete="new-password" />
            <x-input-general-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
