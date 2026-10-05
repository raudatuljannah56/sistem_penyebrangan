<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\AdminTransaksiTerbaru;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Profile;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')

            ->viteTheme('resources/css/filament/admin/theme.css')

            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): string => '<div data-panel-role="admin" style="display:none;"></div>',
            )

            ->renderHook(
                PanelsRenderHook::PAGE_HEADER_HEADING_AFTER,
                fn (): HtmlString => request()->routeIs('filament.admin.pages.dashboard')
                    ? new HtmlString(
                        '<div class="admin-dashboard-welcome">
                            Selamat datang kembali, Admin. Berikut ringkasan informasi penyeberangan hari ini.
                        </div>'
                    )
                    : new HtmlString(''),
            )

            ->colors([
                'primary' => Color::Blue,
            ])

            /* =================================================
               URUTAN KELOMPOK MENU SIDEBAR
               ================================================= */

            ->navigationGroups([
                'Manajemen Data',
                'Pelayanan',
                'Shift Petugas',
                'Laporan',
            ])

            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources'
            )

            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages'
            )

            ->pages([
                Dashboard::class,
                Profile::class,
            ])

            ->userMenuItems([
                'profile' => \Filament\Navigation\MenuItem::make()
                    ->label('Profil')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn (): string => Profile::getUrl()),
            ])

            /* =================================================
               WIDGET DASHBOARD ADMIN
               ================================================= */

            ->widgets([
                AdminStatsOverview::class,
                AdminTransaksiTerbaru::class,
            ])

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])

            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}