<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PesananDetail extends Component
{
    use WithFileUploads;

    public $pesanan;
    
    #[Validate('nullable|image|max:2048')]
    public $bukti_transfer_produk;
    
    #[Validate('nullable|image|max:2048')]
    public $bukti_transfer_ongkir;

    public function mount($pesananId)
    {
        $this->pesanan = Pesanan::with(['detailPesanan.produk', 'pembayaran'])
            ->where('id', $pesananId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
    }

    public function uploadBuktiTransferProduk()
    {
        $this->validate([
            'bukti_transfer_produk' => 'required|image|max:2048'
        ]);

        if ($this->pesanan->status !== 'menunggu_pembayaran') {
            session()->flash('error', 'Upload bukti transfer hanya bisa dilakukan saat status menunggu pembayaran.');
            return;
        }

        // Upload file
        $filename = 'bukti_transfer_produk_' . time() . '.' . $this->bukti_transfer_produk->getClientOriginalExtension();
        $path = $this->bukti_transfer_produk->storeAs('bukti_transfer', $filename, 'public');

        // Buat record pembayaran
        Pembayaran::create([
            'pesanan_id' => $this->pesanan->id,
            'bukti_transfer' => $path,
            'jumlah' => $this->pesanan->total_harga,
            'jenis' => 'produk',
            'status' => 'menunggu_konfirmasi'
        ]);

        // Update status pesanan
        $this->pesanan->update(['status' => 'menunggu_konfirmasi']);

        session()->flash('success', 'Bukti transfer pembayaran produk berhasil diupload. Menunggu konfirmasi admin.');
        
        // Refresh data
        $this->mount($this->pesanan->id);
        $this->bukti_transfer_produk = null;
    }

    public function uploadBuktiTransferOngkir()
    {
        $this->validate([
            'bukti_transfer_ongkir' => 'required|image|max:2048'
        ]);

        if ($this->pesanan->status !== 'menunggu_pembayaran_ongkir') {
            session()->flash('error', 'Upload bukti transfer ongkir hanya bisa dilakukan saat status menunggu pembayaran ongkir.');
            return;
        }

        // Upload file
        $filename = 'bukti_transfer_ongkir_' . time() . '.' . $this->bukti_transfer_ongkir->getClientOriginalExtension();
        $path = $this->bukti_transfer_ongkir->storeAs('bukti_transfer', $filename, 'public');

        // Buat record pembayaran
        Pembayaran::create([
            'pesanan_id' => $this->pesanan->id,
            'bukti_transfer' => $path,
            'jumlah' => $this->pesanan->biaya_ongkir,
            'jenis' => 'ongkir',
            'status' => 'menunggu_konfirmasi'
        ]);

        // Update status pesanan
        $this->pesanan->update(['status' => 'menunggu_konfirmasi']);

        session()->flash('success', 'Bukti transfer ongkos kirim berhasil diupload. Pesanan akan segera diproses.');
        
        // Refresh data
        $this->mount($this->pesanan->id);
        $this->bukti_transfer_ongkir = null;
    }

    public function render()
    {
        return view('livewire.customer.pesanan-detail');
    }
}
