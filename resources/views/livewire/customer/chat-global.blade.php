<div>
    <!-- Floating Chat Button -->
    <div class="fixed bottom-6 right-6 z-50">
        <button wire:click="toggleChat" 
                class="relative bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 shadow-lg transition-all duration-200 {{ $isOpen ? 'bg-red-500 hover:bg-red-600' : '' }}">
            @if(!$isOpen)
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                
                @if($unreadCount > 0)
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center font-bold">
                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                    </span>
                @endif
            @else
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            @endif
        </button>
    </div>

    <!-- Chat Window -->
    @if($isOpen)
        <div class="fixed bottom-24 right-6 w-80 bg-white rounded-lg shadow-xl border z-50 flex flex-col" style="height: 400px;">
            <!-- Chat Header -->
            <div class="bg-blue-500 text-white p-4 rounded-t-lg">
                <h3 class="font-semibold">Chat dengan Admin</h3>
                <p class="text-sm opacity-90">Kami siap membantu Anda</p>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chatMessages">
                @if($pesanChat->isEmpty())
                    <div class="text-center text-gray-500 py-8">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                        <p class="text-sm">Belum ada pesan</p>
                        <p class="text-xs">Mulai percakapan dengan admin</p>
                    </div>
                @else
                    @foreach($pesanChat as $pesan)
                        <div class="flex {{ $pesan->dari_admin ? 'justify-start' : 'justify-end' }}">
                            <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $pesan->dari_admin ? 'bg-gray-200 text-gray-800' : 'bg-blue-500 text-white' }}">
                                @if($pesan->dari_admin)
                                    <div class="flex items-center mb-1">
                                        <div class="w-6 h-6 bg-blue-500 text-white rounded-full flex items-center justify-center text-xs font-bold mr-2">
                                            A
                                        </div>
                                        <span class="text-xs font-semibold">Admin</span>
                                    </div>
                                @endif
                                
                                <p class="text-sm">{{ $pesan->isi_pesan }}</p>
                                <p class="text-xs mt-1 {{ $pesan->dari_admin ? 'text-gray-500' : 'text-blue-100' }}">
                                    {{ $pesan->created_at->format('H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Chat Input -->
            <div class="p-4 border-t bg-gray-50 rounded-b-lg">
                <form wire:submit.prevent="kirimPesan" class="flex space-x-2">
                    <input type="text" 
                           wire:model="pesanBaru"
                           placeholder="Ketik pesan Anda..."
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           maxlength="1000">
                    <button type="submit" 
                            wire:loading.attr="disabled"
                            wire:target="kirimPesan"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200 disabled:opacity-50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    @endif

    <!-- Auto scroll to bottom when new message -->
    <script>
        document.addEventListener('livewire:updated', () => {
            const chatMessages = document.getElementById('chatMessages');
            if (chatMessages) {
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }
        });

        // Listen for new messages event
        Livewire.on('pesanTerkirim', () => {
            setTimeout(() => {
                const chatMessages = document.getElementById('chatMessages');
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }, 100);
        });
    </script>
</div>
