<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-8">
                <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600">
                    <i class="fas fa-home mr-1"></i>
                    Beranda
                </a>
                <i class="fas fa-chevron-right"></i>
                <a href="{{ route('kategori', $produk->kategori->id) }}" wire:navigate class="hover:text-primary-600">
                    {{ $produk->kategori->nama }}
                </a>
                <i class="fas fa-chevron-right"></i>
                <span class="text-gray-900 font-medium">{{ $produk->nama }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-w-1 aspect-h-1 bg-white rounded-lg shadow-sm overflow-hidden">
                        <img src="{{ $produk->foto ?? 'https://via.placeholder.com/600x600?text=Velg+Motor' }}" 
                             alt="{{ $produk->nama }}" 
                             class="w-full h-96 object-cover">
                    </div>
                    
                    <!-- Additional Images Placeholder -->
                    @if($produk->foto)
                        <div class="grid grid-cols-4 gap-2">
                            @for($i = 0; $i < 4; $i++)
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-md overflow-hidden cursor-pointer border-2 {{ $activeImageIndex === $i ? 'border-primary-500' : 'border-transparent' }}"
                                     wire:click="changeImage({{ $i }})">
                                    <img src="{{ $produk->foto }}" 
                                         alt="{{ $produk->nama }} - Gambar {{ $i + 1 }}" 
                                         class="w-full h-20 object-cover">
                                </div>
                            @endfor
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Title and Price -->
                    <div>
                        <div class="flex items-center space-x-2 mb-2">
                            <span class="bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $produk->kategori->nama }}
                            </span>
                            <span class="bg-accent-100 text-accent-700 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $produk->merk->nama_merk ?? 'Merk' }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $produk->nama }}</h1>
                        <div class="flex items-center space-x-4 mb-4">
                            <span class="text-4xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                            </span>
                            @if($produk->stok)
                                <span class="text-sm {{ $produk->stok > 10 ? 'text-green-700 bg-green-100' : 'text-orange-700 bg-orange-100' }} px-3 py-1 rounded-full font-semibold">
                                    <i class="fas fa-box mr-1"></i>
                                    Stok: {{ $produk->stok }}
                                </span>
                            @else
                                <span class="text-sm text-red-700 bg-red-100 px-3 py-1 rounded-full font-semibold">
                                    <i class="fas fa-times mr-1"></i>
                                    Stok Habis
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Spesifikasi</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Kategori:</span>
                                <span class="font-medium">{{ $produk->kategori->nama }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Merk:</span>
                                <span class="font-medium">{{ $produk->merk->nama_merk ?? '-' }}</span>
                            </div>
                            @if($produk->ukuran)
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Ukuran:</span>
                                    <span class="font-medium">{{ $produk->ukuran }}</span>
                                </div>
                            @endif
                            <div class="flex justify-between">
                                <span class="text-gray-500">Stok:</span>
                                <span class="font-medium">{{ $produk->stok ?? 0 }} unit</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity and Add to Cart -->
                    @if($produk->stok > 0)
                        <div class="border-t border-gray-200 pt-6">
                            <div class="flex items-center space-x-4 mb-6">
                                <label class="text-sm font-medium text-gray-700">Jumlah:</label>
                                <div class="flex items-center space-x-2">
                                    <button wire:click="decrementQuantity" 
                                            class="p-2 border border-gray-300 rounded-md hover:bg-gray-50"
                                            {{ $quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="fas fa-minus text-gray-400"></i>
                                    </button>
                                    <span class="px-4 py-2 border border-gray-300 rounded-md font-medium min-w-[3rem] text-center">
                                        {{ $quantity }}
                                    </span>
                                    <button wire:click="incrementQuantity" 
                                            class="p-2 border border-gray-300 rounded-md hover:bg-gray-50"
                                            {{ $quantity >= $produk->stok ? 'disabled' : '' }}>
                                        <i class="fas fa-plus text-gray-400"></i>
                                    </button>
                                </div>
                                <span class="text-sm text-gray-500">Maksimal {{ $produk->stok }} unit</span>
                            </div>

                            <div class="flex space-x-4">
                                @auth
                                    <livewire:customer.add-to-cart 
                                        :produk-id="$produk->id" 
                                        :quantity="$quantity"
                                        :key="'add-to-cart-detail-'.$produk->id" />
                                @else
                                    <a href="{{ route('login') }}" 
                                       class="flex-1 btn-primary text-center text-lg py-3">
                                        <i class="fas fa-sign-in-alt mr-2"></i>
                                        Login untuk Membeli
                                    </a>
                                @endauth
                                
                                <button class="btn-secondary px-6">
                                    <i class="fas fa-heart"></i>
                                </button>
                                <button class="btn-secondary px-6">
                                    <i class="fas fa-share-alt"></i>
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- Trust Signals -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center text-green-600">
                                <i class="fas fa-shield-alt mr-2"></i>
                                <span>Garansi Resmi</span>
                            </div>
                            <div class="flex items-center text-blue-600">
                                <i class="fas fa-shipping-fast mr-2"></i>
                                <span>Gratis Ongkir</span>
                            </div>
                            <div class="flex items-center text-purple-600">
                                <i class="fas fa-headset mr-2"></i>
                                <span>Support 24/7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            @if($produk->deskripsi)
                <div class="bg-white rounded-lg shadow-sm p-8 mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Deskripsi Produk</h3>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($produk->deskripsi)) !!}
                    </div>
                </div>
            @endif

            <!-- Reviews Section -->
            @if($produk->ulasan->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-8 mb-12">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">
                        Ulasan Pembeli 
                        <span class="text-lg font-normal text-gray-500">({{ $produk->ulasan->count() }} ulasan)</span>
                    </h3>
                    
                    <div class="space-y-6">
                        @foreach($produk->ulasan->take(5) as $ulasan)
                            <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                <div class="flex items-start space-x-4">
                                    <div class="w-10 h-10 bg-primary-500 rounded-full flex items-center justify-center text-white font-medium">
                                        {{ $ulasan->user->initials() }}
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <h4 class="font-medium text-gray-900">{{ $ulasan->user->name }}</h4>
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star text-sm {{ $i <= $ulasan->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-gray-700 mb-2">{{ $ulasan->komentar }}</p>
                                        <span class="text-sm text-gray-500">{{ $ulasan->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Related Products -->
            @if($relatedProduk->count() > 0)
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Produk Serupa</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($relatedProduk as $related)
                            <div class="card overflow-hidden hover:shadow-lg transition-all duration-300">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-100">
                                    <img src="{{ $related->foto ?? 'https://via.placeholder.com/200x200?text=Velg' }}" 
                                         alt="{{ $related->nama }}" 
                                         class="w-full h-48 object-cover">
                                </div>
                                <div class="p-4">
                                    <h4 class="font-medium text-gray-900 mb-2 line-clamp-2">
                                        <a href="{{ route('produk.detail', $related->id) }}" wire:navigate class="hover:text-primary-600">
                                            {{ $related->nama }}
                                        </a>
                                    </h4>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-primary-600">
                                            Rp {{ number_format($related->harga, 0, ',', '.') }}
                                        </span>
                                        <a href="{{ route('produk.detail', $related->id) }}" wire:navigate
                                           class="text-sm text-primary-600 hover:text-primary-700">
                                            Lihat <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
