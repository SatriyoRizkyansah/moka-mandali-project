<div>
    <!-- Add to Cart Button for Product Detail -->
    @if(isset($quantity))
        <button wire:click="addToCart" 
                wire:loading.attr="disabled"
                wire:target="addToCart"
                class="flex-1 btn-primary text-lg py-3 disabled:opacity-50 disabled:cursor-not-allowed">
            <span wire:loading.remove wire:target="addToCart">
                <i class="fas fa-shopping-cart mr-2"></i>
                Tambah ke Keranjang
            </span>
            <span wire:loading wire:target="addToCart">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                Menambahkan...
            </span>
        </button>
    @else
        <!-- Quantity Input for Product Cards -->
        <div class="flex items-center space-x-2">
            <div class="flex items-center border border-gray-300 rounded-md">
                <button type="button" 
                        wire:click="$set('jumlah', {{ max(1, $jumlah - 1) }})"
                        class="px-2 py-1 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </button>
                
                <input type="number" 
                       wire:model="jumlah" 
                       min="1" 
                       class="w-12 text-center border-0 focus:ring-0 text-sm py-1">
                
                <button type="button" 
                        wire:click="$set('jumlah', {{ $jumlah + 1 }})"
                        class="px-2 py-1 text-gray-500 hover:text-gray-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </button>
            </div>

            <button wire:click="addToCart" 
                    wire:loading.attr="disabled"
                    wire:target="addToCart"
                    class="flex-1 btn-primary text-sm py-2 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="addToCart">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Tambah ke Keranjang
                </span>
                <span wire:loading wire:target="addToCart">
                    <i class="fas fa-spinner fa-spin mr-1"></i>
                    Menambahkan...
                </span>
            </button>
        </div>
    @endif
</div>
