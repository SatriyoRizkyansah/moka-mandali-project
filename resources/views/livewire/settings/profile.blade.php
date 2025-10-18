@layout('components.layouts.app')

<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Name') }}
                </label>
                <input
                    id="name"
                    wire:model="name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                    class="input-field @error('name') border-red-300 dark:border-red-600 @enderror"
                />
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Email') }}
                </label>
                <input
                    id="email"
                    wire:model="email"
                    type="email"
                    required
                    autocomplete="email"
                    class="input-field @error('email') border-red-300 dark:border-red-600 @enderror"
                />
                @error('email')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail &&! auth()->user()->hasVerifiedEmail())
                    <div class="mt-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Your email address is unverified.') }}

                            <button type="button" 
                                    wire:click.prevent="resendVerificationNotification" 
                                    class="text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 font-medium">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>

                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 text-sm font-medium text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    {{ __('Save') }}
                </button>

                <x-action-message class="text-sm text-green-600 dark:text-green-400" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        <livewire:settings.delete-user-form />
    </x-settings.layout>
</section>
