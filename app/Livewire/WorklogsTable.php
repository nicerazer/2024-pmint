<?php

namespace App\Livewire;

use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class WorklogsTable extends Component
{
    use WithPagination;

    public $status_index = 0;
    public $workLog_by_statuses_count = [];

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

    public function render()
    {
        $status_is_valid = $this->status_index >= 0 & $this->status_index <= 4;

        $workLogs = WorkLog::when($status_is_valid, function (Builder $query) {
            $query->where('status', $this->status_index);
        });

        $this->workLog_by_statuses_count = [
            WorkLogHelper::ALL => WorkLog::count(),
            WorkLogHelper::ONGOING => WorkLog::where('status', WorkLogHelper::ONGOING)->count(),
            WorkLogHelper::SUBMITTED => WorkLog::where('status', WorkLogHelper::SUBMITTED)->count(),
            WorkLogHelper::TOREVISE => WorkLog::where('status', WorkLogHelper::TOREVISE)->count(),
            WorkLogHelper::COMPLETED => WorkLog::where('status', WorkLogHelper::COMPLETED)->count(),
            WorkLogHelper::CLOSED => WorkLog::where('status', WorkLogHelper::CLOSED)->count(),
        ];

        return view('livewire.work-logs-table', [
            'workLogs' => $workLogs->paginate(15),
            'workLog_counts_by_statuses' => $this->workLog_by_statuses_count,
            'status_index' => $this->status_index,
        ]);
    }
}
