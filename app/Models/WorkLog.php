<?php

namespace App\Models;

use App\Helpers\WorkLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
// use Staudenmeir\EloquentEagerLimit\Relations\HasOne;

class WorkLog extends Model
{
    use HasFactory, SoftDeletes;

    // protected $with = ['submissions:number'];

    // TODO CHECK IF THERES A PROBLEM WITH SUBMISSION SEQUENCE
    // - The sequence needs to have reject in the middle and only ONE accept in the end
    // - Can use oncreate submission observer/listener
    // === === ===
    // Example (Pass)
    // Sub 1 <=> Reject
    // Sub 2 <=> Reject
    // Sub 3 <=> Accept
    // === === ===
    // Example (Fail)
    // Sub 1 <=> Reject
    // Sub 2 <=> Accept
    // Sub 3 <=> Accept

    protected $casts = [
        'started_at' => 'date',
        'expected_at' => 'datetime',
        // 'time_left' => 'date',
        // 'submitted_at' => 'date',
    ];

    protected $guarded = [];

    // Status

    // ONGOING      0
    // SUBMITTED    1
    // TOREVISE     2
    // COMPLETED    3
    // CLOSED       4

    public function setStatusOngoing(): WorkLog { $this->status = WorkLogHelper::ONGOING; return $this; }
    public function setStatusSubmitted(): WorkLog { $this->status = WorkLogHelper::SUBMITTED; return $this; }
    public function setStatusToRevise(): WorkLog { $this->status = WorkLogHelper::TOREVISE; return $this; }
    public function setStatusCompleted(): WorkLog { $this->status = WorkLogHelper::COMPLETED; return $this; }
    public function setStatusClosed(): WorkLog { $this->status = WorkLogHelper::CLOSED; return $this; }
    public function setArchive(): WorkLog { $this->has_archived = true; return $this; }
    public function setUnarchive(): WorkLog { $this->has_archived = false; return $this; }

    public function workScopeTitle (): string {
        if ($this->is_workscope_custom)
            return $this->custom_workscope_title;
        return $this->workScope->title;
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function workScope(): BelongsTo
    {
        return $this->belongsTo(WorkScope::class);
    }

    // Submission place starts

    public function submissions(): HasMany {
        return $this->hasMany(Submission::class);
    }

    public function latestSubmission(): HasOne {
        return $this->hasOne(Submission::class)->orderBy('number', 'desc')->limit(1);
    }

    public function isLatestSubmissionEvaluated(): bool {
        return $this->latestSubmission->evaluator != null;
    }

    // Submission Place ends

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    // protected static function booted(): void
    // {
    //     static::creating(function (WorkLog $workLog) {
    //         // WorkScope from database should be chosen if custom workscope title is not filled
    //         if (!($workLog->custom_workscope_title == null || !$workLog->workScope))
    //             return false;

    //         $workLog->is_workscope_custom = false;
    //         if ($workLog->custom_workscope_title) {
    //             $workLog->is_workscope_custom = true;
    //         }
    //     });

    //     static::created(function (WorkLog $workLog) {
    //         $workLog->status = WorkLogHelper::ONGOING;
    //         $workLog->save();
    //     });
    // }

    // public function scopeWithWhereHas($query, $relation, $constraint){
    //     return $query->whereHas($relation, $constraint)
    //     ->with([$relation => $constraint]);
    // }
}
