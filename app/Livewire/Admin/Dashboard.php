<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\KategoriProduk;
use App\Models\MerkProduk;
use App\Models\Produk;
use App\Models\Pesanan;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class Dashboard extends Component
{
    public function render()
    {
        $stats = [
            'total_users' => User::where('role', 'customer')->count(),
            'total_kategori' => KategoriProduk::count(),
            'total_merk' => MerkProduk::count(),
            'total_produk' => Produk::count(),
            'total_pesanan' => Pesanan::count(),
            'pesanan_pending' => Pesanan::where('status', 'menunggu_pembayaran')->count(),
            'total_stok' => Produk::sum('stok'),
        ];

        return view('livewire.admin.dashboard', compact('stats'));
    }
}
