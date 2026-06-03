<?php

namespace App\Filament\Resources\StockLocations\Pages;

use App\Filament\Resources\StockLocations\StockLocationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageStockLocations extends ManageRecords
{
    protected static string $resource = StockLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
