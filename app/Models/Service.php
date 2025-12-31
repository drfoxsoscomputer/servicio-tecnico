<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'device_id',
        'status_id',
        'received_by_user_id',
        'technician_id',
        'closed_by_user_id',
        'payment_method_id',
        'problem_reported',
        'diagnosis',
        'work_done',
        'total_cost',
        'received_at',
        'delivered_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // public function receivedBy(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'received_by_user_id');
    // }

    // public function closedBy(): BelongsTo
    // {
    //     return $this->belongsTo(User::class, 'closed_by_user_id');
    // }

    // public function paymentMethod(): BelongsTo
    // {
    //     return $this->belongsTo(PaymentMethod::class);
    // }

    public function logs(): HasMany
    {
        return $this->hasMany(ServiceLog::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(ServicePhoto::class);
    }

    public function parts(): HasMany
    {
        return $this->hasMany(Part::class);
    }


}
