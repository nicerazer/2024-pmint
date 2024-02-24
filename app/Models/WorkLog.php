<?php

namespace App\Models;

use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Helpers\WorkLogHelper;
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

    public static function count($status, $selected_month = NULL): int {
        // $selected_month = $selected_month ?? now();
        $selected_month = now()->addMonth();
        $current_user = auth()->user();
        return (new static)::when($status != WorkLogCodes::ALL, function (Builder $q) use ($status) {
            if ($status == WorkLogCodes::NOTYETEVALUATED)  {
                $q->where('status', WorkLogCodes::ONGOING)
                ->orWhere('status', WorkLogCodes::SUBMITTED)
                ->orWhere('status', WorkLogCodes::TOREVISE);
            } else
                $q->where('status', $status);
        })
        // ->where('started_at', '>', $selected_month->toDateTimeString())
        ->where(function (Builder $q) use ($selected_month) {
            $q->where(function (Builder $q) use ($selected_month) {
                $q->whereNotNull('expected_at')
                ->whereRaw('YEAR(expected_at) <= ' . $selected_month->format('Y'))
                ->whereRaw('MONTH(expected_at) <= ' . $selected_month->format('m'));
                // ->whereYear('expected_at', '2024');
            })
            ->orWhere(function (Builder $q) use ($selected_month) {
                // $q->whereNotNull('latestSubmission_select.evaluated_at')
                // ->whereRaw('YEAR(latestSubmission_select.evaluated_at) <= ' . $selected_month->format('Y'))
                // ->whereRaw('MONTH(latestSubmission_select.evaluated_at) <= ' . $selected_month->format('m'));

            //     // $q->whereNotNull('latestSubmission_select')
            //     // ->where('latestSubmission_select', '>', $selected_month->toDateString());
            });
        })
        ->when($current_user->isStaff(), function (Builder $q) use ($current_user) {
            return $q->where('author_id', $current_user->id);
        })
        ->addSelect([
            'latestSubmission_select' => Submission::query()
                ->orderByDesc('number')
                ->whereColumn('work_logs.id', 'work_log_id')
                ->take(1)
        ])
        ->count();
    }

    public function workScopeTitle (): string {
        if ($this->workScope)
            return $this->workScope->title;
        return $this->custom_workscope_title ?: 'Skop tidak diset!';
    }

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
        $this->latestSubmission && // Makes sure this exists then can check deeper
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

    public function section(): BelongsTo
    {
        return $this->belongsTo(StaffSection::class, 'staff_section_id');
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

    public static function indexQuery($queried_date): \Illuminate\Database\Eloquent\Builder
    {
        $latestSubmissions = Submission::select(
            DB::raw('submissions.work_log_id AS wl_id_fk'),
            DB::raw('submissions.is_accept AS submissions_is_accept'),
            DB::raw('submissions.evaluated_at AS submissions_evaluated_at'),
            DB::raw('submissions.submitted_at AS submissions_submitted_at'))
            ->orderBy('number', 'desc')
            ->limit(1);

        return WorkLog::query()
            ->leftJoin('work_scopes','work_logs.work_scope_id', '=', 'work_scopes.id')
            // ->leftJoin('submissions','work_logs.id', '=', 'submissions.wor_log_id')
            ->join('users','users.id', '=', 'work_logs.author_id')
            ->where('work_logs.author_id', [
                    UserRoleCodes::EVALUATOR_1 => '!=',
                    UserRoleCodes::EVALUATOR_2 => '!=',
                    UserRoleCodes::STAFF => '=',
                ][session('selected_role_id')],
                auth()->user()->id)
            ->where(function (Builder $q) use ($queried_date) {
                $q->whereNotNull('work_logs.started_at')
                ->whereRaw('YEAR(work_logs.started_at) <= ' . $queried_date->format('Y'))
                ->whereRaw('MONTH(work_logs.started_at) <= ' . $queried_date->format('m'));
            })
            ->where(function (Builder $q) use ($queried_date) {
                $q->where(function (Builder $q) use ($queried_date) {
                    $q->whereNotNull('work_logs.expected_at')
                    ->whereRaw('YEAR(work_logs.expected_at) >= ' . $queried_date->format('Y'))
                    ->whereRaw('MONTH(work_logs.expected_at) >= ' . $queried_date->format('m'));
                })
                ->orWhere(function (Builder $q) use ($queried_date) {
                    $q->whereNotNull('submissions_submitted_at')
                    ->whereRaw('YEAR(submissions_submitted_at) >= ' . $queried_date->format('Y'))
                    ->whereRaw('MONTH(submissions_submitted_at) >= ' . $queried_date->format('m'));
                })
                ;
            })
            ->when()
            // Only show submitted submissions
            ->when(session('selected_role_id') == UserRoleCodes::EVALUATOR_2, function (Builder $query) {
                    $query->whereNotNull('wl_id_fk')
                    ->where('submissions_is_accept', TRUE);
            })
            ->select('work_logs.id', 'users.name', 'work_scopes.title')
            ->leftJoinSub($latestSubmissions, 'latest_submission_id', function (JoinClause $join) {
                $join->on('work_logs.id', '=', 'wl_id_fk');
            })
            ->select('work_logs.*', 'users.name', 'work_scopes.title');
    }

    protected static function booted(): void
    {
        static::creating(function (WorkLog $worklog) {
            Log::warning('Creating worklog: Attempt');
            if (
                // WorkScope from database should be chosen if custom workscope title is not filled
                (!$worklog->custom_workscope_title && !$worklog->workScope) ||
                // When using custom title, staff section cannot be null
                ($worklog->custom_workscope_title && !$worklog->staff_section_id)
            ) {
                Log::warning('Either all workscope setting is absoluetly missing, or staff section null when using custom title');
                return false;
            }
            if ($worklog->workScope)
                $worklog->staff_section_id = $worklog->workScope->staffUnit->staffSection->id;
            // if ($worklog->custom_workscope_title) {
            //     $worklog->staff_section_id = auth()->user()
            // }
            Log::warning('Creating worklog: Success');
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
