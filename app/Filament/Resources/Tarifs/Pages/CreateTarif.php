<?php

namespace App\Filament\Resources\Tarifs\Pages;

use App\Filament\Resources\Tarifs\TarifResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CreateTarif extends CreateRecord
{
    protected static string $resource = TarifResource::class;

    public function getHeading(): string
    {
        return 'Tambah Tarif';
    }

    public function getSubheading(): ?string
    {
        return 'Tambahkan data tarif penyeberangan.';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Tarif')
                    ->extraAttributes([
                        'class' => 'create-form',
                        'style' => 'overflow: hidden; border-radius: 16px;',
                    ])
                    ->schema([
                        $this->getFormContentComponent(),

                        Grid::make(2)
                            ->schema([
                                Actions::make([
                                    $this->getCancelFormAction()
                                        ->label('Batal')
                                        ->color('gray'),
                                ]),

                                Actions::make([
                                    $this->getCreateAnotherFormAction()
                                        ->label('Simpan & Tambah Lagi')
                                        ->color('gray')
                                        ->formId('form'),

                                    $this->getCreateFormAction()
                                        ->label('Simpan')
                                        ->color('primary')
                                        ->formId('form'),
                                ])
                                    ->alignEnd(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Tarif berhasil ditambahkan';
    }
}