<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Produk
        </h2>
    </div>

    <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <!-- Header Actions -->
        <div class="bg-white shadow rounded-lg mb-6">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center">
                    <div class="flex-1 max-w-lg">
                        <input type="text" wire:model.live="search" placeholder="Cari produk..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>
                    <button wire:click="create" class="ml-4 inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Tambah Produk
                    </button>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Foto
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nama Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kategori / Merk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Stok
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <!-- Modal -->
                @if($showModal)
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
                            <!-- Background overlay with gradient + blur -->
                            <div class="fixed inset-0 bg-gradient-to-br from-black/20 via-transparent to-black/30 backdrop-blur-sm transition-all duration-300" wire:click="closeModal"></div>

                            <!-- This element is to trick the browser into centering the modal contents. -->
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                            <!-- Modal panel -->
                            <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl border border-gray-200/50 transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full"
                                 wire:click.stop
                                 x-transition:enter="transition ease-out duration-300 transform"
                                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="transition ease-in duration-200 transform"
                                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                 style="backdrop-filter: blur(1px);">
                                <form wire:submit="save" enctype="multipart/form-data">
                                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                            {{ $editingId ? 'Edit Produk' : 'Tambah Produk' }}
                                        </h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Nama Produk -->
                                            <div class="col-span-2">
                                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                                    Nama Produk *
                                                </label>
                                                <input type="text" wire:model="nama" id="nama" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                @error('nama') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Kategori -->
                                            <div>
                                                <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 161-165 omitted */
                                                </label>
                                                <select wire:model="kategori_id" id="kategori_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                    /* Lines 161-165 omitted */
                                                </select>
                                                @error('kategori_id') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Merk -->
                                            <div>
                                                <label for="merk_id" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 174-175 omitted */
                                                </label>
                                                <select wire:model="merk_id" id="merk_id" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                    /* Lines 177-181 omitted */
                                                </select>
                                                @error('merk_id') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Harga -->
                                            <div>
                                                <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 190-191 omitted */
                                                </label>
                                                <input type="number" wire:model="harga" id="harga" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                @error('harga') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Stok -->
                                            <div>
                                                <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 201-202 omitted */
                                                </label>
                                                <input type="number" wire:model="stok" id="stok" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                                @error('stok') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Deskripsi -->
                                            <div class="col-span-2">
                                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 212-213 omitted */
                                                </label>
                                                <textarea wire:model="deskripsi" id="deskripsi" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                                @error('deskripsi') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror
                                            </div>

                                            <!-- Foto -->
                                            <div class="col-span-2">
                                                <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                                    /* Lines 223-224 omitted */
                                                </label>
                                                <input type="file" wire:model="fotos" id="foto" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                                @error('fotos') 
                                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                                @enderror

                                                {{-- Existing photos from produk_photos --}}
                                                @if(!empty($existingPhotos))
                                                @endif

                                                {{-- Preview new uploads --}}
                                                @if(!empty($fotos))
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                                            {{ $editingId ? 'Perbarui' : 'Simpan' }}
                                        </button>
                                        <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
                                        @enderror
                                    </div>

                                    <!-- Harga -->
                                    <div>
                                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                                            Harga (Rp) *
                                        </label>
                                        <input type="number" wire:model="harga" id="harga" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        @error('harga') 
                                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Stok -->
                                    <div>
                                        <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">
                                            Stok *
                                        </label>
                                        <input type="number" wire:model="stok" id="stok" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                        @error('stok') 
                                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Deskripsi -->
                                    <div class="col-span-2">
                                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-2">
                                            Deskripsi
                                        </label>
                                        <textarea wire:model="deskripsi" id="deskripsi" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"></textarea>
                                        @error('deskripsi') 
                                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                                        @enderror
                                    </div>

                                    <!-- Foto -->
                                    <div class="col-span-2">
                                        <label for="foto" class="block text-sm font-medium text-gray-700 mb-2">
                                            Foto Produk
                                        </label>
                                        <input type="file" wire:model="fotos" id="foto" accept="image/*" multiple class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                                        @error('fotos') 
                                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                                        @enderror

                                        {{-- Existing photos from produk_photos --}}
                                        @if(!empty($existingPhotos))
                                            <div class="mt-2 flex space-x-2 overflow-auto">
                                                @foreach($existingPhotos as $p)
                                                    <div class="relative">
                                                        <img src="{{ Storage::url($p['path']) }}" alt="Foto" class="h-20 w-20 object-cover rounded">
                                                        <button type="button" wire:click="removePhoto('{{ $p['id'] }}')" class="absolute top-0 right-0 bg-red-600 text-white rounded-full p-1 -translate-x-1/4 -translate-y-1/4">
                                                            &times;
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Preview new uploads --}}
                                        @if(!empty($fotos))
                                            <div class="mt-2 flex space-x-2 overflow-auto">
                                                @foreach($fotos as $file)
                                                    <div>
                                                        @if($file)
                                                            <img src="{{ $file->temporaryUrl() }}" alt="Preview" class="h-20 w-20 object-cover rounded">
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-purple-600 text-base font-medium text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ $editingId ? 'Perbarui' : 'Simpan' }}
                                </button>
                                <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
