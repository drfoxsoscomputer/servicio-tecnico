<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductStock extends Model
{
    public $timestamps = false;
    
    protected $table = 'product_stocks';

    protected $fillable = [
        'product_id',
        'variant_id',
        'presentation_id',
        'quantity',
        'min_stock_alert',
        'location',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'min_stock_alert' => 'integer',
        'updated_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function presentation(): BelongsTo
    {
        return $this->belongsTo(ProductPresentation::class, 'presentation_id');
    }

    public function scopeByLocation($query, $location)
    {
        return $query->where('location', $location);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'min_stock_alert')
                    ->where('min_stock_alert', '>', 0);
    }
}
