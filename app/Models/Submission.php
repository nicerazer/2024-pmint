<?php

namespace App\Models;

use App\Helpers\WorkLogCodes;
use App\Helpers\WorkLogHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

// use Staudenmeir\EloquentEagerLimit\HasEagerLimit;

class Submission extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $guarded = [];


    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes([
                'image/jpg', 'image/jpeg', 'image/png', 'image/gif',
            ]);
        $this->addMediaCollection('documents')
            ->acceptsMimeTypes([
                'text/csv', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/rtf', 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                'application/gzip', 'application/pdf', 'application/vnd.rar', 'application/zip', 'application/x-7z-compressed'
            ]);
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Manipulations::FIT_CROP, 300, 300)
    //         ->nonQueued();
    // }

    public function worklog(): BelongsTo {
        return $this->belongsTo(WorkLog::class, 'work_log_id');
    }

    public function evaluator(): BelongsTo {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    protected static function booted(): void
    {
        static::creating(function (Submission $submission) {
            Log::notice('Submission creating: attempt');
            if (
                // Evaluator 1 must be set when creating submissions
                !$submission->worklog->unit->staffSection->evaluator1 ||
                // 1. When there's one and more submissions (If never made submission can proceed), and
                // 2. The latest hasn't been evaluated, cancel the submission, throw error
                $submission->worklog->submissions()->count() > 0 && $submission->worklog->latestSubmission->evaluator == null
            ) {
                if (!$submission->worklog->unit->staffSection->evaluator1)
                    Log::error('There is no evaluator assigned');
                if(!($submission->worklog->submissions()->count() > 0 && $submission->worklog->latestSubmission->evaluator)) {
                    Log::error('The latest submission hasn\'t been evaluated yet. Do that first.');
                }
                return false;
            }
            $submissionCount = $submission->worklog->submissions()->count();
            $submission->number = $submissionCount + 1;
            $submission->submitted_at = now();
            Log::notice('Submission creating: success');
        });

        static::created(function (Submission $submission) {
            Log::notice('Submission created: attempt - being created with id of :' . $submission->id );
            if ($submission->number == 1) {
                $parentWorkLog = $submission->worklog;
                $parentWorkLog->status = $submission->is_accept ? WorkLogHelper::COMPLETED : WorkLogHelper::SUBMITTED;
                $parentWorkLog->save();
            } else {
                $parentWorkLog = $submission->worklog;
                $parentWorkLog->status = $submission->is_accept ? WorkLogHelper::COMPLETED : WorkLogHelper::TOREVISE;
                $parentWorkLog->save();
            }
            Log::notice('Submission created: success');

        });

        static::updating(function (Submission $submission) {
            Log::info('Model: submission');
            Log::info('Listener: updating');
            if ($submission->evaluated_at) {
                $submission->evaluator_id = auth()->user()->id;
                Log::info('Position: there is evaluated_at');
                $submission->workLog->status = $submission->is_accept ? WorkLogCodes::COMPLETED : WorkLogCodes::TOREVISE;
                $submission->workLog->save();
            }
        });

    }
}
