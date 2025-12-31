<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'type_id',
        'brand_id',
        'model',
        'serial',
        'access_password',
        'notes',
    ];
}
