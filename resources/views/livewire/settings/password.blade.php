{{-- @layout('components.layouts.app') --}}

<section class="w-full">
    {{-- @include('partials.settings-heading') --}}

    <x-settings.layout :heading="__('Update password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <form method="POST" wire:submit="updatePassword" class="mt-6 space-y-6">
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Current password') }}
                </label>
                <input
                    id="current_password"
                    wire:model="current_password"
                    type="password"
                    required
                    autocomplete="current-password"
                    class="input-field @error('current_password') border-red-300 dark:border-red-600 @enderror"
                />
                @error('current_password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('New password') }}
                </label>
                <input
                    id="password"
                    wire:model="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="input-field @error('password') border-red-300 dark:border-red-600 @enderror"
                />
                @error('password')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    {{ __('Confirm Password') }}
                </label>
                <input
                    id="password_confirmation"
                    wire:model="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    class="input-field @error('password_confirmation') border-red-300 dark:border-red-600 @enderror"
                />
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <button type="submit" class="btn-primary">
                    {{ __('Save') }}
                </button>

                <x-action-message class="text-sm text-green-600 dark:text-green-400" on="password-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>
    </x-settings.layout>
</section>
