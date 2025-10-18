<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form method="POST" wire:submit="login" class="flex flex-col gap-6">
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
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                class="input-field @error('email') border-red-300 dark:border-red-600 @enderror"
            />
            @error('email')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="relative">
            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                {{ __('Password') }}
            </label>
            <input
                id="password"
                wire:model="password"
                type="password"
                required
                autocomplete="current-password"
                placeholder="{{ __('Password') }}"
                class="input-field @error('password') border-red-300 dark:border-red-600 @enderror"
            />
            @error('password')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   wire:navigate
                   class="absolute top-0 right-0 text-sm text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input 
                id="remember" 
                wire:model="remember" 
                type="checkbox"
                class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
            <label for="remember" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn-primary w-full" data-test="login-button">
                {{ __('Log in') }}
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <div class="text-sm text-center text-gray-600 dark:text-gray-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" 
               wire:navigate
               class="text-primary-600 dark:text-primary-400 hover:text-primary-500 dark:hover:text-primary-300 font-medium ml-1">
                {{ __('Sign up') }}
            </a>
        </div>
    @endif
</div>
