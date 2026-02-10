<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'document_id',
        'phone',
        'email',
        'address',
        'notes',
    ];

    // ===== RELACIONES =====

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    // ===== SCOPES =====

    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }

    // ===== ACCESSORS =====

    public function getTitleAttribute(): string
    {
        // $doc = $this->document_id ?? 'N/A';
        // return "{$this->name} ({$doc})";
        if ($this->document_id) {
            return "{$this->name} ({$this->document_id})";
        }
        return $this->name;
    }
}
