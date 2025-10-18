<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-lg p-6 border border-primary-200 dark:border-primary-800">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            {{ __('Welcome back, :name!', ['name' => $userName]) }}
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            {{ __('Here\'s what\'s happening with your account today.') }}
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="grid gap-6 md:grid-cols-3">
        <div class="card p-6">
            <div class="flex items-center">
                <div class="p-2 bg-primary-100 dark:bg-primary-900/50 rounded-lg">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Total Users') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($userStats['totalUsers']) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+{{ $userStats['growth']['users'] }}%</span>
                <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">from last month</span>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center">
                <div class="p-2 bg-accent-100 dark:bg-accent-900/50 rounded-lg">
                    <svg class="w-6 h-6 text-accent-600 dark:text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Revenue') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($userStats['revenue']) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+{{ $userStats['growth']['revenue'] }}%</span>
                <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">from last month</span>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center">
                <div class="p-2 bg-primary-100 dark:bg-primary-900/50 rounded-lg">
                    <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('Orders') }}</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($userStats['orders']) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+{{ $userStats['growth']['orders'] }}%</span>
                <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">from last month</span>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Chart Area -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('Analytics Overview') }}
                </h3>
                <button wire:click="refreshStats" class="btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    {{ __('Refresh') }}
                </button>
            </div>
            <div class="h-64 bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-primary-300 dark:text-primary-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-primary-600 dark:text-primary-400 font-medium">{{ __('Chart placeholder') }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Add your favorite chart library') }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                {{ __('Recent Activity') }}
            </h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('New user registered') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('2 minutes ago') }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-accent-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Payment received') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('5 minutes ago') }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('Order completed') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('10 minutes ago') }}</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-gray-400 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('System maintenance') }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('1 hour ago') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
