<div>
    <!-- Profile Header with Banner -->
    <div class="bg-gradient-to-br from-primary-500 via-primary-400 to-accent-500 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                    <span class="text-3xl font-bold text-primary-600">
                        {{ auth()->user()->initials() }}
                    </span>
                </div>
                <div class="text-white">
                    <h1 class="text-3xl font-bold">{{ auth()->user()->name }}</h1>
                    <p class="text-primary-100 text-lg">{{ auth()->user()->email }}</p>
                    <div class="flex items-center mt-2">
                        <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-medium">
                            <i class="fas fa-user-circle mr-2"></i>Customer
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Messages -->
        @if (session()->has('profile-message'))
            <div class="mb-8 bg-accent-100 border border-accent-400 text-accent-700 px-6 py-4 rounded-lg relative shadow-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-accent-600"></i>
                    <span class="block sm:inline font-medium">{{ session('profile-message') }}</span>
                </div>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                    <svg class="fill-current h-6 w-6 text-accent-600 hover:text-accent-700" role="button" viewBox="0 0 20 20">
                        <path d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.030c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path>
                    </svg>
                </span>
            </div>
        @endif

        @if (session()->has('password-message'))
            <div class="mb-8 bg-accent-100 border border-accent-400 text-accent-700 px-6 py-4 rounded-lg relative shadow-lg" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-3 text-accent-600"></i>
                    <span class="block sm:inline font-medium">{{ session('password-message') }}</span>
                </div>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                    <svg class="fill-current h-6 w-6 text-accent-600 hover:text-accent-700" role="button" viewBox="0 0 20 20">
                        <path d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.030c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path>
                    </svg>
                </span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar Navigation -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-8">
                    <nav class="space-y-2">
                        <button onclick="showTab('profile')" 
                               class="profile-tab w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium text-primary-700 bg-primary-50 border-l-4 border-primary-500">
                            <i class="fas fa-user mr-3"></i>
                            Informasi Profile
                        </button>
                        <button onclick="showTab('password')" 
                               class="password-tab w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-lock mr-3"></i>
                            Ubah Password
                        </button>
                        <a href="{{ route('pesanan') }}" wire:navigate
                           class="w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-shopping-bag mr-3"></i>
                            Riwayat Pesanan
                        </a>
                        <a href="{{ route('keranjang') }}" wire:navigate
                           class="w-full flex items-center px-4 py-3 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                            <i class="fas fa-shopping-cart mr-3"></i>
                            Keranjang Belanja
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-3">
                <!-- Profile Information Tab -->
                <div id="profile-content" class="tab-content">
                    <div class="card p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Informasi Profile</h2>
                                <p class="text-gray-600 mt-1">Kelola informasi pribadi dan kontak Anda</p>
                            </div>
                            <div class="text-primary-500">
                                <i class="fas fa-user-edit text-2xl"></i>
                            </div>
                        </div>
                        
                        <form wire:submit.prevent="updateProfile" class="space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-user mr-2 text-primary-500"></i>
                                        Nama Lengkap
                                    </label>
                                    <input type="text" id="name" wire:model="name" 
                                           class="input-field">
                                    @error('name') 
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-envelope mr-2 text-primary-500"></i>
                                        Alamat Email
                                    </label>
                                    <input type="email" id="email" wire:model="email" 
                                           class="input-field">
                                    @error('email') 
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label for="telepon" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-phone mr-2 text-primary-500"></i>
                                    Nomor Telepon
                                </label>
                                <input type="text" id="telepon" wire:model="telepon" 
                                       placeholder="Contoh: 08123456789"
                                       class="input-field">
                                @error('telepon') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div>
                                <label for="alamat" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-map-marker-alt mr-2 text-primary-500"></i>
                                    Alamat Lengkap
                                </label>
                                <textarea id="alamat" wire:model="alamat" rows="4" 
                                          placeholder="Masukkan alamat lengkap untuk pengiriman..."
                                          class="input-field resize-none"></textarea>
                                @error('alamat') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="flex justify-end pt-6 border-t border-gray-200">
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="btn-primary px-8 py-3 shadow-lg">
                                    <span wire:loading.remove>
                                        <i class="fas fa-save mr-2"></i>
                                        Simpan Perubahan
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Password Tab -->
                <div id="password-content" class="tab-content hidden">
                    <div class="card p-8">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900">Keamanan Password</h2>
                                <p class="text-gray-600 mt-1">Ubah password untuk menjaga keamanan akun Anda</p>
                            </div>
                            <div class="text-primary-500">
                                <i class="fas fa-shield-alt text-2xl"></i>
                            </div>
                        </div>
                        
                        <form wire:submit.prevent="updatePassword" class="space-y-8">
                            <div>
                                <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <i class="fas fa-key mr-2 text-primary-500"></i>
                                    Password Saat Ini
                                </label>
                                <input type="password" id="current_password" wire:model="current_password" 
                                       placeholder="Masukkan password lama Anda"
                                       class="input-field">
                                @error('current_password') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-lock mr-2 text-primary-500"></i>
                                        Password Baru
                                    </label>
                                    <input type="password" id="password" wire:model="password" 
                                           placeholder="Masukkan password baru"
                                           class="input-field">
                                    @error('password') 
                                        <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-3">
                                        <i class="fas fa-check-circle mr-2 text-primary-500"></i>
                                        Konfirmasi Password
                                    </label>
                                    <input type="password" id="password_confirmation" wire:model="password_confirmation" 
                                           placeholder="Ulangi password baru"
                                           class="input-field">
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-accent-50 to-primary-50 border border-accent-200 rounded-xl p-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-info-circle text-accent-500 text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-3">
                                            Persyaratan Password Aman
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                Minimal 8 karakter
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                Kombinasi huruf & angka
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                Hindari informasi pribadi
                                            </div>
                                            <div class="flex items-center">
                                                <i class="fas fa-check text-green-500 mr-2"></i>
                                                Tidak mudah ditebak
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end pt-6 border-t border-gray-200">
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="btn-primary px-8 py-3 shadow-lg">
                                    <span wire:loading.remove>
                                        <i class="fas fa-shield-alt mr-2"></i>
                                        Update Password
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Mengupdate...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab switching script -->
    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.add('hidden');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.profile-tab, .password-tab').forEach(tab => {
                tab.classList.remove('text-primary-700', 'bg-primary-50', 'border-l-4', 'border-primary-500');
                tab.classList.add('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
            });
            
            // Show selected tab content
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Add active class to selected tab
            const activeTab = document.querySelector('.' + tabName + '-tab');
            activeTab.classList.remove('text-gray-600', 'hover:text-gray-900', 'hover:bg-gray-50');
            activeTab.classList.add('text-primary-700', 'bg-primary-50', 'border-l-4', 'border-primary-500');
        }

        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const flashMessages = document.querySelectorAll('[role="alert"]');
                flashMessages.forEach(message => {
                    message.style.transition = 'opacity 0.5s ease-out';
                    message.style.opacity = '0';
                    setTimeout(() => message.remove(), 500);
                });
            }, 5000);
        });
    </script>
</div>
