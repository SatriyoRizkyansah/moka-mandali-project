<div>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Manajemen Rekening Bank</h1>
                <p class="text-gray-600 mt-2">Kelola informasi rekening bank untuk pembayaran</p>
            </div>
            <button wire:click="showCreateModal" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Tambah Rekening
            </button>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search & Filter -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cari Rekening</label>
                    <input type="text" wire:model.live="search" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                           placeholder="Nama bank, nomor rekening, atau nama pemilik...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                    <select wire:model.live="statusFilter" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="all">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non-aktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Tabel Rekening Bank -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Urutan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bank & Rekening
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pemilik
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Keterangan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($rekeningBanks as $rekening)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div class="flex items-center space-x-1">
                                        <span class="font-medium">{{ $rekening->urutan }}</span>
                                        <div class="flex flex-col space-y-1 ml-2">
                                            <button wire:click="updateUrutan('{{ $rekening->id }}', 'up')" 
                                                    class="text-gray-400 hover:text-gray-600 text-xs">
                                                <i class="fas fa-chevron-up"></i>
                                            </button>
                                            <button wire:click="updateUrutan('{{ $rekening->id }}', 'down')" 
                                                    class="text-gray-400 hover:text-gray-600 text-xs">
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $rekening->nama_bank }}</div>
                                        <div class="text-sm text-gray-500 font-mono">{{ $rekening->formatted_nomor_rekening }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rekening->nama_pemilik }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                    <div class="truncate" title="{{ $rekening->keterangan }}">
                                        {{ $rekening->keterangan ?: '-' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <button wire:click="toggleStatus('{{ $rekening->id }}')" 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium cursor-pointer transition-colors {{ $rekening->aktif ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <i class="fas fa-circle mr-1 text-xs {{ $rekening->aktif ? 'text-green-400' : 'text-red-400' }}"></i>
                                        {{ $rekening->aktif ? 'Aktif' : 'Non-aktif' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <button wire:click="showEditModal('{{ $rekening->id }}')" 
                                                class="text-primary-600 hover:text-primary-900">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button wire:click="delete('{{ $rekening->id }}')" 
                                                onclick="return confirm('Yakin ingin menghapus rekening ini?')"
                                                class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-university text-4xl mb-4 text-gray-300"></i>
                                    <p class="text-lg">Belum ada rekening bank</p>
                                    <p class="text-sm">Tambahkan rekening bank pertama untuk mulai menerima pembayaran</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($rekeningBanks->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $rekeningBanks->links() }}
                </div>
            @endif
        </div>

        <!-- Modal Form -->
        @if($showModal)
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                <div class="bg-white rounded-lg shadow-xl max-w-lg w-full mx-4 max-h-screen overflow-y-auto">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">
                            {{ $editMode ? 'Edit Rekening Bank' : 'Tambah Rekening Bank' }}
                        </h3>
                    </div>

                    <form wire:submit="save" class="px-6 py-4 space-y-4">
                        <!-- Nama Bank -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Bank *
                            </label>
                            <input type="text" wire:model="nama_bank" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                   placeholder="Contoh: Bank BCA">
                            @error('nama_bank') 
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Nomor Rekening -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Rekening *
                            </label>
                            <input type="text" wire:model="nomor_rekening" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                   placeholder="Contoh: 1234567890">
                            @error('nomor_rekening') 
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Nama Pemilik -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Pemilik *
                            </label>
                            <input type="text" wire:model="nama_pemilik" 
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                   placeholder="Nama sesuai rekening bank">
                            @error('nama_pemilik') 
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan (Opsional)
                            </label>
                            <textarea wire:model="keterangan" rows="3"
                                      class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                      placeholder="Catatan tambahan untuk rekening ini"></textarea>
                            @error('keterangan') 
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Urutan -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Urutan
                                </label>
                                <input type="number" wire:model="urutan" min="0"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                @error('urutan') 
                                    <span class="text-red-500 text-sm mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Status Aktif -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Status
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" wire:model="aktif" 
                                           class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                    <span class="ml-2 text-sm text-gray-700">Aktif</span>
                                </label>
                            </div>
                        </div>
                    </form>

                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" wire:click="closeModal" 
                                class="btn-secondary">
                            Batal
                        </button>
                        <button wire:click="save" 
                                wire:loading.attr="disabled"
                                class="btn-primary">
                            <span wire:loading.remove>
                                {{ $editMode ? 'Perbarui' : 'Simpan' }}
                            </span>
                            <span wire:loading>
                                <i class="fas fa-spinner fa-spin mr-2"></i>
                                Menyimpan...
                            </span>
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
