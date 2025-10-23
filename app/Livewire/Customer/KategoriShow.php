<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KategoriProduk;
use App\Models\Produk;

class KategoriShow extends Component
{
    use WithPagination;

    public $kategori;
    public $search = '';
    public $sortBy = 'nama';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'nama'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount($kategoriId)
    {
        $this->kategori = KategoriProduk::findOrFail($kategoriId);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Produk::with(['kategori', 'merk'])
                    ->where('kategori_id', $this->kategori->id);

        // Search functionality
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama', 'like', '%' . $this->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('merk', function ($q) {
                      $q->where('nama_merk', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $produk = $query->paginate(12);

        return view('livewire.customer.kategori-show', [
            'produk' => $produk
        ]);
    }
}
