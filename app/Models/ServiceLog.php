<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceLog extends Model
{
    protected $fillable = [
        'service_id',
        'old_status_id',
        'new_status_id',
        'user_id',
        'note',
    ];

        // ===== RELACIONES =====

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function oldStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'old_status_id');
    }

    public function newStatus(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'new_status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        // ===== ACCESSORS =====

    public function getTitleAttibute(): string
    {
        $user = $this->user->name ?? 'N/A';
        $oldStatus = $this->oldStatus->name ?? 'N/A';
        $newStatus = $this->newStatus->name ?? 'N/A';
        return "{$user}: {$oldStatus} -> {$newStatus}";
    }
}
