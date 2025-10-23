<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\MerkProduk;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.admin')]
class MerkIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    
    #[Validate('required|min:3')]
    public $nama_merk = '';

    public function resetForm()
    {
        $this->nama_merk = '';
        $this->editingId = null;
        $this->resetErrorBag();
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function create()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit($id)
    {
        $merk = MerkProduk::findOrFail($id);
        $this->editingId = $id;
        $this->nama_merk = $merk->nama_merk;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->editingId) {
            // Update
            $merk = MerkProduk::findOrFail($this->editingId);
            $merk->update([
                'nama_merk' => $this->nama_merk
            ]);
            session()->flash('message', 'Merk berhasil diperbarui.');
        } else {
            // Create
            MerkProduk::create([
                'nama_merk' => $this->nama_merk
            ]);
            session()->flash('message', 'Merk berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $merk = MerkProduk::findOrFail($id);
        
        // Check jika merk memiliki produk
        if ($merk->produk()->count() > 0) {
            session()->flash('error', 'Merk tidak dapat dihapus karena masih memiliki produk.');
            return;
        }

        $merk->delete();
        session()->flash('message', 'Merk berhasil dihapus.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $merks = MerkProduk::where('nama_merk', 'like', '%' . $this->search . '%')
            ->withCount('produk')
            ->paginate(10);

        return view('livewire.admin.merk-index', [
            'merks' => $merks
        ]);
    }
}
