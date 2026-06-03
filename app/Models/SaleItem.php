<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SaleItem extends Model
{
    protected $table = 'sale_items';

    protected $fillable = [
        'sale_id',
        'item_type',
        'product_id',
        'variant_combination_id',
        'service_id',
        'combo_id',
        'presentation_id',
        'serial_number',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // ===== RELACIONES =====

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variantCombination(): BelongsTo
    {
        return $this->belongsTo(ProductVariantCombination::class, 'variant_combination_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function combo(): BelongsTo
    {
        return $this->belongsTo(Combo::class);
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(ProductPresentation::class, 'presentation_id');
    }

    // ===== ACCESSORS =====

    public function getSubtotalCalculatedAttribute(): float
    {
        return (float) $this->quantity * (float) $this->unit_price;
    }

    // Nombre para mostrar (producto + variantes)
    public function getDisplayNameAttribute(): string
    {
        $name = $this->product?->name ?? 'Producto';

        if ($this->variantCombination) {
            $name .= ' - '.$this->variantCombination->display_name;
        }

        if ($this->presentation && $this->presentation_id !== $this->product?->presentations?->first()?->id) {
            $name .= ' ('.$this->presentation->code.')';
        }

        return $name;
    }
}
