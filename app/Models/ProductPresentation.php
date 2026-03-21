<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPresentation extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'units',
        'is_default',
    ];

    protected $casts = [
        'units' => 'integer',
        'is_default' => 'boolean',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
}
