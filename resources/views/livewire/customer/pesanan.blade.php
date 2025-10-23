<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Riwayat Pesanan</h1>
                <p class="mt-2 text-gray-600">Pantau status dan kelola pesanan Anda</p>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <div class="flex-1">
                        <label for="search" class="sr-only">Cari pesanan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" id="search" wire:model.live.debounce.300ms="search" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="Cari berdasarkan ID pesanan atau nama produk...">
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="sm:w-48">
                        <label for="status" class="sr-only">Filter status</label>
                        <select wire:model.live="selectedStatus" id="status"
                                class="block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 rounded-md">
                            <option value="all">Semua Status</option>
                            <option value="pending">Menunggu Pembayaran</option>
                            <option value="diproses">Sedang Diproses</option>
                            <option value="dikirim">Dalam Pengiriman</option>
                            <option value="selesai">Selesai</option>
                            <option value="dibatalkan">Dibatalkan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Orders List -->
            <div class="space-y-6">
                @forelse($pesanans as $pesanan)
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">
                                            Pesanan #{{ substr($pesanan->id, 0, 8) }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Dipesan pada {{ $pesanan->created_at->format('d M Y, H:i') }}
                                        </p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusBadgeColor($pesanan->status) }}">
                                        {{ $this->getStatusText($pesanan->status) }}
                                    </span>
                                    <span class="text-lg font-semibold text-gray-900">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            <!-- Order Items -->
                            <div class="space-y-3">
                                @foreach($pesanan->detailPesanan as $detail)
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ $detail->produk->gambar ?? 'https://via.placeholder.com/64' }}" 
                                                 alt="{{ $detail->produk->nama }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-medium text-gray-900 truncate">
                                                {{ $detail->produk->nama }}
                                            </h4>
                                            <p class="text-sm text-gray-500">
                                                {{ $detail->jumlah }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            Rp {{ number_format($detail->jumlah * $detail->harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Payment Info -->
                            @php
                                // pembayaran relationship may be a single model or a Collection (hasMany).
                                $payment = $pesanan->pembayaran instanceof \Illuminate\Support\Collection
                                            ? $pesanan->pembayaran->first()
                                            : $pesanan->pembayaran;
                            @endphp
                            @if($payment)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-500">Metode Pembayaran:</span>
                                        <span class="font-medium text-gray-900">{{ ucfirst($payment->jenis ?? '') }}</span>
                                    </div>
                                    @if(!empty($payment->status))
                                        <div class="flex items-center justify-between text-sm mt-1">
                                            <span class="text-gray-500">Status Pembayaran:</span>
                                            <span class="font-medium text-gray-900">{{ ucfirst($payment->status) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        @if($pesanan->status === 'pending')
                                            Silakan lakukan pembayaran sebelum batas waktu
                                        @elseif($pesanan->status === 'diproses')
                                            Pesanan sedang diproses oleh admin
                                        @elseif($pesanan->status === 'dikirim')
                                            Pesanan dalam perjalanan ke alamat Anda
                                        @elseif($pesanan->status === 'selesai')
                                            Pesanan telah selesai
                                        @elseif($pesanan->status === 'dibatalkan')
                                            Pesanan telah dibatalkan
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        @if($pesanan->status === 'selesai')
                                            <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700 transition duration-200">
                                                Beli Lagi
                                            </button>
                                        @endif
                                        
                                        @if($pesanan->status === 'pending' && !$pesanan->pembayaran)
                                            <button class="bg-green-600 text-white px-4 py-2 rounded-md text-sm hover:bg-green-700 transition duration-200">
                                                Bayar Sekarang
                                            </button>
                                        @endif
                                        
                                        <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-200 transition duration-200">
                                            Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M34 8H14C11.791 8 10 9.791 10 12v24c0 2.209 1.791 4 4 4h20c2.209 0 4-1.791 4-4V12c0-2.209-1.791-4-4-4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 8v-2a4 4 0 118 0v2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Belum Ada Pesanan</h3>
                        <p class="mt-2 text-gray-500">
                            @if($search || $selectedStatus !== 'all')
                                Tidak ditemukan pesanan dengan kriteria pencarian tersebut.
                            @else
                                Anda belum memiliki pesanan. Mulai berbelanja sekarang!
                            @endif
                        </p>
                        <div class="mt-6">
                            @if($search || $selectedStatus !== 'all')
                                <button wire:click="$set('search', '')" wire:click="$set('selectedStatus', 'all')"
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    Reset Filter
                                </button>
                            @else
                                <a href="{{ route('home') }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                                   wire:navigate>
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Mulai Belanja
                                </a>
                            @endif
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($pesanans->hasPages())
                <div class="mt-6">
                    {{ $pesanans->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
