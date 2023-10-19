<?php

namespace App\Livewire\WorkLogs;

use Livewire\Attributes\Url;
use Livewire\Attributes\Computed;
use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTable extends Component
{
    use WithPagination;

    #[Url(as: 'month')]
    public Carbon $selected_month;

    public $status_index;
    public $workLog_by_statuses_count;

    #[Url(as: 'q')]
    public $search;

    // ALL          -1
    // ONGOING      0
    // SUBMITTED    1
    // TOREVISE     2
    // COMPLETED    3
    // CLOSED       4

    public function selectStatus($selected_status_index) {
        $this->resetPage();
        $this->status_index = $selected_status_index;
    }

    // public function selectedMonthFormatted() {
    //     $this->selected_month->format('Y-m');
    // }
    public function mount()
    {
        $this->selected_month = now();
        $this->status_index = 0;
        $this->search = '';

        $workLog_count_all = WorkLog::select(DB::raw('COUNT(*) AS count'))
        ->when(auth()->user()->isStaff(), function (Builder $query, bool $isStaff) {
                $query->where('author_id', auth()->user()->id);
        })
        ->first();

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

        $this->workLog_by_statuses_count = collect([-1,0,1,2,3,4])->mapWithKeys(fn($index) => [$index => 0]);

        $workLog_union->each(function(int $count, int $key) {
            $this->workLog_by_statuses_count[$key] = $count;
        });

    }

    public function render()
    {
        $status_is_valid = $this->status_index >= 0 & $this->status_index <= 4;

        info('asdasd');

        $workLogs = auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*');

        // Staff? Evaluator?
        // Staff gets only their worklogs
        // Evaluators gets everything scoped by?
        // Monthlies or dailies, but basically all...
        // They have actions to


        $workLogs->when($status_is_valid, function (Builder $query) {
            $query->where('status', $this->status_index);
        })->when($this->selected_month, function (Builder $query) {
            $query->whereMonth('work_logs.created_at', $this->selected_month);
        })->when($this->search, function (Builder $query) {
            $query->where('LOWER(users.name)', 'like', "%{$this->search}%");
            $query->orWhere('LOWER(work_scopes.title)', 'like', "%{$this->search}%");
        })->when($this->search, function (Builder $query) {
        })
        ->join('users', 'work_logs.author_id', '=', 'users.id')
        ->join('work_scopes', 'work_logs.work_scope_id', '=', 'work_scopes.id')
        ->select('work_logs.*', 'users.name', 'work_scopes.title');

        return view('livewire.work-logs.index-table', [
            'workLogs' => $workLogs->paginate(15),
            'workLog_counts_by_statuses' => $this->workLog_by_statuses_count,
            'status_index' => $this->status_index,
            'selected_month' => $this->selected_month,
        ]);
    }
}
// https://dev.to/othmane_nemli/laravel-wherehas-and-with-550o

// Author::withWhereHas('books', fn($query) =>
// $query->where('title', 'like', 'PHP%')
// )->get();
