<?php

namespace App\Services;

use App\Models\Budget;
use Barryvdh\DomPDF\Facade\Pdf;

class BudgetPdfService
{
    protected BcvRateService $bcvRateService;

    public function __construct()
    {
        $this->bcvRateService = new BcvRateService();
    }

    public function generateTicket(Budget $budget): \Barryvdh\DomPDF\PDF
    {
        $budget->load('items');

        return Pdf::loadView('pos.tickets.budget-ticket', [
            'budget' => $budget,
            'bcvRate' => $budget->exchange_rate ?? $this->bcvRateService->getCurrentRate(),
            'companyName' => config('app.name', 'Servicio Técnico'),
            'companyPhone' => config('pos.phone', '0412-1234567'),
            'companyAddress' => config('pos.address', 'Ciudad de Venezuela'),
        ]);
    }

    public function downloadTicket(Budget $budget): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $pdf = $this->generateTicket($budget);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "presupuesto-{$budget->budget_number}.pdf", [
            'Content-Type' => 'application/pdf',
        ]);
    }
}
