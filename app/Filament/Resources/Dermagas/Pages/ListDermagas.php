<?php

namespace App\Filament\Resources\Dermagas\Pages;

use App\Filament\Resources\Dermagas\DermagaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDermagas extends ListRecords
{
    protected static string $resource = DermagaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('+ Tambah Dermaga'),
        ];
    }
}
