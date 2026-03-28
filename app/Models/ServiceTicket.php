<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceTicket extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ticket_number',
        'device_id',
        'client_id',
        'workshop_status_id',
        'received_by',
        'technician_id',
        'title',
        'problem_reported',
        'diagnosis',
        'estimated_price',
        'final_price',
        'work_done',
        'delivered_at',
    ];

    protected $casts = [
        'estimated_price' => 'decimal:2',
        'final_price' => 'decimal:2',
        'delivered_at' => 'datetime',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(WorkshopStatus::class, 'workshop_status_id');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(TicketStatusLog::class, 'ticket_id');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(TicketPhoto::class, 'ticket_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(TicketService::class, 'ticket_id');
    }

    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class, 'ticket_id');
    }
}
