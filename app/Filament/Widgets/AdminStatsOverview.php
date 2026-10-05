<?php

namespace App\Filament\Widgets;

use App\Models\Dermaga;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

      // Dashboard mengecek ulang data setiap 3 detik
    protected ?string $pollingInterval = '3s';
    /**
     * Menentukan jumlah kolom kartu statistik.
     * Tiga kartu akan ditampilkan sejajar ke samping.
     */
    protected function getColumns(): int
    {
        return 3;
    }

    protected function getStats(): array
    {
        // ==============================
        // KASIR AKTIF
        // ==============================
        // Kasir dianggap aktif jika
        // sedang login ke sistem Petugas.
        $kasirAktif = User::query()
            ->where('role', 'petugas')
            ->where('is_logged_in', true)
            ->count();

        // ==============================
        // DERMAGA AKTIF
        // ==============================
        $dermagaAktif = Dermaga::query()
            ->where('status', 'aktif')
            ->count();

        // ==============================
        // TOTAL KESELURUHAN
        // Sementara angka contoh
        // ==============================
        $totalKeseluruhan = 0;

        return [

            // ==============================
            // 1. KASIR AKTIF
            // ==============================
            Stat::make('PETUGAS AKTIF', $kasirAktif)
                ->description('Sedang bertugas')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary'),

            // ==============================
            // 2. DERMAGA AKTIF
            // ==============================
            Stat::make('DERMAGA AKTIF', $dermagaAktif)
                ->description('Sedang beroperasi')
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('success'),

            // ==============================
            // 3. TOTAL KESELURUHAN
            // ==============================
            Stat::make(
                'TOTAL KESELURUHAN',
                'Rp ' . number_format($totalKeseluruhan, 0, ',', '.')
            )
                ->description('Total pendapatan keseluruhan')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('warning'),
        ];
    }
}