<x-app-layout>
    <x-slot name="title">Profile Settings</x-slot>

    <div class="min-h-screen bg-gray-900 text-gray-100 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- Header --}}
            <div class="mb-4">
                <h1 class="text-3xl font-bold text-gray-100 mb-2">Profile</h1>
                <p class="text-gray-400 text-sm">Make changes, keep things updated, or wipe it all clean—kind of like
                    love, but with fewer mixed signals. ❤️‍🩹

                    .</p>
            </div>

            {{-- Update Profile Info --}}
            <div class="card bg-gray-800 shadow-lg border border-gray-700">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">Update Profile</h2>
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="card bg-gray-800 shadow-lg border border-gray-700">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold text-gray-100 mb-4">Change Password</h2>
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card bg-gray-800 shadow-lg border border-gray-700">
                <div class="card-body p-6">
                    <h2 class="text-xl font-semibold text-red-400 mb-4">Delete Account</h2>
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
