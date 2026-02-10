<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    // ===== RELACIONES =====

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    // ===== SCOPES =====

    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    // ===== ACCESSORS =====

    public function getTitleAttribute(): string
    {
        $type = $this->type->name ?? 'N/A';
        $brand = $this->brand->name ?? 'N/A';
        $model = $this->model ?? 'N/A';
        $serial = $this->serial ?? 'N/A';

        return "{$type} {$brand} {$model} (SN: {$serial})";
    }
}
