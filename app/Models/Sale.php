<?php

namespace App\Models;

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
        'client_id',
        'user_id',
        'service_id',
        'type',
        'net_amount',
        'discount_type',
        'discount_value',
        'discount_amount',
        'tax_percentage',
        'tax_amount',
        'total_amount',
        'status',
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

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    // ===== SCOPES =====

    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    // ===== ACCESSORS =====

    public function getTitleAttribute(): string
    {
        $client = $this->client->name ?? 'N/A';
        $doc = $this->client->document_id ?? 'N/A';

        return "Nota #{$this->id} - {$client} {$doc} - ({$this->status})";
    }

    public function getSubtotalAttribute(): float
    {
        return $this->getCalculationService()->calculateNetAmount($this);
    }

    public function getDiscountAmountAttribute(): float
    {
        return $this->getCalculationService()->calculateDiscountAmount($this, $this->subtotal);
    }

    public function getTaxableAmountAttribute(): float
    {
        return $this->subtotal - $this->discount_amount;
    }

    public function getTaxAmountAttribute(): float
    {
        return $this->getCalculationService()->calculateTaxAmount($this, $this->taxable_amount);
    }

    public function getTotalAmountAttribute(): float
    {
        return $this->taxable_amount + $this->tax_amount;
    }

    public function getPaidAmountAttribute(): float
    {
        return $this->payments->sum('amount');
    }

    public function getPendingAmountAttribute(): float
    {
        return max(0, $this->total_amount - $this->paid_amount);
    }

    public function getSaleStatusAttribute(): string
    {
        if ($this->paid_amount >= $this->total_amount && $this->total_amount > 0) {
            return 'paid';
        }

        if ($this->paid_amount > 0) {
            return 'partial';
        }

        return $this->status ?? 'pending';
    }

    // ===== METHODS =====

    public function recalculateTotals(): void
    {
        $this->getCalculationService()->recalculateSale($this);
    }
}
