<x-layouts.customer>
    <x-slot name="title">Moka Madali Velg Motor Premium</x-slot>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-primary-500 via-primary-400 to-accent-500 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-pattern opacity-10"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-7xl font-bold mb-8 drop-shadow-lg">
                    Velg Motor <span class="text-white drop-shadow-md">Premium</span>
                </h1>
                <p class="text-xl md:text-2xl mb-10 text-primary-50 max-w-3xl mx-auto leading-relaxed">
                    Koleksi velg terlengkap dengan kualitas terbaik untuk motor impian Anda
                </p>
                <a href="#produk" class="btn-accent text-lg px-10 py-4 rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Lihat Koleksi
                </a>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-20 bg-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Kategori Populer</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Temukan velg sesuai gaya dan kebutuhan Anda dengan berbagai pilihan kategori premium</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @php
                    $kategoriPopuler = \App\Models\KategoriProduk::withCount('produk')
                                                                ->orderBy('produk_count', 'desc')
                                                                ->take(3)
                                                                ->get();
                @endphp
                
                @forelse($kategoriPopuler as $kategori)
                    <div class="card p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-circle text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">{{ $kategori->nama }}</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">{{ $kategori->deskripsi ?? 'Kategori velg berkualitas tinggi dengan standar premium' }}</p>
                        <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-semibold">{{ $kategori->produk_count }} Produk</span>
                    </div>
                @empty
                    <!-- Default categories if no data -->
                    <div class="card p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-motorcycle text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Racing</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Velg racing untuk performa maksimal dengan desain aerodinamis</p>
                        <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-semibold">10+ Produk</span>
                    </div>
                    
                    <div class="card p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-star text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Premium</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Velg premium dengan desain eksklusif dan material berkualitas tinggi</p>
                        <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-semibold">8+ Produk</span>
                    </div>

                    <div class="card p-8 text-center hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-cog text-3xl text-white"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">OEM</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">Velg pengganti resmi pabrikan dengan jaminan kualitas original</p>
                        <span class="inline-block bg-primary-100 text-primary-700 px-4 py-2 rounded-full text-sm font-semibold">15+ Produk</span>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section id="produk" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Produk Terbaru</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Koleksi velg motor terbaik dan terbaru dengan teknologi dan desain terdepan</p>
            </div>
            
            <!-- Flash Messages -->
            @if (session()->has('cart-message'))
                <div class="mb-8 bg-accent-100 border border-accent-400 text-accent-700 px-6 py-4 rounded-lg relative shadow-lg" role="alert">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-3 text-accent-600"></i>
                        <span class="block sm:inline font-medium">{{ session('cart-message') }}</span>
                    </div>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <svg class="fill-current h-6 w-6 text-accent-600 hover:text-accent-700" role="button" viewBox="0 0 20 20">
                            <path d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.030c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"></path>
                        </svg>
                    </span>
                </div>
            @endif

            <!-- Product Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                    $produkTerbaru = \App\Models\Produk::with(['kategori', 'merk'])
                                                        ->latest()
                                                        ->take(8)
                                                        ->get();
                @endphp
                
                @forelse($produkTerbaru as $produk)
                    <div class="card overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                        <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-primary-100 to-accent-100 relative overflow-hidden">
                            <img src="{{ asset('storage/produk/' . $produk->foto) }}"
                                 alt="{{ $produk->nama }}" 
                                 class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            @if($produk->stok && $produk->stok <= 5)
                                <div class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Stok Terbatas
                                </div>
                            @endif
                        </div>
                        <div class="p-6">
                            <div class="flex items-center text-xs text-primary-600 mb-2 font-medium">
                                <span class="bg-primary-100 px-2 py-1 rounded-full mr-2">{{ $produk->kategori->nama ?? 'Kategori' }}</span>
                                <span class="bg-accent-100 px-2 py-1 rounded-full">{{ $produk->merk->nama ?? 'Merk' }}</span>
                            </div>
                            <h3 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-700 transition-colors">{{ $produk->nama }}</h3>
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                                @if($produk->stok)
                                    <span class="text-xs text-green-700 bg-green-100 px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-check mr-1"></i>Stok: {{ $produk->stok }}
                                    </span>
                                @endif
                            </div>
                            @if($produk->ukuran)
                                <div class="text-sm text-gray-600 mb-4 flex items-center">
                                    <i class="fas fa-ruler-combined mr-2 text-primary-500"></i>
                                    Ukuran: {{ $produk->ukuran }}
                                </div>
                            @endif
                            
                            @auth
                                <livewire:customer.add-to-cart :produk-id="$produk->id" :key="'add-to-cart-'.$produk->id" />
                            @else
                                <a href="{{ route('login') }}" 
                                   class="btn-secondary w-full text-center block">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login untuk Beli
                                </a>
                            @endauth
                        </div>
                    </div>
                @empty
                    @for($i = 1; $i <= 8; $i++)
                        <div class="card overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                            <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-primary-100 to-accent-100 relative overflow-hidden">
                                <img src="https://via.placeholder.com/300x300?text=Velg+Motor+{{ $i }}" 
                                     alt="Velg Motor {{ $i }}" 
                                     class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>
                            <div class="p-6">
                                <div class="flex items-center text-xs text-primary-600 mb-2 font-medium">
                                    <span class="bg-primary-100 px-2 py-1 rounded-full mr-2">Racing</span>
                                    <span class="bg-accent-100 px-2 py-1 rounded-full">OEM</span>
                                </div>
                                <h3 class="font-bold text-lg text-gray-900 mb-3 group-hover:text-primary-700 transition-colors">Velg Motor Racing Type {{ $i }}</h3>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">Rp {{ number_format(rand(500000, 2000000), 0, ',', '.') }}</span>
                                    <span class="text-xs text-green-700 bg-green-100 px-3 py-1 rounded-full font-semibold">
                                        <i class="fas fa-check mr-1"></i>Tersedia
                                    </span>
                                </div>
                                <div class="text-sm text-gray-600 mb-4 flex items-center">
                                    <i class="fas fa-ruler-combined mr-2 text-primary-500"></i>
                                    Ukuran: {{ rand(14, 17) }}"
                                </div>
                                @auth
                                    <button class="btn-primary w-full">
                                        <i class="fas fa-shopping-cart mr-2"></i>
                                        Tambah ke Keranjang
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="btn-secondary w-full text-center block">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login untuk Beli
                                    </a>
                                @endauth
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>

            <div class="text-center mt-16">
                <a href="#" class="btn-primary text-xl px-12 py-4 shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300">
                    <i class="fas fa-th-large mr-3"></i>
                    Lihat Semua Produk
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="py-20 bg-primary-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">Mengapa Pilih Kami?</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">Keunggulan yang membuat kami menjadi pilihan terbaik untuk kebutuhan velg motor Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Garansi Resmi</h3>
                    <p class="text-gray-600 leading-relaxed">Semua produk bergaransi resmi dari pabrikan dengan layanan purna jual terpercaya</p>
                </div>

                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-shipping-fast text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Pengiriman Cepat</h3>
                    <p class="text-gray-600 leading-relaxed">Pengiriman ke seluruh Indonesia dengan aman, cepat, dan sistem tracking real-time</p>
                </div>

                <div class="text-center group">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-headset text-3xl text-white"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Customer Service</h3>
                    <p class="text-gray-600 leading-relaxed">Layanan pelanggan profesional 24/7 siap membantu dengan respon cepat dan solusi terbaik</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Cart update events -->
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('cart-updated', () => {
                // Refresh the page to update cart count in header
                window.location.reload();
            });
        });
    </script>
</x-layouts.customer>