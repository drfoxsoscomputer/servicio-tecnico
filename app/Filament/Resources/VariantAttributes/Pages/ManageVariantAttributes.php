<?php

namespace App\Filament\Resources\VariantAttributes\Pages;

use App\Filament\Resources\VariantAttributes\VariantAttributeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVariantAttributes extends ManageRecords
{
    protected static string $resource = VariantAttributeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
