<?php

namespace App\Providers;

use App\Http\Responses\LogoutResponse;
use Filament\Http\Responses\Auth\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LogoutResponseContract::class,
            LogoutResponse::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Saat Petugas berhasil login
        Event::listen(Login::class, function (Login $event) {
            if ($event->user && $event->user->role === 'petugas') {
                $event->user->forceFill([
                    'is_logged_in' => true,
                ])->save();
            }
        });

        // Saat Petugas logout
        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user && $event->user->role === 'petugas') {
                $event->user->forceFill([
                    'is_logged_in' => false,
                ])->save();
            }
        });
    }
}