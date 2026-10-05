<?php

namespace App\Filament\Resources\Lokets;

use App\Filament\Resources\Lokets\Pages\AturTarifLoket;
use App\Filament\Resources\Lokets\Pages\CreateLoket;
use App\Filament\Resources\Lokets\Pages\EditLoket;
use App\Filament\Resources\Lokets\Pages\ListLokets;
use App\Filament\Resources\Lokets\Schemas\LoketForm;
use App\Filament\Resources\Lokets\Tables\LoketsTable;
use App\Models\Loket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoketResource extends Resource
{
    protected static ?string $model = Loket::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Manajemen Data';

    protected static ?string $navigationLabel = 'Loket';

    protected static ?string $modelLabel = 'Loket';

    protected static ?string $pluralModelLabel = 'Loket';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static ?string $recordTitleAttribute = 'nama_loket';

    public static function form(Schema $schema): Schema
    {
        return LoketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLokets::route('/'),
            'create' => CreateLoket::route('/create'),
            'edit' => EditLoket::route('/{record}/edit'),
            'atur-tarif' => AturTarifLoket::route('/{record}/tarif'),
        ];
    }
}