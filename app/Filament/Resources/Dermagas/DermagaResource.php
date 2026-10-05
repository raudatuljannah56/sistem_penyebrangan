<?php

namespace App\Filament\Resources\Dermagas;

use App\Filament\Resources\Dermagas\Pages\CreateDermaga;
use App\Filament\Resources\Dermagas\Pages\EditDermaga;
use App\Filament\Resources\Dermagas\Pages\ListDermagas;
use App\Filament\Resources\Dermagas\Schemas\DermagaForm;
use App\Filament\Resources\Dermagas\Tables\DermagasTable;
use App\Models\Dermaga;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class DermagaResource extends Resource
{
    protected static ?string $model = Dermaga::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMap;

    protected static UnitEnum|string|null $navigationGroup = 'Manajemen Data';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Dermaga';

    protected static ?string $modelLabel = 'Dermaga';

    protected static ?string $pluralModelLabel = 'Dermaga';

    protected static ?string $recordTitleAttribute = 'nama_dermaga';

    public static function form(Schema $schema): Schema
    {
        return DermagaForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DermagasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDermagas::route('/'),
            'create' => CreateDermaga::route('/create'),
            'edit' => EditDermaga::route('/{record}/edit'),
        ];
    }
}