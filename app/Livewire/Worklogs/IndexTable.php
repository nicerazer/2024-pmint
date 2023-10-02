<?php

namespace App\Livewire\WorkLogs;

use App\Helpers\WorkLogHelper;
use App\Models\WorkLog;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class IndexTable extends Component
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

        $this->workLog_by_statuses_count = [
            WorkLogHelper::ALL => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->count(),
            WorkLogHelper::ONGOING => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->where('status', WorkLogHelper::ONGOING)->count(),
            WorkLogHelper::SUBMITTED => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->where('status', WorkLogHelper::SUBMITTED)->count(),
            WorkLogHelper::TOREVISE => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->where('status', WorkLogHelper::TOREVISE)->count(),
            WorkLogHelper::COMPLETED => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->where('status', WorkLogHelper::COMPLETED)->count(),
            WorkLogHelper::CLOSED => (auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*'))->where('status', WorkLogHelper::CLOSED)->count(),
        ];


        $workLogs = auth()->user()->isStaff() ? auth()->user()->workLogs() : WorkLog::select('*');

        $workLogs->when($status_is_valid, function (Builder $query) {
            $query->where('status', $this->status_index);
        });

        return view('livewire.work-logs.index-table', [
            'workLogs' => $workLogs->paginate(15),
            'workLog_counts_by_statuses' => $this->workLog_by_statuses_count,
            'status_index' => $this->status_index,
        ]);
    }
}
// ->when(auth()->user()->isStaff, function (Builder $query) {
//     return $query->withWhereHas('author', function(Builder $query) {
//         $query->where('role', '4');
//     });
// });

// https://dev.to/othmane_nemli/laravel-wherehas-and-with-550o

// Author::withWhereHas('books', fn($query) =>
// $query->where('title', 'like', 'PHP%')
// )->get();
