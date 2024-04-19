<?php

namespace App\Livewire\Home;

use App\Helpers\UserRoleCodes;
use App\Helpers\WorkLogCodes;
use App\Models\StaffSection;
use App\Models\Submission;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public Carbon $selected_month;
    public $worklog_count_in_a_month_by_statuses;

    // ADMIN AREA
    public $model_context = 'staff_section';
    public $model_id = -1;
    public $model_is_creating = false;
    public $staff_sections;

    // #[Renderless]
    #[On('update_month')]
    public function updateTheMonth(string $date) {
        // Log::debug($this->selected_month);
        $this->selected_month = new Carbon($date);
        // $this->selected_month = $date;
        Log::debug('Incoming : '.$date);
        Log::debug('Parent : '. $this->selected_month);
        // Log::debug('AAAAAA');
    }

    public function mount() {
        if (
            session('selected_role_id') == UserRoleCodes::EVALUATOR_1 ||
            session('selected_role_id') == UserRoleCodes::EVALUATOR_2 ||
            session('selected_role_id') == UserRoleCodes::STAFF
        ) {
            $this->selected_month = now();
            $this->worklog_count_in_a_month_by_statuses = [];
            $this->generateStats();
        } else {
            $this->model_context = session('admin_model_context') ? session('admin_model_context') : 'staff';
            $this->model_id = session('admin_model_id') ? session('admin_model_id') : -1;
            $this->model_is_creating = session('admin_is_creating') ? session('admin_is_creating') : false;
        }
    }

    #[Layout('layouts.app')]
    public function render()
    {
        if (
            session('selected_role_id') == UserRoleCodes::EVALUATOR_1 ||
            session('selected_role_id') == UserRoleCodes::EVALUATOR_2 ||
            session('selected_role_id') == UserRoleCodes::STAFF
        ) {
            $this->generateStats();
            return view('livewire.home.index');
        }

        $this->staff_sections = StaffSection::query()->select('id', 'name')->get();
        return view('livewire.admin.home');
    }

    public function generateStats()
    {
        Log::debug('HomeIndex: Generating stats...');
        Log::debug('HomeIndex: Generating stats: ' . $this->selected_month);
        $latestSubmissions = Submission::select(
            DB::raw('submissions.work_log_id AS wl_id_fk'),
            DB::raw('submissions.is_accept AS submissions_is_accept'),
            DB::raw('submissions.evaluated_at AS submissions_evaluated_at'),
            DB::raw('submissions.submitted_at AS submissions_submitted_at'))
            ->orderBy('number', 'desc')
            ->limit(1);

        $res = WorkLog::query()
        ->select(DB::raw('COUNT(id) AS count'), 'status')
        // Rules Start
        ->when(auth()->user()->currentlyIs(UserRoleCodes::STAFF), function (Builder $q) {
            $q->where('author_id', auth()->user()->id);
        })
        ->when(! auth()->user()->currentlyIs(UserRoleCodes::STAFF), function (Builder $q) {
            $q->whereNot('author_id', auth()->user()->id);
        })
        ->when(auth()->user()->currentlyIs(UserRoleCodes::EVALUATOR_2), function (Builder $query) {
            $query->whereNotNull('wl_id_fk')
            ->where('submissions_is_accept', TRUE);
        })

        // Date rules START
        ->where(function (Builder $q) {
            $q->whereNotNull('work_logs.started_at')
            ->whereRaw('YEAR(work_logs.started_at) <= ' . $this->selected_month->format('Y'))
            ->whereRaw('MONTH(work_logs.started_at) <= ' . $this->selected_month->format('m'));
        })
        ->where(function (Builder $q) {
            $q->where(function (Builder $q) {
                $q->whereNotNull('work_logs.expected_at')
                ->whereRaw('YEAR(work_logs.expected_at) >= ' . $this->selected_month->format('Y'))
                ->whereRaw('MONTH(work_logs.expected_at) >= ' . $this->selected_month->format('m'));
            })
            ->orWhere(function (Builder $q) {
                $q->whereNotNull('submissions_submitted_at')
                ->whereRaw('YEAR(submissions_submitted_at) >= ' . $this->selected_month->format('Y'))
                ->whereRaw('MONTH(submissions_submitted_at) >= ' . $this->selected_month->format('m'));
            });
        })
        // Date rules END

        ->leftJoinSub($latestSubmissions, 'latest_submission_id', function (JoinClause $join) {
            $join->on('work_logs.id', '=', 'wl_id_fk');
        })
        ->groupBy('status')->pluck('count', 'status');

        $all_count =
            $res->get(WorkLogCodes::ONGOING) +
            $res->get(WorkLogCodes::SUBMITTED) +
            $res->get(WorkLogCodes::TOREVISE) +
            $res->get(WorkLogCodes::COMPLETED) +
            $res->get(WorkLogCodes::CLOSED) +
            $res->get(WorkLogCodes::REVIEWED) +
            $res->get(WorkLogCodes::NOTYETEVALUATED);

            // dd($res);

        $this->worklog_count_in_a_month_by_statuses = [
            WorkLogCodes::ALL => $all_count,
            WorkLogCodes::ONGOING => $res->get(WorkLogCodes::ONGOING) ?: 0,
            WorkLogCodes::SUBMITTED => $res->get(WorkLogCodes::SUBMITTED) ?: 0,
            WorkLogCodes::TOREVISE => $res->get(WorkLogCodes::TOREVISE) ?: 0,
            WorkLogCodes::COMPLETED => $res->get(WorkLogCodes::COMPLETED) ?: 0,
            WorkLogCodes::CLOSED => $res->get(WorkLogCodes::CLOSED) ?: 0,
            WorkLogCodes::REVIEWED => $res->get(WorkLogCodes::REVIEWED) ?: 0,
            WorkLogCodes::NOTYETEVALUATED => $res->get(WorkLogCodes::NOTYETEVALUATED) ?: 0,
        ];
    }

}
