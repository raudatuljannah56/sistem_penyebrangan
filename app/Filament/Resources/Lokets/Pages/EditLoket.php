<?php

namespace App\Filament\Resources\Lokets\Pages;

use App\Filament\Resources\Lokets\LoketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditLoket extends EditRecord
{
    protected static string $resource = LoketResource::class;

    public function getHeading(): string
    {
        return 'Edit Loket';
    }

    public function getSubheading(): ?string
    {
        return 'Perbarui data loket penyeberangan.';
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Loket')
                    ->extraAttributes([
                        'class' => 'edit-form',
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
                                    $this->getSaveFormAction()
                                        ->label('Simpan Perubahan')
                                        ->color('primary')
                                        ->formId('form'),
                                ])->alignEnd(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Hapus')
                ->color('danger')
                ->modalHeading('Hapus Data Loket')
                ->modalDescription('Apakah Anda yakin ingin menghapus data loket ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->modalWidth('md')
                ->successNotificationTitle('Data loket berhasil dihapus'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Loket berhasil diperbarui';
    }
}