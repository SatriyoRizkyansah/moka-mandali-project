<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class Profile extends Component
{
    public $name;
    public $email;
    public $telepon;
    public $alamat;
    
    // Password fields
    public $current_password;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
        $this->telepon = $user->telepon;
        $this->alamat = $user->alamat;
    }

    public function updateProfile()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'telepon' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500',
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
            'telepon' => $this->telepon,
            'alamat' => $this->alamat,
        ]);

        session()->flash('profile-message', 'Profile berhasil diperbarui!');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'password' => Hash::make($this->password)
        ]);

        // Clear password fields
        $this->current_password = '';
        $this->password = '';
        $this->password_confirmation = '';

        session()->flash('password-message', 'Password berhasil diperbarui!');
    }

    public function render()
    {
        return view('livewire.customer.profile');
    }
}
