<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\KeranjangItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Keranjang extends Component
{
    public Collection $keranjangItems;
    public $total = 0;

    public function mount()
    {
        $this->keranjangItems = collect();
        $this->loadKeranjang();
    }

    public function loadKeranjang()
    {
    $this->keranjangItems = Auth::user()->keranjangItems()->with('produk.kategori', 'produk.merk')->get();
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->total = $this->keranjangItems->sum(function($item) {
            return $item->jumlah * $item->harga_saat_ditambah;
        });
    }

    public function updateJumlah($keranjangItemId, $jumlah)
    {
        if ($jumlah <= 0) {
            $this->hapusItem($keranjangItemId);
            return;
        }

        $keranjangItem = KeranjangItem::find($keranjangItemId);
        if ($keranjangItem && $keranjangItem->user_id === Auth::id()) {
            $keranjangItem->update(['jumlah' => $jumlah]);
            $this->loadKeranjang();
            $this->dispatch('cart-updated');
        }
    }

    public function hapusItem($keranjangItemId)
    {
        $keranjangItem = KeranjangItem::find($keranjangItemId);
        if ($keranjangItem && $keranjangItem->user_id === Auth::id()) {
            $keranjangItem->delete();
            $this->loadKeranjang();
            $this->dispatch('cart-updated');
            session()->flash('message', 'Item berhasil dihapus dari keranjang');
        }
    }

    public function checkout()
    {
        if ($this->keranjangItems->isEmpty()) {
            session()->flash('error', 'Keranjang kosong');
            return;
        }

        // Redirect ke halaman checkout
        return redirect()->route('checkout');
    }

    public function render()
    {
        return view('livewire.customer.keranjang');
    }
}
