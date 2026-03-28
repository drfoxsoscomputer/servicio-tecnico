<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketStatusLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'old_status_id',
        'new_status_id',
        'user_id',
        'notes',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(ServiceTicket::class, 'ticket_id');
    }

    public function oldStatus(): BelongsTo
    {
        return $this->belongsTo(WorkshopStatus::class, 'old_status_id');
    }

    public function newStatus(): BelongsTo
    {
        return $this->belongsTo(WorkshopStatus::class, 'new_status_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
