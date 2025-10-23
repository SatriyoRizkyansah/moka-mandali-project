<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Produk;
use App\Models\KategoriProduk;
use App\Models\MerkProduk;
use Livewire\Attributes\Validate;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;

#[Layout('components.layouts.admin')]
class ProdukIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $showModal = false;
    public $editingId = null;
    
    #[Validate('required|min:3')]
    public $nama = '';
    
    #[Validate('nullable|string')]
    public $deskripsi = '';
    
    #[Validate('required|numeric|min:1')]
    public $harga = '';
    
    #[Validate('required|integer|min:0')]
    public $stok = '';
    
    #[Validate('required|exists:kategori_produk,id')]
    public $kategori_id = '';
    
    #[Validate('required|exists:merk_produk,id')]
    public $merk_id = '';
    
    #[Validate('nullable|image|max:2048')]
    public $foto;

    public $existing_foto = '';

    public function resetForm()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->harga = '';
        $this->stok = '';
        $this->kategori_id = '';
        $this->merk_id = '';
        $this->foto = null;
        $this->existing_foto = '';
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
        $produk = Produk::findOrFail($id);
        $this->editingId = $id;
        $this->nama = $produk->nama;
        $this->deskripsi = $produk->deskripsi;
        $this->harga = $produk->harga;
        $this->stok = $produk->stok;
        $this->kategori_id = $produk->kategori_id;
        $this->merk_id = $produk->merk_id;
        $this->existing_foto = $produk->foto;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'deskripsi' => $this->deskripsi,
            'harga' => $this->harga,
            'stok' => $this->stok,
            'kategori_id' => $this->kategori_id,
            'merk_id' => $this->merk_id,
        ];

        // Handle foto upload
        if ($this->foto) {
            $filename = time() . '_' . $this->foto->getClientOriginalName();
            $this->foto->storeAs('produk', $filename, 'public');
            $data['foto'] = $filename;

            // Delete old foto if editing
            if ($this->editingId && $this->existing_foto) {
                Storage::disk('public')->delete('produk/' . $this->existing_foto);
            }
        }

        if ($this->editingId) {
            // Update
            $produk = Produk::findOrFail($this->editingId);
            $produk->update($data);
            session()->flash('message', 'Produk berhasil diperbarui.');
        } else {
            // Create
            Produk::create($data);
            session()->flash('message', 'Produk berhasil ditambahkan.');
        }

        $this->resetForm();
        $this->showModal = false;
    }

    public function delete($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Check jika produk memiliki detail pesanan
        if ($produk->detailPesanan()->count() > 0) {
            session()->flash('error', 'Produk tidak dapat dihapus karena sudah ada dalam pesanan.');
            return;
        }

        // Delete foto file
        if ($produk->foto) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
        }

        $produk->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $produks = Produk::with(['kategori', 'merk'])
            ->where('nama', 'like', '%' . $this->search . '%')
            ->paginate(10);

        $kategoris = KategoriProduk::orderBy('nama')->get();
        $merks = MerkProduk::orderBy('nama_merk')->get();

        return view('livewire.admin.produk-index', [
            'produks' => $produks,
            'kategoris' => $kategoris,
            'merks' => $merks
        ]);
    }
}
