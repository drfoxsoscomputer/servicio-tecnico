<?php

namespace App\Services;

use App\Models\Budget;
use Illuminate\Support\Facades\DB;

class BudgetService
{
    protected const PREFIX = 'PRE';
    protected BcvRateService $bcvRateService;

    public function __construct()
    {
        $this->bcvRateService = new BcvRateService();
    }

    public function generateNumber(): string
    {
        $year = now()->format('Y');
        $prefix = self::PREFIX . '-' . $year . '-';

        $lastBudget = Budget::where('budget_number', 'like', $prefix . '%')
            ->orderByDesc('budget_number')
            ->first();

        if ($lastBudget) {
            $lastNumber = (int) substr($lastBudget->budget_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad((string) $newNumber, 4, '0', STR_PAD_LEFT);
    }

    public function calculateTotals(Budget $budget): array
    {
        $items = $budget->items;
        
        $subtotalBs = $items->sum(fn ($item) => $item->quantity * $item->unit_price_bs);
        $subtotalUsd = $items->sum(fn ($item) => $item->quantity * $item->unit_price_usd);
        
        $exchangeRate = $this->bcvRateService->getCurrentRate();
        
        $totalBs = $this->bcvRateService->convertToBs($subtotalUsd, $exchangeRate);

        return [
            'subtotal_bs' => round($subtotalBs, 2),
            'subtotal_usd' => round($subtotalUsd, 2),
            'exchange_rate' => round($exchangeRate, 2),
            'total_bs' => round($totalBs, 2),
        ];
    }

    public function convertToBs(float $usd, ?float $rate = null): float
    {
        return $this->bcvRateService->convertToBs($usd, $rate);
    }

    public function createBudget(array $data): Budget
    {
        $data['budget_number'] = $this->generateNumber();
        $data['exchange_rate'] = $this->bcvRateService->getCurrentRate();
        $data['created_by'] = auth()->id();

        return Budget::create($data);
    }

    public function updateBudget(Budget $budget, array $data): Budget
    {
        $budget->fill($data);
        $budget->save();
        return $budget;
    }

    public function recalculateTotals(Budget $budget): Budget
    {
        $totals = $this->calculateTotals($budget);
        $budget->fill($totals);
        $budget->save();
        return $budget;
    }

    public function markAsPrinted(Budget $budget): Budget
    {
        $budget->markAsPrinted();
        return $budget->fresh();
    }
}
