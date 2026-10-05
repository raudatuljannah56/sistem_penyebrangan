<?php

namespace App\Filament\Resources\Shifts\Tables;

use App\Models\Shift;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShiftsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                /*
                |--------------------------------------------------------------------------
                | PETUGAS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('user.nama')
                    ->label('Petugas')
                    ->searchable()
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | LOKET
                |--------------------------------------------------------------------------
                */

                TextColumn::make('loket.nama_loket')
                    ->label('Loket')
                    ->searchable()
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | DERMAGA
                |--------------------------------------------------------------------------
                */

                TextColumn::make('loket.dermaga.nama_dermaga')
                    ->label('Dermaga')
                    ->searchable()
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | JAM MULAI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->formatStateUsing(
                        fn ($state): string => $state
                            ? substr((string) $state, 0, 5)
                            : '-'
                    )
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | JAM SELESAI
                |--------------------------------------------------------------------------
                */

                TextColumn::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->formatStateUsing(
                        fn ($state): string => $state
                            ? substr((string) $state, 0, 5)
                            : '-'
                    )
                    ->sortable(),


                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()

                    ->state(
                        function (Shift $record): string {

                            /*
                            |--------------------------------------------------------------------------
                            | Sinkronisasi status otomatis.
                            |--------------------------------------------------------------------------
                            |
                            | Belum Mulai
                            | Berlangsung
                            | Selesai
                            |
                            */

                            return $record->sinkronisasiStatus();
                        }
                    )

                    ->formatStateUsing(
                        function (string $state): string {

                            return match ($state) {

                                'belum_mulai'
                                    => 'Belum Mulai',

                                'berlangsung'
                                    => 'Berlangsung',

                                'selesai'
                                    => 'Selesai',

                                default
                                    => '-',
                            };
                        }
                    )

                    ->color(
                        function (string $state): string {

                            return match ($state) {

                                'belum_mulai'
                                    => 'warning',

                                'berlangsung'
                                    => 'success',

                                'selesai'
                                    => 'danger',

                                default
                                    => 'gray',
                            };
                        }
                    )

                    ->sortable(),
            ])


            /*
            |--------------------------------------------------------------------------
            | FILTER
            |--------------------------------------------------------------------------
            */

            ->filters([])


            /*
            |--------------------------------------------------------------------------
            | ACTION
            |--------------------------------------------------------------------------
            */

            ->recordActions([
                EditAction::make()
                    ->color('warning'),
            ])


            /*
            |--------------------------------------------------------------------------
            | BULK ACTION
            |--------------------------------------------------------------------------
            */

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])


            /*
            |--------------------------------------------------------------------------
            | POLLING
            |--------------------------------------------------------------------------
            |
            | Status tabel diperbarui otomatis setiap 10 detik.
            |
            */

            ->poll('10s');
    }
}