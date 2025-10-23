<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Produk;
use App\Models\Ulasan;

class ProdukDetail extends Component
{
    public $produk;
    public $relatedProduk;
    public $activeImageIndex = 0;
    public $quantity = 1;

    public function mount($produkId)
    {
        $this->produk = Produk::with(['kategori', 'merk', 'ulasan.user'])
                              ->findOrFail($produkId);
        
        // Get related products from same category
        $this->relatedProduk = Produk::with(['kategori', 'merk'])
                                    ->where('kategori_id', $this->produk->kategori_id)
                                    ->where('id', '!=', $this->produk->id)
                                    ->limit(4)
                                    ->get();
    }

    public function changeImage($index)
    {
        $this->activeImageIndex = $index;
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->produk->stok) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function render()
    {
        return view('livewire.customer.produk-detail');
    }
}
