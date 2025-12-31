<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'device_id',
        'status_id',
        'technician_id',
        'received_by_user_id',
        'closed_by_user_id',
        'payment_method_id',
        'problem_reporded',
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
}
