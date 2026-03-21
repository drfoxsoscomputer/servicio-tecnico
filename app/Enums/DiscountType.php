<?php

namespace App\Enums;

enum DiscountType: string
{
    case PERCENTAGE = 'percentage';
    case FIXED = 'fixed';

    public function label(): string
    {
        return match($this) {
            self::PERCENTAGE => 'Porcentaje',
            self::FIXED => 'Monto fijo',
        };
    }
}
