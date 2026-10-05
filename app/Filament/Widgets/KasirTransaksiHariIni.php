<?php

namespace App\Filament\Widgets;

use App\Models\Transaksi;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class KasirTransaksiHariIni extends TableWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return Transaksi::query()
            ->whereHas('shift', function (Builder $query) {
                $query->where('id_user', auth()->id());
            })
            ->whereDate('tanggal_transaksi', today())
            ->latest('tanggal_transaksi');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Transaksi Hari Ini')

            ->description(
                'Daftar transaksi yang dilakukan pada shift Anda hari ini.'
            )

            ->extraAttributes([
                'class' => 'petugas-transaksi-hari-ini',
            ])

            ->columns([
                TextColumn::make('tanggal_transaksi')
                    ->label('Waktu')
                    ->dateTime('H:i')
                    ->sortable(),

                TextColumn::make('tarif.nama_tarif')
                    ->label('Jenis'),

                TextColumn::make('total')
                    ->label('Tarif')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'qris' => 'QRIS',
                        'tunai' => 'Tunai',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'qris' => 'primary',
                        'tunai' => 'success',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'berhasil' => 'Berhasil',
                        'pending' => 'Menunggu Pembayaran',
                        'gagal' => 'Gagal',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'berhasil' => 'success',
                        'pending' => 'warning',
                        'gagal' => 'danger',
                        default => 'gray',
                    }),
            ])

            ->paginated(false)

            ->emptyStateHeading('Belum ada transaksi hari ini')

            ->emptyStateDescription(
                'Transaksi yang Anda lakukan hari ini akan tampil di sini.'
            );
    }
}