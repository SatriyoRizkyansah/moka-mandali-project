<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Keranjang Belanja</h1>
                <p class="mt-2 text-gray-600">Kelola item yang akan Anda beli</p>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('message') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none'">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button" viewBox="0 0 20 20">
                            <path d="M14.348 14.849c-0.469 0.469-1.229 0.469-1.697 0l-2.651-3.030-2.651 3.030c-0.469 0.469-1.229 0.469-1.697 0-0.469-0.469-0.469-1.229 0-1.697l2.758-3.15-2.759-3.152c-0.469-0.469-0.469-1.228 0-1.697s1.228-0.469 1.697 0l2.652 3.031 2.651-3.031c0.469-0.469 1.228-0.469 1.697 0s0.469 1.229 0 1.697l-2.758 3.152 2.758 3.15c0.469 0.469 0.469 1.229 0 1.698z"/>
                        </svg>
                    </span>
                </div>
            @endif

            @if (session()->has('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-8">
                    @if($keranjangItems->count() > 0)
                        <div class="bg-white rounded-lg shadow-sm">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">
                                    Item dalam Keranjang ({{ $keranjangItems->count() }})
                                </h2>
                            </div>
                            
                            <div class="divide-y divide-gray-200">
                                @foreach($keranjangItems as $item)
                                    <div class="p-6 flex items-center space-x-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            <img class="h-20 w-20 rounded-lg object-cover" 
                                                 src="{{ $item->produk->gambar ?? 'https://via.placeholder.com/80' }}" 
                                                 alt="{{ $item->produk->nama }}">
                                        </div>

                                        <!-- Product Info -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-lg font-medium text-gray-900 truncate">
                                                {{ $item->produk->nama }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $item->produk->kategori->nama ?? '' }} | 
                                                {{ $item->produk->merk->nama ?? '' }}
                                            </p>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Ukuran: {{ $item->produk->ukuran ?? 'Standard' }}
                                            </p>
                                            <div class="mt-2">
                                                <span class="text-lg font-semibold text-gray-900">
                                                    Rp {{ number_format($item->harga_saat_ditambah, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="updateJumlah('{{ $item->id }}', {{ $item->jumlah - 1 }})"
                                                    class="p-1 rounded-md hover:bg-gray-100">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                            </button>
                                            
                                            <span class="text-gray-900 font-medium px-3 py-1 bg-gray-50 rounded-md min-w-[3rem] text-center">
                                                {{ $item->jumlah }}
                                            </span>
                                            
                                            <button wire:click="updateJumlah('{{ $item->id }}', {{ $item->jumlah + 1 }})"
                                                    class="p-1 rounded-md hover:bg-gray-100">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Item Total -->
                                        <div class="text-right">
                                            <p class="text-lg font-semibold text-gray-900">
                                                Rp {{ number_format($item->jumlah * $item->harga_saat_ditambah, 0, ',', '.') }}
                                            </p>
                                        </div>

                                        <!-- Remove Button -->
                                        <div class="flex-shrink-0">
                                            <button wire:click="hapusItem('{{ $item->id }}')" 
                                                    wire:confirm="Apakah Anda yakin ingin menghapus item ini?"
                                                    class="p-2 text-red-400 hover:text-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Empty Cart -->
                        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M34 8H14C11.791 8 10 9.791 10 12v24c0 2.209 1.791 4 4 4h20c2.209 0 4-1.791 4-4V12c0-2.209-1.791-4-4-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 8v-2a4 4 0 118 0v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M24 20v8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20 24h8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Keranjang Kosong</h3>
                            <p class="mt-2 text-gray-500">Belum ada produk yang ditambahkan ke keranjang</p>
                            <div class="mt-6">
                                <a href="{{ route('home') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                                   wire:navigate>
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18"></path>
                                    </svg>
                                    Mulai Belanja
                                </a>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Order Summary -->
                @if($keranjangItems->count() > 0)
                    <div class="lg:col-span-4 mt-8 lg:mt-0">
                        <div class="bg-white rounded-lg shadow-sm p-6 sticky top-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Ringkasan Pesanan</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal ({{ $keranjangItems->sum('jumlah') }} item)</span>
                                    <span class="text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Ongkos Kirim</span>
                                    <span class="text-gray-900">Dihitung di checkout</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-base font-medium text-gray-900">Total</span>
                                        <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 space-y-3">
                                <button wire:click="checkout"
                                        class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md font-medium hover:bg-indigo-700 transition duration-200">
                                    Lanjutkan ke Checkout
                                </button>
                                
                                <a href="{{ route('home') }}" 
                                   class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-md font-medium hover:bg-gray-200 transition duration-200 text-center block"
                                   wire:navigate>
                                    Lanjutkan Belanja
                                </a>
                            </div>

                            <!-- Trust Signals -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="space-y-2 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Garansi 100% Original
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Pengiriman Cepat & Aman
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Customer Service 24/7
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
