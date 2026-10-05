<?php

namespace App\Filament\Resources\Lokets\Pages;

use App\Filament\Resources\Lokets\LoketResource;
use App\Models\Loket;
use App\Models\Tarif;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;

class AturTarifLoket extends Page
{
    protected static string $resource = LoketResource::class;

    protected string $view = 'filament.resources.lokets.pages.atur-tarif-loket';

    protected static ?string $title = 'Tarif yang Dilayani';

    public Loket $record;

    public array $selectedTarifIds = [];

    public string $search = '';

    public function mount(Loket $record): void
    {
        $this->record = $record->load('dermaga');

        $this->selectedTarifIds = $this->record
            ->tarifs()
            ->pluck('tarifs.id_tarif')
            ->map(fn ($id) => (int) $id)
            ->all();
    }

    public function getTarifsProperty()
    {
        return Tarif::query()
            ->where('status', 'aktif')
            ->when(
                trim($this->search) !== '',
                function ($query) {
                    $search = trim($this->search);

                    $query->where(function ($query) use ($search) {
                        $query
                            ->where('nama_tarif', 'like', "%{$search}%")
                            ->orWhere('kategori', 'like', "%{$search}%");
                    });
                }
            )
            ->orderBy('kategori')
            ->orderBy('nama_tarif')
            ->get();
    }

    public function simpanTarif(): void
    {
        $ids = collect($this->selectedTarifIds)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $tarifYangAda = Tarif::query()
            ->whereIn('id_tarif', $ids)
            ->where('status', 'aktif')
            ->pluck('id_tarif')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->record->tarifs()->sync($tarifYangAda);

        $this->selectedTarifIds = $this->record
            ->tarifs()
            ->pluck('tarifs.id_tarif')
            ->map(fn ($id) => (int) $id)
            ->all();

        Notification::make()
            ->title('Tarif loket berhasil diperbarui.')
            ->success()
            ->send();
    }

    public function batal()
    {
        return redirect(
            LoketResource::getUrl('index')
        );
    }
}