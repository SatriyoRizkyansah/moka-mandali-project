<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Produk;
use App\Models\KeranjangItem;
use Illuminate\Support\Facades\Auth;

class AddToCart extends Component
{
    public $produkId;
    public $jumlah = 1;
    public $isAdding = false;

    public function mount($produkId)
    {
        $this->produkId = $produkId;
    }

    public function addToCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->isAdding = true;

        $produk = Produk::find($this->produkId);
        
        if (!$produk) {
            session()->flash('error', 'Produk tidak ditemukan');
            $this->isAdding = false;
            return;
        }

        // Cek apakah item sudah ada di keranjang
        $existingItem = KeranjangItem::where('user_id', Auth::id())
                                   ->where('produk_id', $this->produkId)
                                   ->first();

        if ($existingItem) {
            // Update jumlah jika sudah ada
            $existingItem->update([
                'jumlah' => $existingItem->jumlah + $this->jumlah
            ]);
        } else {
            // Buat item baru
            KeranjangItem::create([
                'user_id' => Auth::id(),
                'produk_id' => $this->produkId,
                'jumlah' => $this->jumlah,
                'harga_saat_ditambah' => $produk->harga
            ]);
        }

        // Dispatch event untuk update cart count di header
        $this->dispatch('cart-updated');
        
        session()->flash('cart-message', 'Produk berhasil ditambahkan ke keranjang!');
        
        $this->isAdding = false;
        $this->jumlah = 1; // Reset quantity
    }

    public function render()
    {
        return view('livewire.customer.add-to-cart');
    }
}
