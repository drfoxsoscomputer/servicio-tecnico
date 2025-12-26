<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'device_id',
        'technician_id',
        'received_by_user_id',
        'closed_by_user_id',
        'status',
        'problem_reported',
        'diagnosis',
        'work_done',
        'estimated_cost',
        'total_cost',
        'receibed_at',
        'delivered_at',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(Technician::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ServiceOrderItem::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ServiceOrderPhoto::class);
    }
}
