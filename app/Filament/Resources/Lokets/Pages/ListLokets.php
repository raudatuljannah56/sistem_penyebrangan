<?php

namespace App\Filament\Resources\Lokets\Pages;

use App\Filament\Resources\Lokets\LoketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLokets extends ListRecords
{
    protected static string $resource = LoketResource::class;

    public function getSubheading(): ?string
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('+ Tambah Loket')
                ->color('primary'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [];
    }
}