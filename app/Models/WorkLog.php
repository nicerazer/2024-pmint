<?php

namespace App\Models;

use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Helpers\WorkLogHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

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

    private function setStatusOngoing(): WorkLog { $this->status = WorkLogHelper::ONGOING; return $this; }
    private function setStatusSubmitted(): WorkLog { $this->status = WorkLogHelper::SUBMITTED; return $this; }
    private function setStatusToRevise(): WorkLog { $this->status = WorkLogHelper::TOREVISE; return $this; }
    private function setStatusCompleted(): WorkLog { $this->status = WorkLogHelper::COMPLETED; return $this; }
    private function setStatusClosed(): WorkLog { $this->status = WorkLogHelper::CLOSED; return $this; }
    private function setArchive(): WorkLog { $this->has_archived = true; return $this; }
    private function setUnarchive(): WorkLog { $this->has_archived = false; return $this; }

    public function isOngoing(): bool { return $this->status == WorkLogHelper::ONGOING; }
    public function isSubmitted(): bool { return $this->status == WorkLogHelper::SUBMITTED; }
    public function isToRevise(): bool { return $this->status == WorkLogHelper::TOREVISE; }
    public function isCompleted(): bool { return $this->status == WorkLogHelper::COMPLETED; }
    public function isClosed(): bool { return $this->status == WorkLogHelper::CLOSED; }

    // public function evaluator(): BelongsTo {
    //     return $this->belongsTo(User::class, 'sub_evaluator_id', 'id');
    // }

    public function submitable (): bool {
        return
        !$this->submissions()->count() || (
            $this->latestSubmission && ($this->latestSubmission->evaluated_at && !$this->latestSubmission->is_accept)
        );
        // return $this->latestSubmission && $this->latestSubmission->evaluated_at && $this->latestSubmission->is_accept;
    }

    public function evaluatable (): bool {
        // TODO: FOR WHAT?? but something is wrong here please take a look dont leave it
        return Auth::user()->currentlyIs(UserRoleCodes::EVALUATOR_1) &&
        $this->latestSubmission && // Makes sure this exists tzhen can check deeper
        !$this->latestSubmission->evaluated_at
        ;

        // return $this->latestSubmission &&
        //     (!$this->latestSubmission->evaluated_at ||
        //     $this->latestSubmission->evaluated_at && $this->latestSubmission->is_accept);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function moveToReviewed(): bool {
        // $this->status
        $this->status = WorkLogCodes::REVIEWED;
        return true;
    }

    public function authorName(): string
    {
        return $this->author->name;
    }

    public function unit()
    {
        if ($this->wrkscp_is_main)
            return $this->workScopeMain->staffUnit();
        return $this->workScopeAltUnit();
    }

    public function workScopeTitle(): string
    {
        if ($this->wrkscp_is_main)
            return $this->workScopeMain->title;
        return $this->wrkscp_alt_title;
    }

    public function workScopeAltUnit(): BelongsTo
    {
        return $this->belongsTo(StaffUnit::class, 'wrkscp_alt_unit_id');
    }

    public function workScopeMain(): BelongsTo
    {
        return $this->belongsTo(WorkScope::class, 'wrkscp_main_id');
    }

    public function workScopeAlt(): string {
        return $this->wrkscp_alt_title;
    }

    // Submission place starts

    public function submissions(): HasMany {
        return $this->hasMany(Submission::class)->orderByDesc('number');
    }

    public function latestSubmission(): HasOne {
        return $this->hasOne(Submission::class)->orderBy('number', 'desc')->limit(1);
    }

    public function latestSubmissionBody(): string {
        return $this->latestSubmission ?
            $this->latestSubmission->body :
            '⚠️ Tiada penghantaran ⚠️';
    }

    public function isLatestSubmissionEvaluated(): bool {
        return $this->latestSubmission->evaluator != null;
    }

    // Submission Place ends

    public function documents(): MorphMany
    {
        return $this->morphMany(Document::class, 'documentable');
    }


    /**
     * Undocumented function
     *
     * @param \Carbon\Carbon $queried_date
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function indexQuery(Carbon $queried_date): \Illuminate\Database\Eloquent\Builder
    {
        $latestSubmissions = DB::table('submissions as t1')
            ->select(
                DB::raw('DISTINCT t1.work_log_id AS sub_fk_id'),
                DB::raw('MAX(t1.number) AS sub_number'),
                DB::raw('MAX(t1.id) AS sub_id'),
                DB::raw('MAX(t1.is_accept) AS sub_is_accept'),
                DB::raw('MAX(t1.evaluator_id) AS sub_evaluator_id'),
                // DB::raw('MAX(t1.evaluated_at) AS sub_evaluated_at'),
                DB::raw('MAX(t1.submitted_at) AS sub_submitted_at')
            )->join(DB::raw('submissions AS t2'), function (JoinClause $join) {
                $join->on('t2.id', '=', 't1.id');
                $join->on('t2.number', '=', DB::raw('(SELECT MAX(number) FROM submissions AS t3 WHERE t3.id = t1.id)'));
            })->groupBy('sub_fk_id');

        return WorkLog::query()
            ->leftJoin('work_scopes','work_logs.wrkscp_main_id', '=', 'work_scopes.id')
            ->join('users','users.id', '=', 'work_logs.author_id')
            ->leftJoinSub($latestSubmissions, 'latest_submission', function (JoinClause $join) {
                $join->on('sub_fk_id', '=', 'work_logs.id');
            })
            ->leftJoin(DB::raw('users AS evaluator'), 'evaluator.id', '=', 'sub_evaluator_id')
            ->select('work_logs.*', 'users.name', 'work_scopes.title',
                'latest_submission.*',
                DB::raw('`evaluator`.`name` as `evaluator_name`'), DB::raw('`evaluator`.`id` as `evaluator_id`')
            )
            // Excluding their own worklogs???
            ->when(!auth()->user()->isAdmin(), function (Builder $q) {
                $q->where('work_logs.author_id', [
                        UserRoleCodes::EVALUATOR_1 => '!=',
                        UserRoleCodes::EVALUATOR_2 => '!=',
                        UserRoleCodes::STAFF => '=',
                    ][session('selected_role_id')],
                    auth()->user()->id);
            })
            // // Date rules START
            ->where(function (Builder $q) use ($queried_date) {
                $q->whereNotNull('work_logs.started_at')
                ->whereRaw('YEAR(work_logs.started_at) = ' . $queried_date->format('Y'))
                ->whereRaw('MONTH(work_logs.started_at) = ' . $queried_date->format('m'));
            })
            // ->where(function (Builder $q) use ($queried_date) {
            //     $q->where(function (Builder $q) use ($queried_date) {
            //         $q->whereNotNull('work_logs.expected_at')
            //         ->whereRaw('YEAR(work_logs.expected_at) >= ' . $queried_date->format('Y'))
            //         ->whereRaw('MONTH(work_logs.expected_at) >= ' . $queried_date->format('m'));
            //     });
            //     // ->orWhere(function (Builder $q) use ($queried_date) {
            //     //     $q->whereNotNull('submissions_submitted_at')
            //     //     ->whereRaw('YEAR(submissions_submitted_at) >= ' . $queried_date->format('Y'))
            //     //     ->whereRaw('MONTH(submissions_submitted_at) >= ' . $queried_date->format('m'));
            //     // });
            // })
            // Date rules END

            // Rules Start
            // ->when(auth()->user()->currentlyIs(UserRoleCodes::STAFF), function (Builder $q) {
            //     $q->where('author_id', auth()->user()->id);
            // })
            // ->when(! auth()->user()->currentlyIs(UserRoleCodes::STAFF), function (Builder $q) {
            //     $q->whereNot('author_id', auth()->user()->id);
            // })
            // Only show submitted submissions for evaluator 2
            ->when(auth()->user()->currentlyIs(UserRoleCodes::EVALUATOR_2), function (Builder $query) {
                $query->whereNotNull('sub_fk_id')
                ->where('sub_is_accept', true);
            });
    }

    protected static function booted(): void
    {
        static::creating(function (WorkLog $worklog) {
            Log::debug('Creating worklog: Attempt');

            if (! $worklog->wrkscp_is_main && ! $worklog->wrkscp_alt_unit_id) {
                // When using custom title, alt unit id cannot be null
                Log::warning('ERROR CREATING WORKLOG');
                Log::warning('=== Alt but wrkscp_alt_unit_id was not set');
                return false;
            } else if (! $worklog->wrkscp_is_main && WorkScope::where('id', $worklog->wrkscp_alt_unit_id)->count()) {
                // When using custom title, staff section cannot be null
                Log::warning('ERROR CREATING WORKLOG');
                Log::warning('=== Alt but wrkscp_alt_unit_id does not exist in database');
                return false;
            } else if (! $worklog->wrkscp_is_main && ! $worklog->wrkscp_alt_title) {
                // When using custom title, staff section cannot be null
                Log::warning('ERROR CREATING WORKLOG');
                Log::warning('=== Alt but wrkscp_alt_title was not set');
                return false;
            } else if ($worklog->wrkscp_is_main && !$worklog->wrkscp_main_id) {
                // WorkScope from database should be chosen if custom workscope title is not filled
                Log::warning('ERROR CREATING WORKLOG');
                Log::warning('=== Main but wrkscp_main_id was not set');
                return false;
            }

            if ($worklog->wrkscp_is_main)
                $worklog->wrkscp_alt_unit_id = $worklog->workScopeMain->staffUnit->id;
            else {
                $worklog->wrkscp_alt_unit_id = auth()->user()->unit->id;
            }
            Log::warning('Creating worklog: Success');
        });

        static::updating(function (WorkLog $workLog) {
            // Auto set the latest submission to retreive current user for id
            // when it is currently on evaluator 1
            if (auth()->user()->isEvaluator1()) {
                $workLog->latestSubmission()->evaluator_id = auth()->user()->id;
                if ($workLog->latestSubmission()->evaluated_at) {
                    if ($workLog->latestSubmission()->is_accept)
                        $workLog->status = false;
                    else
                        $workLog->status = false;
                }
            }
        });
    }

    // public function scopeWithWhereHas($query, $relation, $constraint){
    //     return $query->whereHas($relation, $constraint)
    //     ->with([$relation => $constraint]);
    // }
}
