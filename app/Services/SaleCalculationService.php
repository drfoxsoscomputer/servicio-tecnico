<?php

namespace App\Services;

use App\Models\Sale;

class SaleCalculationService
{
    public const TAX_PERCENTAGE = 21.0;

    public function calculateTotals(Sale $sale): array
    {
        $netAmount = $this->calculateNetAmount($sale);
        $discountAmount = $this->calculateDiscountAmount($sale, $netAmount);
        $taxableAmount = $netAmount - $discountAmount;
        $taxAmount = $this->calculateTaxAmount($sale, $taxableAmount);
        $totalAmount = $taxableAmount + $taxAmount;

        return [
            'net_amount' => round($netAmount, 2),
            'discount_amount' => round($discountAmount, 2),
            'taxable_amount' => round($taxableAmount, 2),
            'tax_amount' => round($taxAmount, 2),
            'total_amount' => round($totalAmount, 2),
        ];
    }

    public function calculateNetAmount(Sale $sale): float
    {
        return $sale->items->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }

    public function calculateDiscountAmount(Sale $sale, float $netAmount): float
    {
        if ($sale->discount_type === 'percentage') {
            return $netAmount * ($sale->discount_value / 100);
        }

        if ($sale->discount_type === 'amount') {
            return (float) $sale->discount_value;
        }

        return 0.0;
    }

    public function calculateTaxAmount(Sale $sale, float $taxableAmount): float
    {
        $taxPercentage = $sale->tax_percentage ?? self::TAX_PERCENTAGE;
        return $taxableAmount * ($taxPercentage / 100);
    }

    public function recalculateSale(Sale $sale): Sale
    {
        $totals = $this->calculateTotals($sale);
        $sale->fill($totals);
        return $sale;
    }
}
