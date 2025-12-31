<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'document_id',
        'email',
        'phone',
        'address',
    ];

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
