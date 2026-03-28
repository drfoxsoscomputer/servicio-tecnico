<?php

namespace App\Filament\Resources\Budget\Pages;

use App\Filament\Resources\Budget\BudgetResource;
use App\Models\Budget;
use App\Services\BudgetService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateBudget extends CreateRecord
{
    protected static string $resource = BudgetResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $budgetService = app(BudgetService::class);
        
        $data['budget_number'] = $budgetService->generateNumber();
        $data['exchange_rate'] = app(\App\Services\BcvRateService::class)->getCurrentRate();
        $data['created_by'] = auth()->id();
        $data['status'] = 'draft';

        return $data;
    }

    protected function afterCreate(): void
    {
        $budget = $this->record;
        
        $budgetService = app(BudgetService::class);
        $budgetService->recalculateTotals($budget);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->record]);
    }
}
