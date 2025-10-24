<div>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout Pesanan</h1>
                <p class="text-gray-600 mt-2">Lengkapi data pengiriman untuk melanjutkan pesanan</p>
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
                <!-- Form Alamat Pengiriman -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">
                            <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>
                            Alamat Pengiriman
                        </h2>

                        <form wire:submit="prosesPesanan" class="space-y-6">
                            <!-- Alamat Lengkap -->
                            <div>
                                <label for="alamat_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Lengkap *
                                </label>
                                <textarea wire:model="alamat_lengkap" 
                                         id="alamat_lengkap" 
                                         rows="3" 
                                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                         placeholder="Masukkan alamat lengkap termasuk nama jalan, nomor rumah, RT/RW"></textarea>
                                @error('alamat_lengkap') 
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Kota -->
                                <div>
                                    <label for="kota" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kota *
                                    </label>
                                    <input type="text" 
                                           wire:model="kota" 
                                           id="kota" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                           placeholder="Nama kota">
                                    @error('kota') 
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                    @enderror
                                </div>

                                <!-- Kode Pos -->
                                <div>
                                    <label for="kode_pos" class="block text-sm font-medium text-gray-700 mb-2">
                                        Kode Pos *
                                    </label>
                                    <input type="text" 
                                           wire:model="kode_pos" 
                                           id="kode_pos" 
                                           maxlength="5"
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                           placeholder="12345">
                                    @error('kode_pos') 
                                        <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>

                            <!-- Nomor Telepon -->
                            <div>
                                <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nomor Telepon *
                                </label>
                                <input type="text" 
                                       wire:model="nomor_telepon" 
                                       id="nomor_telepon" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                       placeholder="08123456789">
                                @error('nomor_telepon') 
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Catatan Pengiriman -->
                            <div>
                                <label for="catatan_pengiriman" class="block text-sm font-medium text-gray-700 mb-2">
                                    Catatan Pengiriman (Opsional)
                                </label>
                                <textarea wire:model="catatan_pengiriman" 
                                         id="catatan_pengiriman" 
                                         rows="2" 
                                         class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                         placeholder="Catatan khusus untuk kurir (misalnya: patokan lokasi, waktu pengiriman)"></textarea>
                                @error('catatan_pengiriman') 
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Metode Pembayaran -->
                            <div class="border-t pt-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                    <i class="fas fa-credit-card text-primary-600 mr-2"></i>
                                    Metode Pembayaran
                                </h3>
                                
                                @if(count($rekeningBanks) > 0)
                                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                        <div class="flex items-start">
                                            <i class="fas fa-university text-blue-600 mt-1 mr-3"></i>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-blue-900 mb-2">Transfer Bank</h4>
                                                <p class="text-blue-700 text-sm mb-3">
                                                    Setelah checkout, lakukan pembayaran ke salah satu rekening di bawah ini kemudian upload bukti transfer.
                                                </p>
                                                
                                                <div class="space-y-3">
                                                    @foreach($rekeningBanks as $rekening)
                                                        <div class="bg-white border border-blue-200 rounded-md p-3">
                                                            <div class="flex items-center justify-between mb-2">
                                                                <div class="flex items-center">
                                                                    <i class="fas fa-university text-blue-600 mr-2"></i>
                                                                    <span class="font-semibold text-blue-900">{{ $rekening->nama_bank }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                                                                <div>
                                                                    <span class="text-gray-600">Rekening:</span>
                                                                    <span class="font-mono font-medium text-gray-900">{{ $rekening->formatted_nomor_rekening }}</span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-gray-600">Atas Nama:</span>
                                                                    <span class="font-medium text-gray-900">{{ $rekening->nama_pemilik }}</span>
                                                                </div>
                                                            </div>
                                                            @if($rekening->keterangan)
                                                                <div class="mt-2 text-xs text-gray-600 italic">
                                                                    {{ $rekening->keterangan }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
                                                    <div class="flex items-start">
                                                        <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-2 text-sm"></i>
                                                        <div class="text-xs text-yellow-800">
                                                            <p class="font-medium mb-1">Catatan Penting:</p>
                                                            <ul class="list-disc list-inside space-y-1">
                                                                <li>Transfer sesuai dengan jumlah total yang tertera</li>
                                                                <li>Simpan bukti transfer untuk di-upload nanti</li>
                                                                <li>Admin akan menghitung ongkir setelah pembayaran dikonfirmasi</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                        <div class="flex items-start">
                                            <i class="fas fa-exclamation-triangle text-red-600 mt-1 mr-3"></i>
                                            <div>
                                                <h4 class="font-medium text-red-900">Rekening Belum Tersedia</h4>
                                                <p class="text-red-700 text-sm mt-1">
                                                    Maaf, saat ini belum ada rekening yang tersedia untuk pembayaran. 
                                                    Silakan hubungi admin untuk informasi lebih lanjut.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="border-t pt-6">
                                @if(count($rekeningBanks) > 0)
                                    <button type="submit" 
                                            wire:loading.attr="disabled"
                                            class="w-full btn-primary text-lg py-3">
                                        <span wire:loading.remove>
                                            <i class="fas fa-shopping-cart mr-2"></i>
                                            Buat Pesanan
                                        </span>
                                        <span wire:loading>
                                            <i class="fas fa-spinner fa-spin mr-2"></i>
                                            Memproses...
                                        </span>
                                    </button>
                                @else
                                    <button type="button" 
                                            disabled
                                            class="w-full bg-gray-300 text-gray-500 cursor-not-allowed text-lg py-3 rounded-md">
                                        <i class="fas fa-ban mr-2"></i>
                                        Tidak Dapat Membuat Pesanan
                                    </button>
                                    <p class="text-red-600 text-sm mt-2 text-center">
                                        Rekening pembayaran belum tersedia
                                    </p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Ringkasan Pesanan -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-6">
                            <i class="fas fa-receipt text-primary-600 mr-2"></i>
                            Ringkasan Pesanan
                        </h2>

                        <!-- Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($keranjangItems as $item)
                                <div class="flex items-center space-x-3 pb-4 border-b border-gray-100 last:border-b-0">
                                    @php
                                        $thumb = null;
                                        $first = $item->produk->photos()->first();
                                        if ($first) {
                                            $thumb = Storage::url($first->path);
                                        } elseif ($item->produk->foto) {
                                            $thumb = Storage::url('produk/' . $item->produk->foto);
                                        } else {
                                            $thumb = 'https://via.placeholder.com/80x80?text=Velg';
                                        }
                                    @endphp
                                    <img src="{{ $thumb }}" 
                                         alt="{{ $item->produk->nama }}" 
                                         class="w-16 h-16 object-cover rounded-md">
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-900 line-clamp-2">
                                            {{ $item->produk->nama }}
                                        </h4>
                                        <p class="text-sm text-gray-500">
                                            {{ $item->jumlah }}x @ Rp {{ number_format($item->harga_saat_ditambah, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm font-medium text-primary-600">
                                            Rp {{ number_format($item->total_harga, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Total -->
                        <div class="border-t pt-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Subtotal Produk:</span>
                                <span class="font-medium">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-gray-600">Ongkos Kirim:</span>
                                <span class="text-sm text-gray-500">Akan dihitung setelah checkout</span>
                            </div>
                            <div class="border-t pt-2 mt-2">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-900">Total Sementara:</span>
                                    <span class="text-lg font-bold text-primary-600">Rp {{ number_format($totalHarga, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">*Belum termasuk ongkos kirim</p>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-info-circle text-yellow-600 mt-0.5 mr-2"></i>
                                <div class="text-sm text-yellow-800">
                                    <p class="font-medium">Proses Pembayaran:</p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Transfer pembayaran produk</li>
                                        <li>Admin konfirmasi & hitung ongkir</li>
                                        <li>Transfer ongkos kirim</li>
                                        <li>Pesanan diproses & dikirim</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
