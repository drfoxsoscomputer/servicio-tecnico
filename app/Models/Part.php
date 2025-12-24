<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Part extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'stock',
        'cost_price',
        'sale_price',
    ];

    public function serviceOrderItem(): HasMany
    {
        return $this->hasMany(ServiceOrderItem::class);
    }
}
