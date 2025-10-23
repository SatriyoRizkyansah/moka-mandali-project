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
    
    // allow multiple uploads
    #[Validate('nullable')]
    public $fotos = [];

    // existing primary foto filename (fallback for legacy column)
    public $existing_foto = '';

    // existing photos collection (ProdukPhoto) to show in edit mode
    public $existingPhotos = [];

    public function resetForm()
    {
        $this->nama = '';
        $this->deskripsi = '';
        $this->harga = '';
        $this->stok = '';
        $this->kategori_id = '';
        $this->merk_id = '';
        $this->fotos = [];
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
        // load existing photos
        $this->existingPhotos = $produk->photos()->get()->toArray();
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

        // Handle foto(s) upload - support multiple files
        $uploadedFilenames = [];
        if (!empty($this->fotos)) {
            foreach ($this->fotos as $file) {
                if (!$file) continue;
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->storeAs('produk', $filename, 'public');
                $uploadedFilenames[] = $filename;
            }
        }

        if ($this->editingId) {
            // Update
            $produk = Produk::findOrFail($this->editingId);
            $produk->update($data);

            // attach uploaded photos to produk_photos
            foreach ($uploadedFilenames as $i => $filename) {
                \App\Models\ProdukPhoto::create([
                    'produk_id' => $produk->id,
                    'path' => 'produk/' . $filename,
                    'is_primary' => ($i === 0 && !$produk->photos()->where('is_primary', true)->exists()),
                    'sort_order' => $produk->photos()->count() + $i,
                ]);
            }

            session()->flash('message', 'Produk berhasil diperbarui.');
        } else {
            // Create
            $produk = Produk::create($data);

            foreach ($uploadedFilenames as $i => $filename) {
                \App\Models\ProdukPhoto::create([
                    'produk_id' => $produk->id,
                    'path' => 'produk/' . $filename,
                    'is_primary' => ($i === 0),
                    'sort_order' => $i,
                ]);
            }

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

        // Delete legacy foto file
        if ($produk->foto) {
            Storage::disk('public')->delete('produk/' . $produk->foto);
        }

        // Delete produk_photos files and records
        foreach ($produk->photos()->get() as $photo) {
            Storage::disk('public')->delete($photo->path);
            $photo->delete();
        }

        $produk->delete();
        session()->flash('message', 'Produk berhasil dihapus.');
    }

    /**
     * Remove an existing ProdukPhoto by id (called from UI)
     */
    public function removePhoto($photoId)
    {
        $photo = \App\Models\ProdukPhoto::find($photoId);
        if (! $photo) {
            session()->flash('error', 'Foto tidak ditemukan.');
            return;
        }

        // delete file from storage
        \Illuminate\Support\Facades\Storage::disk('public')->delete($photo->path);
        $photo->delete();

        // refresh existingPhotos if editing
        if ($this->editingId) {
            $this->existingPhotos = Produk::find($this->editingId)->photos()->get()->toArray();
        }

        session()->flash('message', 'Foto berhasil dihapus.');
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
