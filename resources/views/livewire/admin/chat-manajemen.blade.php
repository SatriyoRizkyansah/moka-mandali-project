<div class="bg-white rounded-lg shadow">
    <div class="flex h-96">
        <!-- Sidebar Daftar Customer -->
        <div class="w-1/3 border-r border-gray-200">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-3">Chat Customer</h2>
                
                <!-- Search -->
                <div class="relative">
                    <input type="text" 
                           wire:model.live="search"
                           placeholder="Cari customer..."
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="absolute left-3 top-2.5 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Daftar Customer -->
            <div class="overflow-y-auto" style="height: 320px;">
                @forelse($daftarCustomer as $customer)
                    <div wire:click="selectUser('{{ $customer->id }}')"
                         class="p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition-colors {{ $selectedUserId === $customer->id ? 'bg-blue-50 border-blue-200' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold text-sm mr-3">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $customer->name }}</p>
                                        <p class="text-xs text-gray-500 truncate">{{ $customer->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <p class="text-xs text-gray-600 truncate">{{ \Illuminate\Support\Str::limit($customer->latest_message, 30) }}</p>
                                    @if($customer->latest_time)
                                        <p class="text-xs text-gray-400 mt-1">{{ $customer->latest_time->diffForHumans() }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            @if($customer->unread_count > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center font-bold">
                                    {{ $customer->unread_count > 9 ? '9+' : $customer->unread_count }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <p class="text-sm">Belum ada customer yang chat</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Chat Area -->
        <div class="flex-1 flex flex-col">
            @if($selectedUser)
                <!-- Chat Header -->
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold text-sm mr-3">
                            {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $selectedUser->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $selectedUser->email }}</p>
                        </div>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chatMessagesAdmin">
                    @if($pesanChat->isEmpty())
                        <div class="text-center text-gray-500 py-8">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-sm">Belum ada pesan</p>
                        </div>
                    @else
                        @foreach($pesanChat as $pesan)
                            <div class="flex {{ $pesan->dari_admin ? 'justify-end' : 'justify-start' }}">
                                <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $pesan->dari_admin ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                                    @if(!$pesan->dari_admin)
                                        <div class="flex items-center mb-1">
                                            <div class="w-6 h-6 bg-gray-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">
                                                {{ strtoupper(substr($selectedUser->name, 0, 1)) }}
                                            </div>
                                            <span class="text-xs font-semibold">{{ $selectedUser->name }}</span>
                                        </div>
                                    @endif
                                    
                                    <p class="text-sm">{{ $pesan->isi_pesan }}</p>
                                    <p class="text-xs mt-1 {{ $pesan->dari_admin ? 'text-blue-100' : 'text-gray-500' }}">
                                        {{ $pesan->created_at->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Chat Input -->
                <div class="p-4 border-t bg-gray-50">
                    <form wire:submit.prevent="kirimPesan" class="flex space-x-2">
                        <input type="text" 
                               wire:model="pesanBaru"
                               placeholder="Ketik balasan Anda..."
                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               maxlength="1000">
                        <button type="submit" 
                                wire:loading.attr="disabled"
                                wire:target="kirimPesan"
                                class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 disabled:opacity-50">
                            Kirim
                        </button>
                    </form>
                </div>
            @else
                <!-- No User Selected -->
                <div class="flex-1 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <h3 class="text-lg font-medium mb-2">Pilih Customer</h3>
                        <p class="text-sm">Pilih customer dari daftar sebelah kiri untuk memulai chat</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Auto scroll script -->
    <script>
        document.addEventListener('livewire:updated', () => {
            const chatMessages = document.getElementById('chatMessagesAdmin');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        Livewire.on('pesanTerkirim', () => {
            setTimeout(() => {
                const chatMessages = document.getElementById('chatMessagesAdmin');
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }, 100);
        });
    </script>
</div>
