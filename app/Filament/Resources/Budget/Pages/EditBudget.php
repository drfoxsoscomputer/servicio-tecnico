<?php

namespace App\Filament\Resources\Budget\Pages;

use App\Filament\Resources\Budget\BudgetResource;
use App\Services\BudgetService;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditBudget extends EditRecord
{
    protected static string $resource = BudgetResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['client_name_display'] = $this->record->client?->name ?? $this->record->customer_name;
        
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['client_name_display']);
        
        return $data;
    }

    protected function afterSave(): void
    {
        $budgetService = app(BudgetService::class);
        $budgetService->recalculateTotals($this->record);
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()
                ->label('Ver'),
            DeleteAction::make()
                ->label('Eliminar'),
        ];
    }
}
