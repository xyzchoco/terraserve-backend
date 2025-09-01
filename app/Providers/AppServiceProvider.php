<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// 'Gate' dan 'User' tidak lagi diperlukan karena logikanya sudah dipindahkan
// ke User Model dengan method canAccessFilament() untuk Filament v2.

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
        // Method ini sengaja dikosongkan dari Gate::define()
        // karena Filament v2 tidak menggunakannya.
    }
}

