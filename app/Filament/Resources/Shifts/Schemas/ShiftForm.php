<?php

namespace App\Filament\Resources\Shifts\Schemas;

use App\Models\Loket;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('id_user')
                    ->label('Petugas')
                    ->options(
                        User::query()
                            ->where('role', 'petugas')
                            ->where('status', 'aktif')
                            ->pluck('nama', 'id_user')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('id_loket')
                    ->label('Loket')
                    ->options(
                        Loket::query()
                            ->where('status', 'aktif')
                            ->pluck('nama_loket', 'id_loket')
                    )
                    ->searchable()
                    ->preload()
                    ->required(),

                TimePicker::make('jam_mulai')
                    ->label('Jam Mulai')
                    ->seconds(false)
                    ->required(),

                TimePicker::make('jam_selesai')
                    ->label('Jam Selesai')
                    ->seconds(false),
            ]);
    }
}