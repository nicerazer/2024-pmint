<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffSection extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function worklogs(): BelongsTo
    {
        return $this->belongsTo(StaffSection::class);
    }

    public function staffUnits() : HasMany
    {
        return $this->hasMany(StaffUnit::class);
    }

    public function evaluator1() : BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator1_id');
    }

    public function evaluator2() : BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluator2_id');
    }

    public function memberCount() : int
    {
        return $this->join('staff_units', 'staff_sections.id', '=', 'staff_units.staff_section_id')
            ->join('users', 'staff_units.id', '=', 'users.staff_unit_id')
            ->distinct()
            ->count();
    }
}
