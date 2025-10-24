<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-gray-50 dark:bg-gray-900" 
          x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 lg:translate-x-0 flex flex-col"
              :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                
                <!-- Sidebar Header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-200 dark:border-gray-700">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2" wire:navigate>
                        <x-app-logo />
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden p-1 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                        <x-icons.x-mark />
                    </button>
                </div>

                <!-- Navigation -->
                <div class="flex-1 overflow-y-auto">
                    <nav class="px-4 py-6 space-y-2">
                        <!-- Platform Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                {{ __('Platform') }}
                            </h3>
                            <a href="{{ route('home') }}" 
                               class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}"
                               wire:navigate>
                                <x-icons.home class="mr-3" />
                                {{ __('Home') }}
                            </a>
                        </div>

                        

                        
                        <!-- External Links -->
                        <div class="space-y-2 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="https://github.com/laravel/livewire-starter-kit" 
                               target="_blank"
                               class="nav-item">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                                {{ __('Repository') }}
                            </a>
                            <a href="https://laravel.com/docs/starter-kits#livewire" 
                               target="_blank"
                               class="nav-item">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                {{ __('Documentation') }}
                            </a>
                        </div>
                    </nav>
                </div>

                <!-- Desktop User Menu (sticky at bottom, outside scrollable area) -->
                <div class="hidden lg:block p-4 border-t border-gray-200 dark:border-gray-700">
                    <div x-data="{ userMenuOpen: false }" class="relative">
                        <button @click="userMenuOpen = !userMenuOpen" 
                                class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center text-primary-700 dark:text-primary-300 font-semibold">
                                    {{ auth()->user()->initials() }}
                                </div>
                                <div class="text-left">
                                    <div class="font-medium text-gray-900 dark:text-white text-sm">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</div>
                                </div>
                            </div>
                            <x-icons.chevron-down class="text-gray-400" />
                        </button>

                        <!-- User Dropdown -->
                        <div x-show="userMenuOpen" 
                             @click.away="userMenuOpen = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute bottom-full left-0 right-0 mb-2 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                            
                            <a href="{{ route('settings.profile') }}" 
                               wire:navigate
                               class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <x-icons.cog class="mr-3" />
                                {{ __('Settings') }}
                            </a>
                            
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-left">
                                    <x-icons.logout class="mr-3" />
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                </div>

            <!-- Main Content Area -->
            <div class="flex-1 lg:ml-64">
                <!-- Mobile Header -->
                <header class="lg:hidden bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-4 py-3">
                    <div class="flex items-center justify-between">
                        <button @click="sidebarOpen = true" 
                                class="p-2 rounded-lg text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                            <x-icons.bars-2 />
                        </button>
                        
                        <div class="flex items-center space-x-3">
                            <x-dark-mode-toggle />
                            
                            <div x-data="{ mobileUserMenuOpen: false }" class="relative">
                                <button @click="mobileUserMenuOpen = !mobileUserMenuOpen" 
                                        class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900 rounded-lg flex items-center justify-center text-primary-700 dark:text-primary-300 font-semibold">
                                        {{ auth()->user()->initials() }}
                                    </div>
                                    <x-icons.chevron-down class="text-gray-400" />
                                </button>

                                <!-- Mobile User Dropdown -->
                                <div x-show="mobileUserMenuOpen" 
                                     @click.away="mobileUserMenuOpen = false"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 py-2">
                                    
                                    <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                                        <div class="font-medium text-gray-900 dark:text-white text-sm">{{ auth()->user()->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</div>
                                    </div>
                                    
                                    <a href="{{ route('settings.profile') }}" 
                                       wire:navigate
                                       class="flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <x-icons.cog class="mr-3" />
                                        {{ __('Settings') }}
                                    </a>
                                    
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" 
                                                class="w-full flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 text-left">
                                            <x-icons.logout class="mr-3" />
                                            {{ __('Log Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Desktop Dark Mode Toggle -->
                <div class="hidden lg:block fixed top-4 right-4 z-40">
                    <x-dark-mode-toggle />
                </div>

                {{ $slot }}
            </div>
        </div>

        <!-- Sidebar Overlay for Mobile -->
        <div x-show="sidebarOpen" 
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="lg:hidden fixed inset-0 z-40 bg-black bg-opacity-50"></div>
             
        @livewireScripts
<style>
/* Override NProgress top loader: kuning -> oranye */
#nprogress .bar,
.nprogress .bar {
  background: linear-gradient(90deg, #FEEBC8 0%, #F59E0B 100%) !important; /* pale yellow -> orange */
  height: 3px !important;
}

#nprogress .peg,
.nprogress .peg {
  box-shadow: 0 0 10px #F59E0B, 0 0 5px #FEEBC8 !important;
  opacity: 1 !important;
  transform: rotate(3deg) translate(0px, -4px) !important;
}

/* Spinner (if used) */
#nprogress .spinner,
.nprogress .spinner {
  display: none; /* sembunyikan spinner, hapus jika ingin tampilkan */
}
#nprogress .spinner-icon,
.nprogress .spinner-icon {
  border-top-color: #F59E0B !important;
  border-left-color: #FEEBC8 !important;
}
</style>
    </body>
</html>
