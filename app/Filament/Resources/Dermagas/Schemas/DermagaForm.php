<?php

namespace App\Filament\Resources\Dermagas\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class DermagaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_dermaga')
                    ->label('Nama Dermaga')
                    ->placeholder('Masukkan nama dermaga')
                    ->required()
                    ->maxLength(255),

                TextInput::make('lokasi')
                    ->label('Lokasi')
                    ->placeholder('Masukkan lokasi dermaga')
                    ->maxLength(255),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'nonaktif' => 'Nonaktif',
                    ])
                    ->default('aktif')
                    ->required(),
            ])
            ->columns(2);
    }
}