<?php

namespace App\Models;

use App\Enums\DiscountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketService extends Model
{
    protected $fillable = [
        'ticket_id',
        'service_id',
        'custom_service_name',
        'location_type',
        'price',
        'discount_type',
        'discount_value',
        'discount_amount',
        'discount_note',
        'notes',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_type' => DiscountType::class,
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(ServiceTicket::class, 'ticket_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
