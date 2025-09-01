<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
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
        // TAMBAHKAN KODE GATE DI SINI
        Gate::define('view-admin', function (User $user) {
            // Ganti logika ini sesuai kebutuhan Anda.
            // Contoh: Hanya user dengan role 'admin' yang bisa akses
            return $user->role === 'admin';
            
            // Contoh lain: Berdasarkan email
            // return $user->email === 'admin@example.com';
        });
    }
}
