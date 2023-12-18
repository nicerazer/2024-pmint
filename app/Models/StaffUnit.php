<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StaffUnit extends Model
{
    public function staffSection() : BelongsTo
    {
        return $this->belongsTo(StaffSection::class);
    }

    public function staffs()
    {
        return $this->hasMany(User::class, 'staff_unit_id');
    }

    public function staffCount()
    {
        return $this->staffs()->count();
    }

    use HasFactory;
}
