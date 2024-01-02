<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    public $incrementing = true;

    public function users() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function roles() {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
