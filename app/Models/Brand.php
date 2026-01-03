<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'is_active'
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }
}
