<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkScope extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }

    public function staffUnit(): BelongsTo
    {
        return $this->belongsTo(StaffUnit::class);
    }
}
