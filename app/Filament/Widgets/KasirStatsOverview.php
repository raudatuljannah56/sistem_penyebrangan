<?php

namespace App\Filament\Widgets;

use App\Models\Shift;
use App\Models\Transaksi;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KasirStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        // ==============================
        // TRANSAKSI HARI INI
        // ==============================
        $transaksiHariIni = Transaksi::query()
            ->whereHas('shift', function ($query) {
                $query->where('id_user', auth()->id());
            })
            ->whereDate('tanggal_transaksi', today())
            ->count();

        // ==============================
        // TOTAL PENDAPATAN HARI INI
        // ==============================
        $totalPendapatanHariIni = Transaksi::query()
            ->whereHas('shift', function ($query) {
                $query->where('id_user', auth()->id());
            })
            ->whereDate('tanggal_transaksi', today())
            ->where('status', 'berhasil')
            ->sum('total');

        // ==============================
        // STATUS SHIFT KASIR
        // ==============================
        // Setelah petugas berhasil login,
        // status pada dashboard ditampilkan Aktif.
        if (auth()->check()) {
            $statusShift = 'Aktif';
            $warnaShift = 'success';
            $deskripsiShift = 'Sedang bertugas';
        } else {
            $statusShift = 'Tidak Aktif';
            $warnaShift = 'danger';
            $deskripsiShift = 'Belum login';
        }

        return [

            // ==============================
            // 1. TRANSAKSI HARI INI
            // ==============================
            Stat::make(
                'TRANSAKSI HARI INI',
                $transaksiHariIni
            )
                ->description('Total transaksi yang sudah dilakukan')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            // ==============================
            // 2. TOTAL PENDAPATAN HARI INI
            // ==============================
            Stat::make(
                'TOTAL PENDAPATAN HARI INI',
                'Rp ' . number_format(
                    $totalPendapatanHariIni,
                    0,
                    ',',
                    '.'
                )
            )
                ->description('Pendapatan dari transaksi berhasil')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // ==============================
            // 3. STATUS SHIFT
            // ==============================
            Stat::make(
                'STATUS SHIFT',
                $statusShift
            )
                ->description($deskripsiShift)
                ->descriptionIcon('heroicon-m-clock')
                ->color($warnaShift),
        ];
    }
}