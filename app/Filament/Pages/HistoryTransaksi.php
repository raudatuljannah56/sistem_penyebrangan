<?php

namespace App\Filament\Pages;

use App\Models\Transaksi;
use Carbon\Carbon;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class HistoryTransaksi extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $title = 'History Transaksi';

    protected static ?string $navigationLabel = 'History Transaksi';

    protected static string|UnitEnum|null $navigationGroup = 'Pelayanan';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.history-transaksi';

    public ?string $tanggalAwal = null;

    public ?string $tanggalAkhir = null;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaksi::query()
            )

            ->columns([
                /*
                |--------------------------------------------------------------------------
                | NO
                |--------------------------------------------------------------------------
                */

                TextColumn::make('nomor')
                    ->label('No.')
                    ->rowIndex(),

                /*
                |--------------------------------------------------------------------------
                | KODE TRX
                |--------------------------------------------------------------------------
                */

                TextColumn::make('kode_transaksi')
                    ->label('Kode Trx')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->getStateUsing(
                        function (Transaksi $record): string {
                            if (!$record->tanggal_transaksi) {
                                return '-';
                            }

                            return Carbon::parse(
                                $record->tanggal_transaksi
                            )->format('d/m/Y');
                        }
                    )
                    ->sortable(
                        query: fn (
                            Builder $query,
                            string $direction
                        ): Builder =>
                            $query->orderBy(
                                'tanggal_transaksi',
                                $direction
                            )
                    ),

                /*
                |--------------------------------------------------------------------------
                | JAM
                |--------------------------------------------------------------------------
                */

                TextColumn::make('jam')
                    ->label('Jam')
                    ->getStateUsing(
                        function (Transaksi $record): string {
                            if (!$record->tanggal_transaksi) {
                                return '-';
                            }

                            return Carbon::parse(
                                $record->tanggal_transaksi
                            )->format('H:i:s');
                        }
                    )
                    ->sortable(
                        query: fn (
                            Builder $query,
                            string $direction
                        ): Builder =>
                            $query->orderBy(
                                'tanggal_transaksi',
                                $direction
                            )
                    ),

                /*
                |--------------------------------------------------------------------------
                | TOTAL QTY
                |--------------------------------------------------------------------------
                */

                TextColumn::make('jumlah')
                    ->label('Total Qty')
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | METODE PEMBAYARAN
                |--------------------------------------------------------------------------
                */

                TextColumn::make('metode_pembayaran')
                    ->label('Metode Pembayaran')
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'tunai' => 'Tunai',
                            'qris' => 'QRIS',
                            default => '-',
                        }
                    )
                    ->badge()
                    ->color(
                        fn (?string $state): string => match ($state) {
                            'tunai' => 'gray',
                            'qris' => 'info',
                            default => 'gray',
                        }
                    )
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(
                        fn (?string $state): string => match ($state) {
                            'berhasil' => 'Berhasil',
                            'gagal' => 'Gagal',
                            'pending' => 'Pending',
                            default => '-',
                        }
                    )
                    ->badge()
                    ->color(
                        fn (?string $state): string => match ($state) {
                            'berhasil' => 'success',
                            'gagal' => 'danger',
                            'pending' => 'warning',
                            default => 'gray',
                        }
                    )
                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | DISCOUNT
                |--------------------------------------------------------------------------
                */

                TextColumn::make('discount')
                    ->label('Discount Nominal')
                    ->state(
                        fn (): string => 'Rp 0'
                    ),

                /*
                |--------------------------------------------------------------------------
                | TOTAL TRANSAKSI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('total')
                    ->label('Total Transaksi')
                    ->formatStateUsing(
                        fn ($state): string =>
                            'Rp ' . number_format(
                                (float) $state,
                                0,
                                ',',
                                '.'
                            )
                    )
                    ->sortable(),
            ])

            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL + SEARCH
            |--------------------------------------------------------------------------
            */

            ->modifyQueryUsing(
                function (Builder $query): Builder {

                    /*
                    |--------------------------------------------------------------------------
                    | FILTER TANGGAL AWAL
                    |--------------------------------------------------------------------------
                    */

                    $query->when(
                        $this->tanggalAwal,
                        fn (
                            Builder $query
                        ): Builder =>
                            $query->whereDate(
                                'tanggal_transaksi',
                                '>=',
                                $this->tanggalAwal
                            )
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | FILTER TANGGAL AKHIR
                    |--------------------------------------------------------------------------
                    */

                    $query->when(
                        $this->tanggalAkhir,
                        fn (
                            Builder $query
                        ): Builder =>
                            $query->whereDate(
                                'tanggal_transaksi',
                                '<=',
                                $this->tanggalAkhir
                            )
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | SEARCH SEMUA ISI TABEL
                    |--------------------------------------------------------------------------
                    |
                    | Search dapat mencari:
                    |
                    | - Kode transaksi
                    | - Tanggal
                    | - Jam
                    | - Total Qty
                    | - Metode Pembayaran
                    | - Status
                    | - Total transaksi
                    |
                    */

                    $kataKunci = trim(
                        (string) ($this->tableSearch ?? '')
                    );

                    if ($kataKunci !== '') {

                        $query->where(
                            function (Builder $searchQuery) use ($kataKunci): void {

                                /*
                                |--------------------------------------------------------------------------
                                | KODE TRANSAKSI
                                |--------------------------------------------------------------------------
                                */

                                $searchQuery->where(
                                    'kode_transaksi',
                                    'like',
                                    '%' . $kataKunci . '%'
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | TOTAL QTY
                                |--------------------------------------------------------------------------
                                */

                                ->orWhere(
                                    'jumlah',
                                    'like',
                                    '%' . $kataKunci . '%'
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | METODE PEMBAYARAN
                                |--------------------------------------------------------------------------
                                */

                                ->orWhere(
                                    'metode_pembayaran',
                                    'like',
                                    '%' . strtolower($kataKunci) . '%'
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | STATUS
                                |--------------------------------------------------------------------------
                                */

                                ->orWhere(
                                    'status',
                                    'like',
                                    '%' . strtolower($kataKunci) . '%'
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | TOTAL TRANSAKSI
                                |--------------------------------------------------------------------------
                                */

                                ->orWhere(
                                    'total',
                                    'like',
                                    '%' . $kataKunci . '%'
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | TANGGAL
                                |--------------------------------------------------------------------------
                                |
                                | Contoh:
                                | 07/09/2026
                                | 2026-09-07
                                |
                                */

                                ->orWhereRaw(
                                    "DATE_FORMAT(tanggal_transaksi, '%d/%m/%Y') LIKE ?",
                                    ['%' . $kataKunci . '%']
                                )

                                ->orWhereRaw(
                                    "DATE_FORMAT(tanggal_transaksi, '%Y-%m-%d') LIKE ?",
                                    ['%' . $kataKunci . '%']
                                )


                                /*
                                |--------------------------------------------------------------------------
                                | JAM
                                |--------------------------------------------------------------------------
                                |
                                | Contoh:
                                | 08:30
                                | 08:30:15
                                |
                                */

                                ->orWhereRaw(
                                    "TIME_FORMAT(tanggal_transaksi, '%H:%i:%s') LIKE ?",
                                    ['%' . $kataKunci . '%']
                                )

                                ->orWhereRaw(
                                    "TIME_FORMAT(tanggal_transaksi, '%H:%i') LIKE ?",
                                    ['%' . $kataKunci . '%']
                                );
                            }
                        );
                    }

                    return $query;
                }
            )

            /*
            |--------------------------------------------------------------------------
            | SORT DEFAULT
            |--------------------------------------------------------------------------
            */

            ->defaultSort(
                'tanggal_transaksi',
                'desc'
            )

            /*
            |--------------------------------------------------------------------------
            | PAGINATION
            |--------------------------------------------------------------------------
            */

            ->defaultPaginationPageOption(10)

            ->paginationPageOptions([
                10,
                25,
                50,
                100,
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | TAMPILKAN DATA
    |--------------------------------------------------------------------------
    */

    public function tampilkanData(): void
    {
        $this->resetTable();
    }
}