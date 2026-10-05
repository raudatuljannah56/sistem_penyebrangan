<?php

namespace App\Filament\Resources\Lokets\Schemas;

use App\Models\Dermaga;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LoketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_dermaga')
                    ->label('Dermaga')
                    ->options(
                        Dermaga::query()
                            ->pluck('nama_dermaga', 'id_dermaga')
                            ->toArray()
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TextInput::make('nama_loket')
                    ->label('Nama Loket')
                    ->required()
                    ->maxLength(100),

                TextInput::make('kode_loket')
                    ->label('Kode Loket')
                    ->required()
                    ->maxLength(50),

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