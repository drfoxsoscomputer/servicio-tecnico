<?php

namespace App\Enums;

enum SaleStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case PARTIAL = 'partial';

    public function label(): string
    {
        return match($this) {
            self::PENDING => 'Pendiente',
            self::COMPLETED => 'Completada',
            self::CANCELLED => 'Cancelada',
            self::PARTIAL => 'Parcial',
        };
    }
}
