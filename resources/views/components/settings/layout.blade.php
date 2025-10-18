<div class="flex items-start max-md:flex-col">
    <div class="mr-10 w-full pb-4 md:w-[220px]">
        <nav class="space-y-1">
            <a href="{{ route('settings.profile') }}" 
               wire:navigate
               class="nav-item {{ request()->routeIs('settings.profile') ? 'active' : '' }}">
                {{ __('Profile') }}
            </a>
            <a href="{{ route('settings.password') }}" 
               wire:navigate
               class="nav-item {{ request()->routeIs('settings.password') ? 'active' : '' }}">
                {{ __('Password') }}
            </a>
            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <a href="{{ route('two-factor.show') }}" 
                   wire:navigate
                   class="nav-item {{ request()->routeIs('two-factor.show') ? 'active' : '' }}">
                    {{ __('Two-Factor Auth') }}
                </a>
            @endif
            <a href="{{ route('settings.appearance') }}" 
               wire:navigate
               class="nav-item {{ request()->routeIs('settings.appearance') ? 'active' : '' }}">
                {{ __('Appearance') }}
            </a>
        </nav>
    </div>

    <div class="border-t border-gray-200 dark:border-gray-700 md:hidden my-4"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $heading ?? '' }}</h1>
            @if($subheading ?? false)
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $subheading }}</p>
            @endif
        </div>

        <div class="w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
