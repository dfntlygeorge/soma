<section class="bg-gray-800 border border-gray-700 rounded-xl p-6 text-gray-100 shadow-lg">
    <header class="mb-4">
        <h2 class="text-xl font-semibold text-olive-400">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div>
            <x-input-label for="update_password_current_password" class="text-gray-300" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-100 focus:border-olive-500 focus:ring-olive-500"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-400" />
        </div>

        {{-- New Password --}}
        <div>
            <x-input-label for="update_password_password" class="text-gray-300" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-100 focus:border-olive-500 focus:ring-olive-500"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-400" />
        </div>

        {{-- Confirm Password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" class="text-gray-300" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-100 focus:border-olive-500 focus:ring-olive-500"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-olive-600 hover:bg-olive-700 text-gray-900 border-none focus:ring-olive-500">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-olive-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
