<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KategoriProduk;
use Livewire\Attributes\Validate;

class KategoriIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    
    #[Validate('required|min:3')]
    public $nama = '';

    public function resetForm()
    {
        $this->nama = '';
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        $this->editingId = $id;
        $this->nama = $kategori->nama;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            // Update
            $kategori = KategoriProduk::findOrFail($this->editingId);
            $kategori->update([
                'nama' => $this->nama
            ]);
            session()->flash('message', 'Kategori berhasil diperbarui.');
        } else {
            // Create
            KategoriProduk::create([
                'nama' => $this->nama
            ]);
            session()->flash('message', 'Kategori berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $kategori = KategoriProduk::findOrFail($id);
        
        // Check jika kategori memiliki produk
        if ($kategori->produk()->count() > 0) {
            session()->flash('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
            return;
        }

        $kategori->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kategoris = KategoriProduk::where('nama', 'like', '%' . $this->search . '%')
            ->withCount('produk')
            ->paginate(10);

        return view('livewire.admin.kategori-index', [
            'kategoris' => $kategoris
        ]);
    }
}
