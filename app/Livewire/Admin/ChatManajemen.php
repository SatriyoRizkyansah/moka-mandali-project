<?php

namespace App\Livewire\Admin;

use App\Models\PesanChat;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatManajemen extends Component
{
    public $selectedUserId = null;
    public $pesanBaru = '';
    public $search = '';

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->tandaiSudahDibaca($userId);
    }

    public function kirimPesan()
    {
        $this->validate([
            'pesanBaru' => 'required|string|max:1000',
            'selectedUserId' => 'required|exists:users,id'
        ]);

        PesanChat::create([
            'id' => Str::uuid(),
            'pengguna_id' => $this->selectedUserId,
            'isi_pesan' => $this->pesanBaru,
            'dari_admin' => true,
        ]);

        $this->reset('pesanBaru');
        $this->dispatch('pesanTerkirim');
    }

    public function tandaiSudahDibaca($userId)
    {
        PesanChat::untukPengguna($userId)
            ->where('dari_admin', false)
            ->whereNull('dibaca_admin_pada')
            ->update(['dibaca_admin_pada' => now()]);
    }

    public function getDaftarCustomerProperty()
    {
        $query = User::whereHas('pesanChat')
            ->with(['pesanChat' => function ($query) {
                $query->latest()->take(1);
            }]);

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        return $query->get()->map(function ($user) {
            $unreadCount = PesanChat::untukPengguna($user->id)
                ->where('dari_admin', false)
                ->whereNull('dibaca_admin_pada')
                ->count();

            $latestMessage = $user->pesanChat->first();

            return (object) [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'unread_count' => $unreadCount,
                'latest_message' => $latestMessage ? $latestMessage->isi_pesan : 'Belum ada pesan',
                'latest_time' => $latestMessage ? $latestMessage->created_at : null,
            ];
        })->sortByDesc('latest_time');
    }

    public function getPesanChatProperty()
    {
        if (!$this->selectedUserId) {
            return collect();
        }

        return PesanChat::untukPengguna($this->selectedUserId)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function getSelectedUserProperty()
    {
        if (!$this->selectedUserId) {
            return null;
        }

        return User::find($this->selectedUserId);
    }

    #[On('pesanBaruDariCustomer')]
    public function pesanBaruDiterima()
    {
        // Refresh data ketika ada pesan baru
    }

    public function render()
    {
        return view('livewire.admin.chat-manajemen', [
            'daftarCustomer' => $this->daftarCustomer,
            'pesanChat' => $this->pesanChat,
            'selectedUser' => $this->selectedUser,
        ]);
    }
}
