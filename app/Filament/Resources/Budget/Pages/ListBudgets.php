<?php

namespace App\Filament\Resources\Budget\Pages;

use App\Filament\Resources\Budget\BudgetResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBudgets extends ListRecords
{
    protected static string $resource = BudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Nuevo Presupuesto'),
        ];
    }
}
