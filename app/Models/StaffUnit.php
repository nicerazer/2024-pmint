<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffUnit extends Model
{
    protected $guarded = [];

    public function staffSection() : BelongsTo
    {
        return $this->belongsTo(StaffSection::class);
    }

    public function workScopes() : HasMany
    {
        return $this->hasMany(WorkScope::class);
    }

    public function staffs() : HasMany
    {
        return $this->hasMany(User::class, 'staff_unit_id', 'id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    // public function evaluator1s() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'evaluator1_staffunit', 'staff_unit_id', 'user_id');
    // }

    // public function evaluator2s() : BelongsToMany
    // {
    //     return $this->belongsToMany(User::class, 'evaluator2_staffunit', 'staff_unit_id', 'user_id');
    // }

    public function staffCount()
    {
        return $this->staffs()->count();
    }

    use HasFactory;
}
