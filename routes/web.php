<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;

Route::get('/', function () {
    // Redirect admin ke admin dashboard jika sudah login
    if (Auth::check() && in_array(optional(Auth::user())->role, ['admin', 'owner'])) {
        return redirect()->route('admin.dashboard');
    }
    return view('welcome');
})->name('home');

// Customer Routes (tidak perlu middleware auth, bisa dilihat guest)
Route::get('/kategori/{kategoriId}', function($kategoriId) {
    $kategori = \App\Models\KategoriProduk::findOrFail($kategoriId);
    return view('customer.kategori', compact('kategoriId', 'kategori'));
})->name('kategori');

Route::get('/produk/{produkId}', function($produkId) {
    $produk = \App\Models\Produk::with(['kategori', 'merk'])->findOrFail($produkId);
    return view('customer.produk-detail', compact('produkId', 'produk'));
})->name('produk.detail');

Route::get('/produk', function() {
    return 'Halaman semua produk coming soon!';
})->name('produk.semua');

// Customer Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', function() {
        return view('customer.checkout');
    })->name('checkout');
    
    Route::get('/keranjang', function() {
        return view('customer.keranjang');
    })->name('keranjang');
    
    Route::get('/pesanan', function() {
        return view('customer.pesanan');
    })->name('pesanan');
    
    Route::get('/pesanan/{pesananId}', function($pesananId) {
        return view('customer.pesanan-detail', compact('pesananId'));
    })->name('pesanan.detail');
    
    Route::get('/profile', function() {
        return view('customer.profile');
    })->name('profile');
});

// Admin Routes
Route::middleware(['auth', 'role:admin,owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
    Route::get('kategori', \App\Livewire\Admin\KategoriIndex::class)->name('kategori.index');
    Route::get('merk', \App\Livewire\Admin\MerkIndex::class)->name('merk.index');
    Route::get('produk', \App\Livewire\Admin\ProdukIndex::class)->name('produk.index');
    Route::get('pesanan', \App\Livewire\Admin\PesananIndex::class)->name('pesanan.index');
});

// Redirect berdasarkan role setelah login
Route::get('/admin', function () {
    if (Auth::check() && in_array(optional(Auth::user())->role, ['admin', 'owner'])) {
        return redirect()->route('admin.dashboard');
    }
    abort(403);
})->middleware(['auth'])->name('admin');

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
