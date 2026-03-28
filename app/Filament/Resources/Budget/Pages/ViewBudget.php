<?php

namespace App\Filament\Resources\Budget\Pages;

use App\Filament\Resources\Budget\BudgetResource;
use App\Services\BudgetPdfService;
use App\Services\BudgetService;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewBudget extends ViewRecord
{
    protected static string $resource = BudgetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()
                ->label('Editar'),
            Action::make('imprimir')
                ->label('Imprimir Ticket')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->action(function () {
                    $pdfService = app(BudgetPdfService::class);
                    return response()->streamDownload(function () use ($pdfService) {
                        echo $pdfService->generateTicket($this->record)->output();
                    }, "presupuesto-{$this->record->budget_number}.pdf", [
                        'Content-Type' => 'application/pdf',
                    ]);
                }),
            Action::make('marcar_impreso')
                ->label('Marcar como Impreso')
                ->icon('heroicon-o-check-circle')
                ->color('warning')
                ->visible(fn () => $this->record->status !== 'printed')
                ->requiresConfirmation()
                ->action(function () {
                    $budgetService = app(BudgetService::class);
                    $budgetService->markAsPrinted($this->record);
                    $this->refreshFormData(['status', 'printed_at']);
                }),
        ];
    }
}
