<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
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
                placeholder="{{ __('Full name') }}"
                class="input-field @error('name') border-red-300 dark:border-red-600 @enderror"
            />
            @error('name')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Email address') }}
            </label>
            <input
                id="email"
                wire:model="email"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
                class="input-field @error('email') border-red-300 dark:border-red-600 @enderror"
            />
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Password') }}
            </label>
            <input
                id="password"
                wire:model="password"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Password') }}"
                class="input-field @error('password') border-red-300 dark:border-red-600 @enderror"
            />
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Confirm password') }}
            </label>
            <input
                id="password_confirmation"
                wire:model="password_confirmation"
                type="password"
                required
                autocomplete="new-password"
                placeholder="{{ __('Confirm password') }}"
                class="input-field @error('password_confirmation') border-red-300 dark:border-red-600 @enderror"
            />
            @error('password_confirmation')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn-primary w-full">
                {{ __('Create account') }}
            </button>
        </div>
    </form>

    <div class="text-sm text-center text-gray-600 dark:text-gray-400">
        <span>{{ __('Already have an account?') }}</span>
        <a href="{{ route('login') }}" 
           wire:navigate
           class="text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 font-medium ml-1">
            {{ __('Log in') }}
        </a>
    </div>
</div>
