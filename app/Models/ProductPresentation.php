<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductPresentation extends Model
{
    protected $fillable = [
        'product_id',
        'code',
        'description',
        'units',
    ];

    protected $casts = [
        'units' => 'integer',
    ];

    public function setCodeAttribute($value): void
    {
        $this->attributes['code'] = strtoupper($value);
    }

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
