<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Detail Pesanan</h1>
                        <p class="text-gray-600 mt-2">ID Pesanan: {{ $pesanan->id }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($pesanan->status === 'menunggu_pembayaran') bg-yellow-100 text-yellow-800
                            @elseif($pesanan->status === 'menunggu_konfirmasi') bg-blue-100 text-blue-800
                            @elseif($pesanan->status === 'menunggu_ongkir') bg-orange-100 text-orange-800
                            @elseif($pesanan->status === 'menunggu_pembayaran_ongkir') bg-yellow-100 text-yellow-800
                            @elseif($pesanan->status === 'dikirim') bg-green-100 text-green-800
                            @elseif($pesanan->status === 'selesai') bg-emerald-100 text-emerald-800
                            @else bg-red-100 text-red-800
                            @endif">
                            <i class="fas fa-circle w-2 h-2 mr-2"></i>
                            {{ ucwords(str_replace('_', ' ', $pesanan->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Detail Pesanan -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Alamat Pengiriman -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>
                            Alamat Pengiriman
                        </h2>
                        <div class="text-gray-700">
                            <p class="font-medium">{{ $pesanan->alamat_lengkap }}</p>
                            <p>{{ $pesanan->kota }}, {{ $pesanan->kode_pos }}</p>
                            <p class="mt-2"><strong>Telepon:</strong> {{ $pesanan->nomor_telepon }}</p>
                            @if($pesanan->catatan_pengiriman)
                                <p class="mt-2"><strong>Catatan:</strong> {{ $pesanan->catatan_pengiriman }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Item Pesanan -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-box text-primary-600 mr-2"></i>
                            Item Pesanan
                        </h2>
                        <div class="space-y-4">
                            @foreach($pesanan->detailPesanan as $detail)
                                <div class="flex items-center space-x-4 pb-4 border-b border-gray-100 last:border-b-0">
                                    @php
                                        $thumb = null;
                                        $first = $detail->produk->photos()->first();
                                        if ($first) {
                                            $thumb = Storage::url($first->path);
                                        } elseif ($detail->produk->foto) {
                                            $thumb = Storage::url('produk/' . $detail->produk->foto);
                                        } else {
                                            $thumb = 'https://via.placeholder.com/80x80?text=Velg';
                                        }
                                    @endphp
                                    <img src="{{ $thumb }}" 
                                         alt="{{ $detail->produk->nama }}" 
                                         class="w-16 h-16 object-cover rounded-md">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $detail->produk->nama }}</h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $detail->jumlah }}x @ Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">
                                            Rp {{ number_format($detail->total_harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Informasi Pembayaran -->
                    @if($pesanan->status === 'menunggu_pembayaran')
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-credit-card text-primary-600 mr-2"></i>
                                Pembayaran Produk
                            </h2>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                                <h4 class="font-medium text-blue-900 mb-2">Informasi Transfer Bank</h4>
                                <div class="text-blue-800 text-sm space-y-1">
                                    <p><strong>Bank:</strong> BCA</p>
                                    <p><strong>No. Rekening:</strong> 1234567890</p>
                                    <p><strong>Atas Nama:</strong> PT Moka Madali</p>
                                    <p><strong>Jumlah Transfer:</strong> <span class="font-bold">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span></p>
                                </div>
                            </div>

                            <form wire:submit="uploadBuktiTransferProduk" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="bukti_transfer_produk" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Bukti Transfer Pembayaran Produk *
                                    </label>
                                    <input type="file" 
                                           wire:model="bukti_transfer_produk" 
                                           id="bukti_transfer_produk" 
                                           accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @error('bukti_transfer_produk') 
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                    @enderror
                                    
                                    @if($bukti_transfer_produk)
                                        <div class="mt-2">
                                            <img src="{{ $bukti_transfer_produk->temporaryUrl() }}" alt="Preview" class="h-32 w-auto object-cover rounded border">
                                            <p class="text-xs text-gray-500 mt-1">Preview bukti transfer</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="btn-primary">
                                    <span wire:loading.remove>
                                        <i class="fas fa-upload mr-2"></i>
                                        Upload Bukti Transfer
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Mengupload...
                                    </span>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Upload Bukti Transfer Ongkir -->
                    @if($pesanan->status === 'menunggu_pembayaran_ongkir')
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-truck text-primary-600 mr-2"></i>
                                Pembayaran Ongkos Kirim
                            </h2>
                            
                            <div class="bg-orange-50 border border-orange-200 rounded-lg p-4 mb-6">
                                <h4 class="font-medium text-orange-900 mb-2">Informasi Transfer Ongkir</h4>
                                <div class="text-orange-800 text-sm space-y-1">
                                    <p><strong>Bank:</strong> BCA</p>
                                    <p><strong>No. Rekening:</strong> 1234567890</p>
                                    <p><strong>Atas Nama:</strong> PT Moka Madali</p>
                                    <p><strong>Jumlah Transfer:</strong> <span class="font-bold">Rp {{ number_format($pesanan->biaya_ongkir, 0, ',', '.') }}</span></p>
                                </div>
                            </div>

                            <form wire:submit="uploadBuktiTransferOngkir" enctype="multipart/form-data">
                                <div class="mb-4">
                                    <label for="bukti_transfer_ongkir" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload Bukti Transfer Ongkos Kirim *
                                    </label>
                                    <input type="file" 
                                           wire:model="bukti_transfer_ongkir" 
                                           id="bukti_transfer_ongkir" 
                                           accept="image/*" 
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                                    @error('bukti_transfer_ongkir') 
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                    @enderror
                                    
                                    @if($bukti_transfer_ongkir)
                                        <div class="mt-2">
                                            <img src="{{ $bukti_transfer_ongkir->temporaryUrl() }}" alt="Preview" class="h-32 w-auto object-cover rounded border">
                                            <p class="text-xs text-gray-500 mt-1">Preview bukti transfer</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <button type="submit" 
                                        wire:loading.attr="disabled"
                                        class="btn-primary">
                                    <span wire:loading.remove>
                                        <i class="fas fa-upload mr-2"></i>
                                        Upload Bukti Transfer
                                    </span>
                                    <span wire:loading>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                        Mengupload...
                                    </span>
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Info Pengiriman -->
                    @if($pesanan->resi)
                        <div class="bg-white rounded-lg shadow-sm p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">
                                <i class="fas fa-shipping-fast text-primary-600 mr-2"></i>
                                Informasi Pengiriman
                            </h2>
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-green-800"><strong>Nomor Resi:</strong> {{ $pesanan->resi }}</p>
                                <p class="text-green-700 text-sm mt-1">Pesanan Anda sedang dalam proses pengiriman</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar Ringkasan -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">
                            <i class="fas fa-receipt text-primary-600 mr-2"></i>
                            Ringkasan Pembayaran
                        </h2>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal Produk:</span>
                                <span class="font-medium">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                            </div>
                            
                            @if($pesanan->biaya_ongkir)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ongkos Kirim:</span>
                                    <span class="font-medium">Rp {{ number_format($pesanan->biaya_ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-t pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-semibold text-gray-900">Total:</span>
                                        <span class="text-lg font-bold text-primary-600">
                                            Rp {{ number_format($pesanan->total_harga + $pesanan->biaya_ongkir, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Ongkos Kirim:</span>
                                    <span class="text-sm text-gray-500">Menunggu perhitungan</span>
                                </div>
                            @endif
                        </div>

                        <!-- Status Timeline -->
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="font-medium text-gray-900 mb-4">Status Pesanan</h3>
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $pesanan->status === 'menunggu_pembayaran' ? 'bg-yellow-500' : 'bg-green-500' }} mr-3"></div>
                                    <span class="text-sm {{ $pesanan->status === 'menunggu_pembayaran' ? 'text-yellow-700 font-medium' : 'text-gray-600' }}">
                                        Menunggu Pembayaran
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ in_array($pesanan->status, ['menunggu_konfirmasi', 'menunggu_ongkir', 'menunggu_pembayaran_ongkir', 'dikirim', 'selesai']) ? 'bg-green-500' : 'bg-gray-300' }} mr-3"></div>
                                    <span class="text-sm {{ in_array($pesanan->status, ['menunggu_konfirmasi', 'menunggu_ongkir']) ? 'text-blue-700 font-medium' : (in_array($pesanan->status, ['menunggu_pembayaran_ongkir', 'dikirim', 'selesai']) ? 'text-gray-600' : 'text-gray-400') }}">
                                        Konfirmasi Admin
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $pesanan->status === 'menunggu_pembayaran_ongkir' ? 'bg-yellow-500' : (in_array($pesanan->status, ['dikirim', 'selesai']) ? 'bg-green-500' : 'bg-gray-300') }} mr-3"></div>
                                    <span class="text-sm {{ $pesanan->status === 'menunggu_pembayaran_ongkir' ? 'text-yellow-700 font-medium' : (in_array($pesanan->status, ['dikirim', 'selesai']) ? 'text-gray-600' : 'text-gray-400') }}">
                                        Pembayaran Ongkir
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $pesanan->status === 'dikirim' ? 'bg-green-500' : ($pesanan->status === 'selesai' ? 'bg-green-500' : 'bg-gray-300') }} mr-3"></div>
                                    <span class="text-sm {{ $pesanan->status === 'dikirim' ? 'text-green-700 font-medium' : ($pesanan->status === 'selesai' ? 'text-gray-600' : 'text-gray-400') }}">
                                        Dikirim
                                    </span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-3 h-3 rounded-full {{ $pesanan->status === 'selesai' ? 'bg-green-500' : 'bg-gray-300' }} mr-3"></div>
                                    <span class="text-sm {{ $pesanan->status === 'selesai' ? 'text-green-700 font-medium' : 'text-gray-400' }}">
                                        Selesai
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Selesaikan Pesanan -->
                        @if($pesanan->status === 'dikirim')
                            <div class="mt-6 pt-6 border-t">
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-medium text-green-900">Pesanan Sudah Diterima?</h4>
                                            <p class="text-sm text-green-700 mt-1">
                                                Klik tombol di samping jika pesanan sudah diterima dengan baik
                                            </p>
                                        </div>
                                        <button 
                                            wire:click="selesaikanPesanan"
                                            wire:confirm="Apakah Anda yakin pesanan sudah diterima dengan baik? Tindakan ini tidak dapat dibatalkan."
                                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200"
                                        >
                                            <i class="fas fa-check mr-2"></i>
                                            Selesaikan Pesanan
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
