<?php

namespace App\Filament\Resources\DeviceTypes\Pages;

use App\Filament\Resources\DeviceTypes\DeviceTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageDeviceTypes extends ManageRecords
{
    protected static string $resource = DeviceTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
