<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::twoFactorChallengeView(fn () => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn () => view('livewire.auth.confirm-password'));

        // Custom redirect after login based on user role
        Fortify::redirects('login', function () {
            $user = Auth::user();
            
            if ($user && in_array($user->role, ['admin', 'owner'])) {
                return '/admin/dashboard';
            }
            return '/'; // Customer ke home page utama
        });

        // Also handle other authentication redirects
        Fortify::redirects('register', function () {
            return '/'; // Customer baru langsung ke home
        });

        Fortify::redirects('email-verification', function () {
            $user = Auth::user();
            if ($user && in_array($user->role, ['admin', 'owner'])) {
                return '/admin/dashboard';
            }
            return '/'; // Customer ke home page
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
