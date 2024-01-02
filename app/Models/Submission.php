<?php

namespace App\Models;

use App\Helpers\WorkLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
// use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Submission extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public function worklog(): BelongsTo {
        return $this->belongsTo(WorkLog::class, 'work_log_id');
    }

    public function evaluator(): BelongsTo {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function booted(): void
    {
        static::creating(function (Submission $submission) {
            Log::notice('A new submission is being added');
            if (
                // Evaluator 1 must be set when creating submissions
                !$submission->worklog->author->evaluator1 ||
                // 1. When there's one and more submissions (If never made submission can proceed), and
                // 2. The latest hasn't been evaluated, cancel the submission, throw error
                $submission->worklog->submissions()->count() > 0 && $submission->worklog->latestSubmission->evaluator == null
            ) {
                if (!$submission->worklog->author->evaluator1)
                Log::notice('There is no evaluator assigned');
                if(!($submission->worklog->submissions()->count() > 0 && $submission->worklog->latestSubmission->evaluator)) {
                    Log::notice('The latest submission hasn\'t been evaluated yet. Do that first.');
                    Log::notice($submission->worklog->submissions()->count() > 0 && $submission->worklog->latestSubmission->evaluator == null ? 'yeaaa' : 'noooo');
                }
                return false;
            }

            $submissionCount = $submission->worklog->submissions()->count();
            $submission->number = $submissionCount + 1;
        });

        static::created(function (Submission $submission) {
            Log::notice('Submission is being created with id of :' . $submission->id );

            $parentWorkLog = $submission->worklog;
            $parentWorkLog->status = WorkLogHelper::ONGOING;
            $parentWorkLog->save();
        });
    }
}
