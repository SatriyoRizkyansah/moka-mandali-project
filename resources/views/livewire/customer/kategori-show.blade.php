<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600">
                        <i class="fas fa-home mr-1"></i>
                        Beranda
                    </a>
                    <i class="fas fa-chevron-right"></i>
                    <a href="{{ route('home') }}" wire:navigate class="hover:text-primary-600">Kategori</a>
                    <i class="fas fa-chevron-right"></i>
                    <span class="text-gray-900 font-medium">{{ $kategori->nama }}</span>
                </nav>
                
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $kategori->nama }}</h1>
                        <p class="mt-2 text-gray-600">
                            {{ $kategori->deskripsi ?? 'Temukan koleksi velg motor terbaik dalam kategori ' . $kategori->nama }}
                        </p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-16 h-16 bg-gradient-to-br from-primary-500 to-accent-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-circle text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
                <div class="flex flex-col sm:flex-row gap-4 items-center justify-between">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <label for="search" class="sr-only">Cari produk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" wire:model.live.debounce.300ms="search" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                                   placeholder="Cari produk...">
                        </div>
                    </div>

                    <!-- Sort Options -->
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500">Urutkan:</span>
                        <div class="flex space-x-2">
                            <button wire:click="sortBy('nama')" 
                                    class="px-3 py-2 text-sm border rounded-md {{ $sortBy === 'nama' ? 'bg-primary-50 border-primary-500 text-primary-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                Nama
                                @if($sortBy === 'nama')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </button>
                            <button wire:click="sortBy('harga')" 
                                    class="px-3 py-2 text-sm border rounded-md {{ $sortBy === 'harga' ? 'bg-primary-50 border-primary-500 text-primary-700' : 'border-gray-300 text-gray-700 hover:bg-gray-50' }}">
                                Harga
                                @if($sortBy === 'harga')
                                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="mb-8">
                @if($produk->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($produk as $item)
                            <div class="card overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 group">
                                <div class="aspect-w-1 aspect-h-1 bg-gradient-to-br from-primary-100 to-accent-100 relative overflow-hidden">
                                    <img src="{{ $item->foto ?? 'https://via.placeholder.com/300x300?text=Velg+Motor' }}" 
                                         alt="{{ $item->nama }}" 
                                         class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                                    
                                    @if($item->stok && $item->stok <= 5)
                                        <div class="absolute top-3 left-3 bg-gradient-to-r from-red-500 to-red-600 text-white px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>
                                            Stok Terbatas
                                        </div>
                                    @endif
                                </div>
                                <div class="p-6">
                                    <div class="flex items-center text-xs text-primary-600 mb-2 font-medium">
                                        <span class="bg-accent-100 px-2 py-1 rounded-full">{{ $item->merk->nama_merk ?? 'Merk' }}</span>
                                    </div>
                                    <h3 class="font-bold text-lg text-gray-900 mb-3 line-clamp-2 group-hover:text-primary-700 transition-colors">
                                        <a href="{{ route('produk.detail', $item->id) }}" wire:navigate>
                                            {{ $item->nama }}
                                        </a>
                                    </h3>
                                    <div class="flex items-center justify-between mb-4">
                                        <span class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                        @if($item->stok)
                                            <span class="text-xs text-green-700 bg-green-100 px-3 py-1 rounded-full font-semibold">
                                                <i class="fas fa-check mr-1"></i>Stok: {{ $item->stok }}
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('produk.detail', $item->id) }}" wire:navigate
                                           class="flex-1 btn-secondary text-center text-sm">
                                            <i class="fas fa-eye mr-2"></i>
                                            Detail
                                        </a>
                                        
                                        @auth
                                            <livewire:customer.add-to-cart :produk-id="$item->id" :key="'add-to-cart-'.$item->id" />
                                        @else
                                            <a href="{{ route('login') }}" 
                                               class="btn-primary text-sm">
                                                <i class="fas fa-shopping-cart mr-2"></i>
                                                Beli
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($produk->hasPages())
                        <div class="mt-8">
                            {{ $produk->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <div class="w-24 h-24 mx-auto mb-6 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                            <i class="fas fa-search text-3xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-3">Tidak Ada Produk</h3>
                        <p class="text-gray-500 mb-6">
                            @if($search)
                                Tidak ditemukan produk yang sesuai dengan pencarian "{{ $search }}" dalam kategori {{ $kategori->nama }}.
                            @else
                                Belum ada produk dalam kategori {{ $kategori->nama }}.
                            @endif
                        </p>
                        <div class="flex justify-center space-x-4">
                            @if($search)
                                <button wire:click="$set('search', '')" 
                                        class="btn-secondary">
                                    <i class="fas fa-times mr-2"></i>
                                    Hapus Pencarian
                                </button>
                            @endif
                            <a href="{{ route('home') }}" wire:navigate
                               class="btn-primary">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
