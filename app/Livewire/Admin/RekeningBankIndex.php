<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Validate;
use App\Models\RekeningBank;
use Livewire\WithPagination;

class RekeningBankIndex extends Component
{
    use WithPagination;

    // Form properties
    #[Validate('required|string|max:50')]
    public $nama_bank = '';

    #[Validate('required|string|max:20')]
    public $nomor_rekening = '';

    #[Validate('required|string|max:100')]
    public $nama_pemilik = '';

    #[Validate('nullable|string|max:500')]
    public $keterangan = '';

    #[Validate('boolean')]
    public $aktif = true;

    #[Validate('integer|min:0')]
    public $urutan = 0;

    // State management
    public $showModal = false;
    public $editMode = false;
    public $editingId = null;

    // Search & Filter
    public $search = '';
    public $statusFilter = 'all'; // all, aktif, nonaktif

    protected $listeners = ['refreshRekeningBank' => '$refresh'];

    public function mount()
    {
        $this->resetFormData();
    }

    public function resetFormData()
    {
        $this->nama_bank = '';
        $this->nomor_rekening = '';
        $this->nama_pemilik = '';
        $this->keterangan = '';
        $this->aktif = true;
        $this->urutan = 0;
        $this->editMode = false;
        $this->editingId = null;
        $this->resetValidation();
    }

    public function showCreateModal()
    {
        $this->resetFormData();
        // Set urutan default ke urutan terakhir + 1
        $this->urutan = RekeningBank::max('urutan') + 1;
        $this->showModal = true;
    }

    public function showEditModal($id)
    {
        $rekening = RekeningBank::findOrFail($id);
        
        $this->editingId = $id;
        $this->nama_bank = $rekening->nama_bank;
        $this->nomor_rekening = $rekening->nomor_rekening;
        $this->nama_pemilik = $rekening->nama_pemilik;
        $this->keterangan = $rekening->keterangan ?? '';
        $this->aktif = $rekening->aktif;
        $this->urutan = $rekening->urutan;
        $this->editMode = true;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetFormData();
    }

    public function save()
    {
        $this->validate();

        if ($this->editMode) {
            $rekening = RekeningBank::findOrFail($this->editingId);
            $rekening->update([
                'nama_bank' => $this->nama_bank,
                'nomor_rekening' => $this->nomor_rekening,
                'nama_pemilik' => $this->nama_pemilik,
                'keterangan' => $this->keterangan,
                'aktif' => $this->aktif,
                'urutan' => $this->urutan,
            ]);

            session()->flash('success', 'Rekening bank berhasil diperbarui!');
        } else {
            RekeningBank::create([
                'nama_bank' => $this->nama_bank,
                'nomor_rekening' => $this->nomor_rekening,
                'nama_pemilik' => $this->nama_pemilik,
                'keterangan' => $this->keterangan,
                'aktif' => $this->aktif,
                'urutan' => $this->urutan,
            ]);

            session()->flash('success', 'Rekening bank berhasil ditambahkan!');
        }

        $this->closeModal();
        $this->dispatch('refreshRekeningBank');
    }

    public function delete($id)
    {
        $rekening = RekeningBank::findOrFail($id);
        $rekening->delete();

        session()->flash('success', 'Rekening bank berhasil dihapus!');
        $this->dispatch('refreshRekeningBank');
    }

    public function toggleStatus($id)
    {
        $rekening = RekeningBank::findOrFail($id);
        $rekening->update(['aktif' => !$rekening->aktif]);

        $status = $rekening->aktif ? 'diaktifkan' : 'dinonaktifkan';
        session()->flash('success', "Rekening bank berhasil {$status}!");
        
        $this->dispatch('refreshRekeningBank');
    }

    public function updateUrutan($id, $direction)
    {
        $rekening = RekeningBank::findOrFail($id);
        
        if ($direction === 'up') {
            $rekening->update(['urutan' => $rekening->urutan - 1]);
        } else {
            $rekening->update(['urutan' => $rekening->urutan + 1]);
        }

        $this->dispatch('refreshRekeningBank');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = RekeningBank::query();

        // Search
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('nama_bank', 'like', '%' . $this->search . '%')
                  ->orWhere('nomor_rekening', 'like', '%' . $this->search . '%')
                  ->orWhere('nama_pemilik', 'like', '%' . $this->search . '%');
            });
        }

        // Filter status
        if ($this->statusFilter === 'aktif') {
            $query->where('aktif', true);
        } elseif ($this->statusFilter === 'nonaktif') {
            $query->where('aktif', false);
        }

        $rekeningBanks = $query->urutan()->paginate(10);

        return view('livewire.admin.rekening-bank-index', [
            'rekeningBanks' => $rekeningBanks
        ]);
    }
}
