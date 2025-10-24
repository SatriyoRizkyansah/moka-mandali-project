<?php

namespace App\Livewire\Customer;

use App\Models\PesanChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatGlobal extends Component
{
    public $pesanBaru = '';
    public $isOpen = false;
    public $unreadCount = 0;

    public function mount()
    {
        $this->hitungPesanBelumDibaca();
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        
        if ($this->isOpen) {
            $this->tandaiSudahDibaca();
            $this->hitungPesanBelumDibaca();
        }
    }

    public function kirimPesan()
    {
        $this->validate([
            'pesanBaru' => 'required|string|max:1000'
        ]);

        PesanChat::create([
            'id' => Str::uuid(),
            'pengguna_id' => Auth::id(),
            'isi_pesan' => $this->pesanBaru,
            'dari_admin' => false,
        ]);

        $this->reset('pesanBaru');
        $this->dispatch('pesanTerkirim');
    }

    public function tandaiSudahDibaca()
    {
        PesanChat::untukPengguna(Auth::id())
            ->where('dari_admin', true)
            ->whereNull('dibaca_customer_pada')
            ->update(['dibaca_customer_pada' => now()]);
    }

    public function hitungPesanBelumDibaca()
    {
        $this->unreadCount = PesanChat::untukPengguna(Auth::id())
            ->where('dari_admin', true)
            ->whereNull('dibaca_customer_pada')
            ->count();
    }

    #[On('pesanBaruDariAdmin')]
    public function pesanBaruDiterima()
    {
        $this->hitungPesanBelumDibaca();
    }

    public function render()
    {
        $pesanChat = [];
        
        if ($this->isOpen) {
            $pesanChat = PesanChat::untukPengguna(Auth::id())
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.customer.chat-global', [
            'pesanChat' => $pesanChat
        ]);
    }
}
