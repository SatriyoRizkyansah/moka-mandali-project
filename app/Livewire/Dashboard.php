<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $userName = '';
    public $userStats = [];

    public function mount()
    {
        $this->userName = Auth::user()->name;
        $this->loadStats();
    }

    public function loadStats()
    {
        // Sample data - replace with your actual data
        $this->userStats = [
            'totalUsers' => 1234,
            'revenue' => 12345,
            'orders' => 567,
            'growth' => [
                'users' => 12,
                'revenue' => 8,
                'orders' => 15
            ]
        ];
    }

    public function refreshStats()
    {
        $this->loadStats();
        $this->dispatch('stats-updated');
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}