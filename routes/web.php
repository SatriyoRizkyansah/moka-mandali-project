<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

use App\Livewire\Dashboard;

Route::get('dashboard', Dashboard::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Redirect berdasarkan role setelah login
Route::get('/admin', function () {
    if (Auth::check() && Auth::user()->hasAnyRole(['admin', 'owner'])) {
        return redirect()->route('admin.dashboard');
    }
    abort(403);
})->middleware(['auth'])->name('admin');

// Admin Routes
Route::middleware(['auth', 'role:admin,owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('kategori', \App\Livewire\Admin\KategoriIndex::class)->name('kategori.index');
    // Route::get('merk', \App\Livewire\Admin\MerkIndex::class)->name('merk.index');
    // Route::get('produk', \App\Livewire\Admin\ProdukIndex::class)->name('produk.index');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
