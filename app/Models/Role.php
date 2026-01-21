<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public function getDisplayNameAttribute(): string
    {
        return match ($this->name) {
            'super_admin' => 'Super Admin',
            'admin' => 'Administrador',
            'technician' => 'Técnico',
            'cashier' => 'Cajero',
            default => $this->name,
        };
    }
}
