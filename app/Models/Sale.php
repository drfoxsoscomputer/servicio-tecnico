<?php

namespace App\Models;

use App\Enums\DiscountType;
use App\Enums\SaleStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\SaleCalculationService;

class Sale extends Model
{
    use SoftDeletes;

    protected static ?SaleCalculationService $calculationService = null;

    public static function getCalculationService(): SaleCalculationService
    {
        return self::$calculationService ??= new SaleCalculationService();
    }

    protected $fillable = [
        'document_number',
        'ticket_id',
        'client_id',
        'user_id',
        'type',
        'sale_type',
        'subtotal',
        'discount_type',
        'discount_value',
        'discount_amount',
        'total_bs',
        'total_usd',
        'exchange_rate',
        'status',
        'notes',
    ];

    protected $casts = [
        'discount_type' => DiscountType::class,
        'status' => SaleStatus::class,
        'subtotal' => 'decimal:2',
        'discount_value' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_bs' => 'decimal:2',
        'total_usd' => 'decimal:2',
        'exchange_rate' => 'decimal:2',
    ];

    // ===== RELACIONES =====

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(ServiceTicket::class, 'ticket_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SalePayment::class);
    }

    // ===== SCOPES =====

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', SaleStatus::PENDING);
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', SaleStatus::COMPLETED);
    }

    public function scopeByDateRange(Builder $query, $from, $to): Builder
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeByClient(Builder $query, $clientId): Builder
    {
        return $query->where('client_id', $clientId);
    }

    // ===== ACCESSORS =====

    public function getTitleAttribute(): string
    {
        return "Documento #{$this->document_number}";
    }

    public function getPaidAmountAttribute(): float
    {
        return (float) $this->payments->sum('amount');
    }

    public function getPendingAmountAttribute(): float
    {
        return max(0, (float) $this->total_bs - $this->paid_amount);
    }

    public function getSaleStatusAttribute(): SaleStatus
    {
        if ($this->paid_amount >= $this->total_bs && $this->total_bs > 0) {
            return SaleStatus::COMPLETED;
        }

        if ($this->paid_amount > 0) {
            return SaleStatus::PARTIAL;
        }

        return SaleStatus::PENDING;
    }

    // ===== METHODS =====

    public function recalculateTotals(): void
    {
        $this->getCalculationService()->recalculateSale($this);
    }
}
