<?php

namespace App\Filament\Resources\BcvRates;

use App\Filament\Resources\BcvRates\Pages\CreateBcvRate;
use App\Filament\Resources\BcvRates\Pages\EditBcvRate;
use App\Filament\Resources\BcvRates\Pages\ListBcvRates;
use App\Filament\Resources\BcvRates\Schemas\BcvRateForm;
use App\Filament\Resources\BcvRates\Tables\BcvRatesTable;
use App\Models\BcvRate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BcvRateResource extends Resource
{
    protected static string|null $model = BcvRate::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';

    protected static string|null $navigationLabel = 'Tasas BCV';
    
    protected static string|null $modelLabel = 'Tasa BCV';

    protected static string|null $pluralModelLabel = 'Tasas BCV';

    protected static \UnitEnum|string|null $navigationGroup = 'Configuración';

    public static function form(Schema $schema): Schema
    {
        return BcvRateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BcvRatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBcvRates::route('/'),
        ];
    }
}
