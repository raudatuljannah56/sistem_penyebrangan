<?php

namespace App\Filament\Resources\Tarifs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TarifForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_tarif')
                    ->label('Nama Tarif')
                    ->required()
                    ->maxLength(255),

                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'penumpang' => 'Penumpang',
                        'kendaraan' => 'Kendaraan',
                    ])
                    ->required(),

                TextInput::make('harga')
                    ->label('Harga')
                    ->numeric()
                    ->prefix('Rp')
                    ->required()
                    ->minValue(0),

                FileUpload::make('foto')
                    ->label('Foto Tarif')
                    ->image()
                    ->disk('public')
                    ->directory('tarif')
                    ->imagePreviewHeight('150')
                    ->nullable(),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->default('aktif')
                    ->required(),
            ]);
    }
}