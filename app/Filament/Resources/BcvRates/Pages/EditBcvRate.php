<?php

namespace App\Filament\Resources\BcvRates\Pages;

use App\Filament\Resources\BcvRates\BcvRateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBcvRate extends EditRecord
{
    protected static string $resource = BcvRateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
