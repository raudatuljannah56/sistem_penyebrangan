<?php

namespace App\Filament\Resources\Lokets\Tables;

use App\Filament\Resources\Lokets\LoketResource;
use App\Models\Loket;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LoketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dermaga.nama_dermaga')
                    ->label('Dermaga')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_loket')
                    ->label('Nama Loket')
                    ->searchable(),

                TextColumn::make('kode_loket')
                    ->label('Kode Loket')
                    ->searchable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'aktif' => 'success',
                        'nonaktif' => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                //
            ])

            ->recordActions([
                EditAction::make()
                    ->color('warning'),

                Action::make('aturTarif')
                    ->label('Atur Tarif')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->color('primary')
                    ->url(
                        fn (Loket $record): string =>
                            LoketResource::getUrl(
                                'atur-tarif',
                                ['record' => $record]
                            )
                    ),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->paginationPageOptions([
                5,
                10,
                25,
                50,
                100,
            ])

            ->defaultPaginationPageOption(10);
    }
}