<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Kelola Kategori Produk
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
                        <input type="text" wire:model.live="search" placeholder="Cari kategori..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                    <button wire:click="create" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Tambah Kategori
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
                            Nama Kategori
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah Produk
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Dibuat
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kategoris as $kategori)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $kategori->nama }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $kategori->produk_count }} produk
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $kategori->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit('{{ $kategori->id }}')" class="text-blue-600 hover:text-blue-900 mr-2">
                                    Edit
                                </button>
                                <button wire:click="delete('{{ $kategori->id }}')" wire:confirm="Apakah Anda yakin ingin menghapus kategori ini?" class="text-red-600 hover:text-red-900">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                Tidak ada data kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-4 py-3 border-t border-gray-200">
                {{ $kategoris->links() }}
            </div>
        </div>

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
                    <div class="relative inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl border border-gray-200/50 transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                         wire:click.stop
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="transition ease-in duration-200 transform"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         style="backdrop-filter: blur(1px);">
                        <form wire:submit="save">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                                    {{ $editingId ? 'Edit Kategori' : 'Tambah Kategori' }}
                                </h3>

                                <div class="mb-4">
                                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Kategori
                                    </label>
                                    <input type="text" wire:model="nama" id="nama" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('nama') 
                                        <span class="text-red-500 text-sm">{{ $message }}</span> 
                                    @enderror
                                </div>
                            </div>

                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    {{ $editingId ? 'Perbarui' : 'Simpan' }}
                                </button>
                                <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
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
