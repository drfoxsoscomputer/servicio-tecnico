<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'color',
    ];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ServiceLog::class, 'new_staus_id');
    }
}
