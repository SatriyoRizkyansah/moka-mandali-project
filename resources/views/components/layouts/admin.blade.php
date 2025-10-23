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
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2" wire:navigate>
                        <x-app-logo />
                        <span class="text-lg font-bold text-gray-900 dark:text-white">Admin</span>
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
                            <a href="{{ route('admin.dashboard') }}" 
                               class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                               wire:navigate>
                                <x-icons.home class="mr-3" />
                                {{ __('Dashboard') }}
                            </a>
                        </div>

                        <!-- Admin Management Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                {{ __('Management') }}
                            </h3>
                            
                            <a href="{{ route('admin.kategori.index') }}" 
                               class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                {{ __('Kategori') }}
                            </a>
                            
                            <a href="{{ route('admin.merk.index') }}" 
                               class="nav-item {{ request()->routeIs('admin.merk.*') ? 'active' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ __('Merk') }}
                            </a>
                            
                            <a href="{{ route('admin.produk.index') }}" 
                               class="nav-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ __('Produk') }}
                            </a>
                        </div>

                        <!-- Coming Soon Section -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3">
                                {{ __('Operations') }}
                            </h3>
                            
                            <a href="#" class="nav-item opacity-50 cursor-not-allowed">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                {{ __('Pesanan') }}
                                <span class="ml-auto text-xs text-gray-400">Soon</span>
                            </a>
                            
                            <a href="#" class="nav-item opacity-50 cursor-not-allowed">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                {{ __('Users') }}
                                <span class="ml-auto text-xs text-gray-400">Soon</span>
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
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role }}</div>
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
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->role }}</div>
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

            <!-- Page Content -->
            <main class="flex-1 p-6 bg-white dark:bg-gray-900">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
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