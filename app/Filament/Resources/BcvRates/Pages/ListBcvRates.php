<?php

namespace App\Filament\Resources\BcvRates\Pages;

use App\Filament\Resources\BcvRates\BcvRateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ListBcvRates extends ManageRecords
{
    protected static string $resource = BcvRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
