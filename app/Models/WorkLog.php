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
use Spatie\MediaLibrary\HasMedia;

// use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
// use Staudenmeir\EloquentEagerLimit\Relations\HasOne;

class WorkLog extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

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
        if ($this->workScope)
            return $this->workScope->title;
        return $this->custom_workscope_title ?: 'Skop tidak diset!';
    }

    public function submitable (): bool {
        return $this->latestSubmission && $this->latestSubmission->evaluated_at && $this->latestSubmission->is_accept;
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
        return $this->hasMany(Submission::class)->orderByDesc('number');
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

    protected static function booted(): void
    {
        static::creating(function (WorkLog $worklog) {
            if (
                // WorkScope from database should be chosen if custom workscope title is not filled
                (!$worklog->custom_workscope_title && !$worklog->workScope) ||
                // When using custom title, staff section cannot be null
                ($worklog->custom_workscope_title && !$worklog->staff_section_id)
            )
                return false;
            if ($worklog->workScope)
                $worklog->staff_section_id = $worklog->workScope->workUnit->staffSection->id;
            // if ($worklog->custom_workscope_title) {
            //     $worklog->staff_section_id = auth()->user()
            // }
        });

        // static::created(function (WorkLog $workLog) {
        //     $workLog->status = WorkLogHelper::ONGOING;
        //     $workLog->save();
        // });
    }

    // public function scopeWithWhereHas($query, $relation, $constraint){
    //     return $query->whereHas($relation, $constraint)
    //     ->with([$relation => $constraint]);
    // }
}
