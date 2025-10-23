<div class="space-y-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-lg p-6 border border-primary-200 dark:border-primary-800">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            Selamat Datang, {{ Auth::user()->name }}!
        </h1>
        <p class="text-gray-600 dark:text-gray-300">
            Kelola toko velg motor Anda dengan mudah melalui panel admin ini.
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_users']) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+12%</span>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp12,345</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+8%</span>
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
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Orders</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_pesanan']) }}</p>
                </div>
            </div>
            <div class="mt-4">
                <span class="text-green-600 dark:text-green-400 text-sm font-medium">+15%</span>
                <span class="text-gray-600 dark:text-gray-400 text-sm ml-2">from last month</span>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid gap-6 md:grid-cols-4">
        <div class="card p-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_produk'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Produk</p>
            </div>
        </div>

        <div class="card p-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_kategori'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Kategori</p>
            </div>
        </div>

        <div class="card p-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_merk'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Merk</p>
            </div>
        </div>

        <div class="card p-6">
            <div class="text-center">
                <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/50 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_stok'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">Total Stok</p>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="grid gap-6 lg:grid-cols-2">
        <!-- Chart Area -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Analytics Overview
                </h3>
                <button class="btn-secondary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
            <div class="h-64 bg-gradient-to-br from-primary-50 to-accent-50 dark:from-primary-900/20 dark:to-accent-900/20 rounded-lg flex items-center justify-center">
                <div class="text-center">
                    <svg class="w-16 h-16 text-primary-300 dark:text-primary-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p class="text-primary-600 dark:text-primary-400 font-medium">Chart placeholder</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Add your favorite chart library</p>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                Recent Activity
            </h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">New user registered</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">2 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-accent-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Payment received</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">5 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Order completed</p>
                        <p class="text-xs text-gray-400">10 minutes ago</p>
                    </div>
                </div>
                <div class="flex items-start space-x-3">
                    <div class="w-2 h-2 bg-gray-400 rounded-full mt-2"></div>
                    <div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">System maintenance</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">1 hour ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Actions</h3>
        <div class="grid gap-4 md:grid-cols-4">
            <a href="{{ route('admin.produk.index') }}" class="btn-primary text-center">
                <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Tambah Produk
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="btn-secondary text-center">
                <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                Kelola Kategori
            </a>
            <a href="{{ route('admin.merk.index') }}" class="btn-secondary text-center">
                <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
                Kelola Merk
            </a>
            <a href="#" class="btn-secondary text-center opacity-50 cursor-not-allowed">
                <svg class="w-5 h-5 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Kelola Pesanan
            </a>
        </div>
    </div>
</div>
