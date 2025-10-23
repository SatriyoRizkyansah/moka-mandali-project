<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
class PesananIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $filterStatus = '';
    public $showModal = false;
    public $selectedPesanan = null;
    public $biayaOngkir = '';
    public $resi = '';
    public $selectedPembayaran = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function lihatDetail($pesananId)
    {
        $this->selectedPesanan = Pesanan::with(['user', 'detailPesanan.produk', 'pembayaran'])
            ->findOrFail($pesananId);
        $this->biayaOngkir = $this->selectedPesanan->biaya_ongkir ?? '';
        $this->resi = $this->selectedPesanan->resi ?? '';
        $this->showModal = true;
    }

    public function konfirmasiPembayaran($pembayaranId, $status)
    {
        $pembayaran = Pembayaran::findOrFail($pembayaranId);
        $pembayaran->update(['status' => $status]);

        if ($status === 'diterima') {
            if ($pembayaran->jenis === 'produk') {
                // Jika pembayaran produk diterima, ubah status ke menunggu ongkir
                $pembayaran->pesanan->update(['status' => 'menunggu_ongkir']);
                session()->flash('success', 'Pembayaran produk dikonfirmasi. Silakan masukkan biaya ongkir.');
            } elseif ($pembayaran->jenis === 'ongkir') {
                // Jika pembayaran ongkir diterima, ubah status ke dikirim
                $pembayaran->pesanan->update(['status' => 'dikirim']);
                session()->flash('success', 'Pembayaran ongkir dikonfirmasi. Pesanan siap dikirim.');
            }
        } else {
            session()->flash('success', 'Pembayaran ditolak.');
        }

        $this->lihatDetail($pembayaran->pesanan_id);
    }

    public function simpanBiayaOngkir()
    {
        $this->validate([
            'biayaOngkir' => 'required|numeric|min:0'
        ]);

        if ($this->selectedPesanan->status !== 'menunggu_ongkir') {
            session()->flash('error', 'Biaya ongkir hanya bisa diatur saat status menunggu ongkir.');
            return;
        }

        $this->selectedPesanan->update([
            'biaya_ongkir' => $this->biayaOngkir,
            'status' => 'menunggu_pembayaran_ongkir'
        ]);

        session()->flash('success', 'Biaya ongkir berhasil ditetapkan. Customer akan diminta melakukan pembayaran ongkir.');
        $this->lihatDetail($this->selectedPesanan->id);
    }

    public function simpanResi()
    {
        $this->validate([
            'resi' => 'required|string'
        ]);

        if ($this->selectedPesanan->status !== 'dikirim') {
            session()->flash('error', 'Nomor resi hanya bisa dimasukkan saat status dikirim.');
            return;
        }

        $this->selectedPesanan->update(['resi' => $this->resi]);

        session()->flash('success', 'Nomor resi berhasil disimpan.');
        $this->lihatDetail($this->selectedPesanan->id);
    }

    public function ubahStatus($pesananId, $status)
    {
        $pesanan = Pesanan::findOrFail($pesananId);
        $pesanan->update(['status' => $status]);

        session()->flash('success', 'Status pesanan berhasil diubah.');
        $this->lihatDetail($pesananId);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedPesanan = null;
        $this->biayaOngkir = '';
        $this->resi = '';
        $this->selectedPembayaran = null;
    }

    public function render()
    {
        $query = Pesanan::with(['user', 'detailPesanan.produk'])
            ->orderBy('created_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->filterStatus) {
            $query->where('status', $this->filterStatus);
        }

        $pesanans = $query->paginate(10);

        return view('livewire.admin.pesanan-index', [
            'pesanans' => $pesanans
        ]);
    }
}
