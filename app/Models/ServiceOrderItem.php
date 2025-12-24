<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_order_id',
        'part_id',
        'quantity',
        'unit_price',
    ];
}
