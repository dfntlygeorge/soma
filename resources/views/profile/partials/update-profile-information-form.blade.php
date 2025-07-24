<section class="bg-gray-800 border border-gray-700 rounded-xl p-6 text-gray-100 shadow-lg">
    <header class="mb-4">
        <h2 class="text-xl font-semibold text-olive-400">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" class="text-gray-300" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-100 focus:border-olive-500 focus:ring-olive-500"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" class="text-gray-300" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full bg-gray-900 border-gray-700 text-gray-100 focus:border-olive-500 focus:ring-olive-500"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2 text-red-400" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-400">
                    <p>
                        {{ __('Your email address is unverified.') }}
                        <button form="send-verification"
                            class="underline text-olive-400 hover:text-olive-300 transition">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-500">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save Button --}}
        <div class="flex items-center gap-4">
            <x-primary-button class="bg-olive-600 hover:bg-olive-700 text-gray-900 border-none focus:ring-olive-500">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-olive-400">
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
