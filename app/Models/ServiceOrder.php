<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'priority',
        'receibed_at',
        'delivered_at',
    ];
}
