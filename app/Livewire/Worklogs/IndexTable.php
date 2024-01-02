<?php

namespace App\Livewire\WorkLogs;

use App\Helpers\WorkLogCountForAYear;
use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use App\Models\WorkScope;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTable extends Component
{
    use WithPagination;

    public Carbon $selected_month;
    #[Url(as: 'bulan')]
    public string $month_translated;

    public $status_index;

    public $workLog_counts_by_statuses;
    public $worklogs_in_a_month;

    #[Url(as: 'carian')]
    // #[Url]
    public $search;

    // ALL          -1
    // ONGOING      0
    // SUBMITTED    1
    // TOREVISE     2
    // COMPLETED    3
    // CLOSED       4

    // public function generateMonths(){
    //     WorkLogCountForAYear::make(now());
    // }

    #[On('select-status')]
    public function selectStatus($selected_status_index) {
        $this->status_index = $selected_status_index;
        // $this->resetPage();
    }

    public function addYear() {
        $this->selected_month->addYear();
        $this->month_translated = $this->selected_month->monthName;
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        $this->initCounts();
        $this->resetPage();
    }

    public function subYear() {
        $this->selected_month->subYear();
        $this->month_translated = $this->selected_month->monthName;
        $this->initCounts();
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        $this->resetPage();
    }

    public function setMonth(string $month_name): void {
        $this->selected_month = new Carbon($month_name);
        $this->month_translated = $this->selected_month->monthName;
        $this->initCounts();
        // $this->worklogs_in_a_month = WorkLogCountForAYear::make($this->selected_month);
        $this->resetPage();
    }

    // public function selectedMonthFormatted() {
    //     $this->selected_month->format('Y-m');
    // }
    public function mount()
    {
        $this->selected_month = now();
        $this->status_index = 0;
        $this->search = '';
        $this->worklogs_in_a_month = array();
    }

    public function render()
    {
        $this->initCounts();
        $status_is_valid = $this->status_index >= 0 & $this->status_index <= 4;
        $_month = $this->selected_month->copy();
        $this->worklogs_in_a_month = WorkLogCountForAYear::make($_month);

        info('Livewire: Rendering');

        $workLogs = auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*');

        // Staff? Evaluator?
        // Staff gets only their worklogs
        // Evaluators gets everything scoped by?
        // Monthlies or dailies, but basically all...
        // They have actions to

        /**
         * - worklogs
         * - Only valid statuses
         * - Selected Months
         * - Follows search
         * - authed user own worklogs
         */

        $workLogs
        ->join('work_scopes','work_scopes.id', '=', 'work_logs.work_scope_id')
        ->join('users','users.id', '=', 'work_logs.author_id')
        ->whereYear('work_logs.created_at', $this->selected_month->year)
        ->whereMonth('work_logs.created_at', $this->selected_month->month)
        ->when($this->status_index != -1, function (Builder $query) {
            $query->where('status', $this->status_index);
        })
        ->when($this->search, function (Builder $query) {
            $query->where(function (Builder $query) {
                $query->whereRaw("LOWER(work_scopes.title) like LOWER('%{$this->search}%')");
                // Add this to query outside of mode:staff scope
                $query->when(!auth()->user()->isStaff(), function (Builder $query) {
                    $query->orWhereRaw("LOWER(users.name) like LOWER('%{$this->search}%')");
                });
            });
        })
        // Includes relationship to scope the created_at
        ->with('latestSubmission')
        ->select('work_logs.*', 'users.name', 'work_scopes.title');

        // ->select('work_logs.*', 'users.name', 'work_scopes.title');
        // ->when($status_is_valid, function (Builder $query) {
        //     $query->where('status', $this->status_index);
        // })->whereMonth('work_logs.created_at', $this->selected_month)
        // ->when($this->search, function (Builder $query) {
        //     $query->where('status', $this->status_index);
        //     // $query->whereRaw("LOWER(users.name) like '%{$this->search}%'");
            // $query->orWhereRaw("work_scopes.title like '%{$this->search}%'");
        //     // $query->whereRaw("LOWER(users.name) like %{$this->search}%");
        //     // $query->orWhere("work_scopes.title like 'asd");
        // });

        // dd($workLogs);


        return view('livewire.work-logs.index-table', [
            'workLogs' => $workLogs->paginate(15),
            'workLog_counts_by_statuses' => $this->workLog_counts_by_statuses,
            'status_index' => $this->status_index,
            'selected_month' => $this->selected_month,
        ]);
    }

    private function initCounts() {
        // Should also count by month but rn it doesnt work like that
        $workLog_count_all = WorkLog::select(DB::raw('COUNT(*) AS count'))
        ->when($this->selected_month, function (Builder $query) {
                $query->whereMonth('created_at', $this->selected_month);
        })->when(auth()->user()->isStaff(), function (Builder $query, bool $isStaff) {
                $query->where('author_id', auth()->user()->id);
        })->first();

        $workLog_count_statuses = WorkLog::select(['status', DB::raw('COUNT(*) AS count')])
        ->when($this->selected_month, function (Builder $query) {
                $query->whereMonth('created_at', $this->selected_month);
        })->when(auth()->user()->isStaff(), function (Builder $query, bool $isStaff) {
                $query->where('author_id', auth()->user()->id);
        })->groupBy('status')->get()->collect();

        $workLog_keyed = $workLog_count_statuses->mapWithKeys(function (WorkLog $item, int $key) {
            return [$item['status'] => $item['count']];
        });

        $workLog_union = collect([-1 => $workLog_count_all['count']])->union($workLog_keyed);

        $this->workLog_counts_by_statuses = collect([-1,0,1,2,3,4])->mapWithKeys(fn($index) => [$index => 0]);

        $workLog_union->each(function(int $count, int $key) {
            $this->workLog_counts_by_statuses[$key] = $count;
        });
    }
}
// https://dev.to/othmane_nemli/laravel-wherehas-and-with-550o

// Author::withWhereHas('books', fn($query) =>
// $query->where('title', 'like', 'PHP%')
// )->get();
