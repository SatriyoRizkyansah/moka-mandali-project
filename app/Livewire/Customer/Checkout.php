<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\KeranjangItem;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Checkout extends Component
{
    #[Validate('required|string|min:10')]
    public $alamat_lengkap = '';
    
    #[Validate('required|string')]
    public $kota = '';
    
    #[Validate('required|string|digits:5')]
    public $kode_pos = '';
    
    #[Validate('required|string|min:10')]
    public $nomor_telepon = '';
    
    #[Validate('nullable|string')]
    public $catatan_pengiriman = '';

    public $keranjangItems = [];
    public $totalHarga = 0;

    public function mount()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->loadKeranjang();
        
        // Pre-fill dengan data user jika ada
        $user = Auth::user();
        if ($user->alamat) {
            $this->alamat_lengkap = $user->alamat;
        }
        if ($user->telepon) {
            $this->nomor_telepon = $user->telepon;
        }
    }

    public function loadKeranjang()
    {
        $this->keranjangItems = KeranjangItem::with(['produk.kategori', 'produk.merk'])
            ->where('user_id', Auth::id())
            ->get();
        
        $this->totalHarga = $this->keranjangItems->sum('total_harga');

        if ($this->keranjangItems->count() === 0) {
            session()->flash('error', 'Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
            return redirect()->route('keranjang');
        }
    }

    public function prosesPesanan()
    {
        $this->validate();

        if ($this->keranjangItems->count() === 0) {
            session()->flash('error', 'Keranjang kosong.');
            return;
        }

        DB::transaction(function () {
            // Buat pesanan baru
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'alamat_lengkap' => $this->alamat_lengkap,
                'kota' => $this->kota,
                'kode_pos' => $this->kode_pos,
                'nomor_telepon' => $this->nomor_telepon,
                'catatan_pengiriman' => $this->catatan_pengiriman,
                'total_harga' => $this->totalHarga,
                'status' => 'menunggu_pembayaran'
            ]);

            // Buat detail pesanan dari keranjang
            foreach ($this->keranjangItems as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'jumlah' => $item->jumlah,
                    'harga_satuan' => $item->harga_saat_ditambah,
                    'total_harga' => $item->total_harga
                ]);
            }

            // Hapus keranjang setelah checkout
            KeranjangItem::where('user_id', Auth::id())->delete();

            // Dispatch event untuk update cart count
            $this->dispatch('cart-updated');

            session()->flash('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
            
            $this->redirect(route('pesanan.detail', $pesanan->id));
        });
    }

    public function render()
    {
        return view('livewire.customer.checkout');
    }
}
