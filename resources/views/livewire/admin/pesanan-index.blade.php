<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Pesanan
        </h2>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" wire:model.live="search" placeholder="Cari pesanan atau customer..." 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                </div>
                <div>
                    <select wire:model.live="filterStatus" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        <option value="">Semua Status</option>
                        <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                        <option value="menunggu_konfirmasi">Menunggu Konfirmasi</option>
                        <option value="menunggu_ongkir">Menunggu Ongkir</option>
                        <option value="menunggu_pembayaran_ongkir">Menunggu Pembayaran Ongkir</option>
                        <option value="dikirim">Dikirim</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ID Pesanan
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Customer
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tanggal
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($pesanans as $pesanan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ substr($pesanan->id, 0, 8) }}...
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $pesanan->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $pesanan->kota }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</div>
                            @if($pesanan->biaya_ongkir)
                                <div class="text-xs text-gray-500">+ongkir: Rp {{ number_format($pesanan->biaya_ongkir, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($pesanan->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                                @elseif($pesanan->status === 'menunggu_konfirmasi') bg-blue-100 text-blue-800
                                @elseif($pesanan->status === 'menunggu_ongkir') bg-orange-100 text-orange-800
                                @elseif($pesanan->status === 'menunggu_pembayaran_ongkir') bg-yellow-100 text-yellow-800
                                @elseif($pesanan->status === 'dikirim') bg-green-100 text-green-800
                                @elseif($pesanan->status === 'selesai') bg-emerald-100 text-emerald-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucwords(str_replace('_', ' ', $pesanan->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $pesanan->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="lihatDetail('{{ $pesanan->id }}')" 
                                    class="text-blue-600 hover:text-blue-900">
                                Detail
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                            Tidak ada data pesanan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $pesanans->links() }}
        </div>
    </div>

    <!-- Modal Detail Pesanan -->
    @if($showModal && $selectedPesanan)
        <div class="fixed inset-0 z-50 overflow-y-auto" 
             x-data="{ show: true }"
             x-show="show"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay with blur and gradient -->
                <div class="fixed inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/30 backdrop-blur-sm transition-all duration-300" 
                     wire:click="closeModal"></div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl border border-gray-200/50 transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full" 
                     wire:click.stop
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     style="backdrop-filter: blur(1px);"
                     >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                            <h3 class="text-xl leading-6 font-bold text-gray-900 flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3 animate-pulse"></div>
                                Detail Pesanan - {{ substr($selectedPesanan->id, 0, 8) }}...
                            </h3>
                            <button wire:click="closeModal" 
                                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 hover:bg-gray-100 rounded-lg">
                                <span class="sr-only">Tutup</span>
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Info Customer & Alamat -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Informasi Customer</h4>
                                    <p><strong>Nama:</strong> {{ $selectedPesanan->user->name }}</p>
                                    <p><strong>Email:</strong> {{ $selectedPesanan->user->email }}</p>
                                    <p><strong>Telepon:</strong> {{ $selectedPesanan->nomor_telepon }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Alamat Pengiriman</h4>
                                    <p>{{ $selectedPesanan->alamat_lengkap }}</p>
                                    <p>{{ $selectedPesanan->kota }}, {{ $selectedPesanan->kode_pos }}</p>
                                    @if($selectedPesanan->catatan_pengiriman)
                                        <p class="mt-2"><strong>Catatan:</strong> {{ $selectedPesanan->catatan_pengiriman }}</p>
                                    @endif
                                </div>

                                <!-- Item Pesanan -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Item Pesanan</h4>
                                    <div class="space-y-2">
                                        @foreach($selectedPesanan->detailPesanan as $detail)
                                            <div class="flex justify-between text-sm">
                                                <span>{{ $detail->produk->nama }} ({{ $detail->jumlah }}x)</span>
                                                <span>Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</span>
                                            </div>
                                        @endforeach
                                        <div class="border-t pt-2 font-semibold">
                                            <div class="flex justify-between">
                                                <span>Subtotal:</span>
                                                <span>Rp {{ number_format($selectedPesanan->total_harga, 0, ',', '.') }}</span>
                                            </div>
                                            @if($selectedPesanan->biaya_ongkir)
                                                <div class="flex justify-between">
                                                    <span>Ongkir:</span>
                                                    <span>Rp {{ number_format($selectedPesanan->biaya_ongkir, 0, ',', '.') }}</span>
                                                </div>
                                                <div class="flex justify-between border-t pt-1">
                                                    <span>Total:</span>
                                                    <span>Rp {{ number_format($selectedPesanan->total_harga + $selectedPesanan->biaya_ongkir, 0, ',', '.') }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pembayaran & Status -->
                            <div class="space-y-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Status Pesanan</h4>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($selectedPesanan->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                                        @elseif($selectedPesanan->status === 'menunggu_konfirmasi') bg-blue-100 text-blue-800
                                        @elseif($selectedPesanan->status === 'menunggu_ongkir') bg-orange-100 text-orange-800
                                        @elseif($selectedPesanan->status === 'menunggu_pembayaran_ongkir') bg-yellow-100 text-yellow-800
                                        @elseif($selectedPesanan->status === 'dikirim') bg-green-100 text-green-800
                                        @elseif($selectedPesanan->status === 'selesai') bg-emerald-100 text-emerald-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucwords(str_replace('_', ' ', $selectedPesanan->status)) }}
                                    </span>
                                </div>

                                <!-- Pembayaran -->
                                @if($selectedPesanan->pembayaran->count() > 0)
                                    <div class="bg-gray-50 p-4 rounded-lg">
                                        <h4 class="font-semibold text-gray-900 mb-2">Riwayat Pembayaran</h4>
                                        @foreach($selectedPesanan->pembayaran as $pembayaran)
                                            <div class="border-b pb-2 mb-2 last:border-b-0">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <p class="text-sm font-medium">
                                                            Pembayaran {{ ucwords($pembayaran->jenis) }}
                                                        </p>
                                                        <p class="text-sm text-gray-600">
                                                            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500">
                                                            {{ $pembayaran->created_at->format('d/m/Y H:i') }}
                                                        </p>
                                                    </div>
                                                    <div class="text-right">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                                            @if($pembayaran->status === 'menunggu_konfirmasi') bg-yellow-100 text-yellow-800
                                                            @elseif($pembayaran->status === 'diterima') bg-green-100 text-green-800
                                                            @else bg-red-100 text-red-800
                                                            @endif">
                                                            {{ ucwords(str_replace('_', ' ', $pembayaran->status)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                @if($pembayaran->bukti_transfer)
                                                    <div class="mt-2">
                                                        <a href="{{ Storage::url($pembayaran->bukti_transfer) }}" 
                                                           target="_blank" 
                                                           class="text-blue-600 hover:text-blue-800 text-xs">
                                                            Lihat Bukti Transfer
                                                        </a>
                                                    </div>
                                                @endif

                                                @if($pembayaran->status === 'menunggu_konfirmasi')
                                                    <div class="mt-3 flex space-x-2">
                                                        <button wire:click="konfirmasiPembayaran('{{ $pembayaran->id }}', 'diterima')"
                                                                wire:loading.attr="disabled"
                                                                wire:target="konfirmasiPembayaran"
                                                                class="text-xs bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 transform hover:scale-105 hover:shadow-md flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                                            <span wire:loading.remove wire:target="konfirmasiPembayaran">
                                                                <i class="fas fa-check mr-1"></i>
                                                                Terima
                                                            </span>
                                                            <span wire:loading wire:target="konfirmasiPembayaran">
                                                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                                                Memproses...
                                                            </span>
                                                        </button>
                                                        <button wire:click="konfirmasiPembayaran('{{ $pembayaran->id }}', 'ditolak')"
                                                                wire:loading.attr="disabled"
                                                                wire:target="konfirmasiPembayaran"
                                                                class="text-xs bg-red-600 text-white px-3 py-2 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 transition-all duration-200 transform hover:scale-105 hover:shadow-md flex items-center disabled:opacity-50 disabled:cursor-not-allowed">
                                                            <span wire:loading.remove wire:target="konfirmasiPembayaran">
                                                                <i class="fas fa-times mr-1"></i>
                                                                Tolak
                                                            </span>
                                                            <span wire:loading wire:target="konfirmasiPembayaran">
                                                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                                                Memproses...
                                                            </span>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Input Biaya Ongkir -->
                                @if($selectedPesanan->status === 'menunggu_ongkir')
                                    <div class="bg-blue-50 p-4 rounded-lg">
                                        <h4 class="font-semibold text-blue-900 mb-2">Tetapkan Biaya Ongkir</h4>
                                        <div class="space-y-2">
                                            <input type="number" 
                                                   wire:model="biayaOngkir" 
                                                   placeholder="Masukkan biaya ongkir"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                            @error('biayaOngkir') 
                                                <span class="text-red-500 text-xs">{{ $message }}</span> 
                                            @enderror
                                            <button wire:click="simpanBiayaOngkir" 
                                                    class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                Simpan Biaya Ongkir
                                            </button>
                                        </div>
                                    </div>
                                @endif

                                <!-- Input Nomor Resi -->
                                @if($selectedPesanan->status === 'dikirim')
                                    <div class="bg-green-50 p-4 rounded-lg">
                                        <h4 class="font-semibold text-green-900 mb-2">Nomor Resi Pengiriman</h4>
                                        <div class="space-y-2">
                                            <input type="text" 
                                                   wire:model="resi" 
                                                   placeholder="Masukkan nomor resi"
                                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                                            @error('resi') 
                                                <span class="text-red-500 text-xs">{{ $message }}</span> 
                                            @enderror
                                            <button wire:click="simpanResi" 
                                                    class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                                                Simpan Nomor Resi
                                            </button>
                                        </div>
                                        @if($selectedPesanan->resi)
                                            <p class="mt-2 text-sm text-green-700">
                                                <strong>Resi:</strong> {{ $selectedPesanan->resi }}
                                            </p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Quick Actions -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Aksi Cepat</h4>
                                    <div class="space-y-2">
                                        @if($selectedPesanan->status !== 'selesai' && $selectedPesanan->status !== 'dibatalkan')
                                            <button wire:click="ubahStatus('{{ $selectedPesanan->id }}', 'selesai')"
                                                    class="block w-full bg-emerald-600 text-white px-3 py-2 rounded text-sm hover:bg-emerald-700">
                                                Tandai Selesai
                                            </button>
                                            <button wire:click="ubahStatus('{{ $selectedPesanan->id }}', 'dibatalkan')"
                                                    class="block w-full bg-red-600 text-white px-3 py-2 rounded text-sm hover:bg-red-700">
                                                Batalkan Pesanan
                                            </button>
                                        @endif
                                    </div>
                                </div>

                                <!-- Chat dengan Customer -->
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="font-semibold text-gray-900 mb-2">Chat dengan Customer</h4>
                                    <livewire:admin.chat-pesanan :pesanan-id="$selectedPesanan->id" />
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="bg-gray-50/50 px-6 py-4 border-t border-gray-100 flex justify-end space-x-3">
                            <button wire:click="closeModal" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 hover:shadow-sm">
                                <i class="fas fa-times mr-2"></i>
                                Tutup
                            </button>
                            @if($selectedPesanan->status !== 'selesai' && $selectedPesanan->status !== 'dibatalkan')
                                <button wire:click="refreshData" 
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 hover:shadow-md transform hover:scale-105">
                                    <i class="fas fa-sync-alt mr-2"></i>
                                    Refresh Data
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
