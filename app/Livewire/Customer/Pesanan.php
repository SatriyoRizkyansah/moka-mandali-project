<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan as PesananModel;

class Pesanan extends Component
{
    use WithPagination;

    public $selectedStatus = 'all';
    public $search = '';

    protected $queryString = [
        'selectedStatus' => ['except' => 'all'],
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedStatus()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Auth::user()->pesanan()->with(['detailPesanan.produk', 'pembayaran'])
                    ->latest();

        // Filter by status
        if ($this->selectedStatus !== 'all') {
            $query->where('status', $this->selectedStatus);
        }

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('id', 'like', '%' . $this->search . '%')
                  ->orWhereHas('detailPesanan.produk', function ($q) {
                      $q->where('nama', 'like', '%' . $this->search . '%');
                  });
            });
        }

        $pesanans = $query->paginate(10);

        return view('livewire.customer.pesanan', [
            'pesanans' => $pesanans
        ]);
    }

    public function getStatusBadgeColor($status)
    {
        return match($status) {
            'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
            'menunggu_konfirmasi' => 'bg-blue-100 text-blue-800',
            'menunggu_ongkir' => 'bg-purple-100 text-purple-800',
            'menunggu_pembayaran_ongkir' => 'bg-orange-100 text-orange-800',
            'dikirim' => 'bg-green-100 text-green-800',
            'selesai' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getStatusText($status)
    {
        return match($status) {
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
            'menunggu_ongkir' => 'Menunggu Ongkir',
            'menunggu_pembayaran_ongkir' => 'Menunggu Pembayaran Ongkir',
            'dikirim' => 'Dikirim',
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan',
            default => ucfirst(str_replace('_', ' ', $status)),
        };
    }
}
